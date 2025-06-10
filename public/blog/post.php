<?php
// post.php

// --- INÍCIO: LINHAS DE DEPURACÃO (REMOVA EM PRODUÇÃO!) ---
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// --- FIM: LINHAS DE DEPURACÃO ---

require_once 'includes/db_config.php';

$post = null;
if (isset($_GET['slug'])) {
    $slug = $_GET['slug'];
    try {
        $stmt = $pdo->prepare("SELECT * FROM posts WHERE slug = :slug AND status = 'published' LIMIT 1");
        $stmt->bindParam(':slug', $slug, PDO::PARAM_STR);
        $stmt->execute();
        $post = $stmt->fetch();
    } catch (PDOException $e) {
        error_log("Erro ao buscar post: " . $e->getMessage());
    }
}

// Se o post não foi encontrado, encerra a execução para evitar erros
if (!$post) {
    // Redireciona para uma página de erro ou exibe uma mensagem
    header('Location: index.php'); // Ou uma página 404 customizada
    exit();
}

// Funções para buscar posts relacionados ou outros posts (para "mais lidos")
function get_related_posts($pdo, $current_post_id, $limit = 3) {
    try {
        // Busca outros posts publicados, excluindo o atual, ordenando aleatoriamente ou por data
        $stmt = $pdo->prepare("SELECT * FROM posts WHERE status = 'published' AND id != :current_id ORDER BY RAND() LIMIT :limit");
        $stmt->bindParam(':current_id', $current_post_id, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (PDOException | Exception $e) { // Adicionada Exception para capturar outros erros
        error_log("Erro ao buscar posts relacionados: " . $e->getMessage());
        return [];
    }
}
$related_posts = get_related_posts($pdo, $post->id);

// Função para buscar guias publicados (NOVO)
function get_published_guides($pdo, $limit = 3) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM guides WHERE status = 'published' ORDER BY created_at DESC LIMIT :limit");
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log("Erro ao buscar guias publicados: " . $e->getMessage());
        return [];
    }
}
$published_guides = get_published_guides($pdo);


// Informações para compartilhamento social
$current_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$share_title = urlencode($post->title);
$share_url = urlencode($current_url);

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $post ? htmlspecialchars($post->title) . ' - Blog Seguir Play' : 'Post Não Encontrado - Blog Seguir Play'; ?></title>
    <meta name="description" content="<?php echo $post ? htmlspecialchars($post->meta_description) : 'Conteúdo do Blog Seguir Play.'; ?>">
    <meta name="keywords" content="<?php echo $post ? htmlspecialchars($post->meta_keywords) : 'Seguir Play, blog, notícias'; ?>">
    <link rel="stylesheet" href="css/style.css">
    <!-- Google Fonts - Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome (ainda usado para alguns ícones se necessário, mas sociais são SVG) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Google Analytics (coloque seu ID de rastreamento aqui) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-XXXXXXXXX-X"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'UA-XXXXXXXXX-X'); // Substitua UA-XXXXXXXXX-X pelo seu ID de rastreamento do Google Analytics
    </script>

    <!-- Google Tag Manager (coloque seu GTM ID aqui) -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-XXXXXXX');</script>
    <!-- End Google Tag Manager -->
</head>
<body class="font-poppins bg-gray-100 text-gray-800 flex flex-col min-h-screen">
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-XXXXXXX"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <header class="bg-gradient-to-r from-[#952852] to-[#781F60] text-white py-3 shadow-lg rounded-b-lg">
        <div class="container mx-auto px-4 flex items-center justify-between flex-wrap">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="https://seguirplay.com/blog" rel="home">
                    <img src="https://seguirplay.com/web_assets/img/logo.png" class="h-10 md:h-12 w-auto">
                </a>
                <h1 class="sr-only">
                    <a href="https://blog.seguirplay.com/" rel="home">Blog Seguir Play</a>
                </h1>
                <p class="sr-only">Descubra um universo de conhecimento e insights estratégicos em nosso site especializado.</p>
            </div>

            <!-- Botão Hamburguer (Mobile) -->
            <button class="md:hidden text-white focus:outline-none ml-auto" id="mobile-nav-toggler" type="button" aria-label="Menu" aria-controls="primary-navigation" aria-expanded="false">
                <span class="block w-8 h-8">
                    <img src="https://seguirplay.com/web_assets/img/icons8-cardápio.svg" alt="Menu" class="max-w-full h-auto" style="filter: brightness(0) invert(1);">
                </span>
            </button>

            <!-- Navegação Principal e Widgets (Desktop) -->
            <div id="primary-navigation-content" class="hidden md:flex md:flex-row md:items-center w-full md:w-auto mt-4 md:mt-0">
                <nav class="flex-grow">
                    <ul class="flex flex-col md:flex-row md:space-x-6 text-lg font-semibold w-full md:w-auto">
                        <li class="nav-item">
                            <a class="nav-link hover:text-pink-200 transition-colors duration-300 block py-2 md:py-0" href="https://www.seguirplay.com/">Serviços</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link hover:text-pink-200 transition-colors duration-300 block py-2 md:py-0" href="https://www.seguirplay.com/contato">Contato</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link hover:text-pink-200 transition-colors duration-300 block py-2 md:py-0" href="https://www.monetizeseucanal.seguirplay.com/">Monetize seu Canal</a>
                        </li>
                    </ul>
                </nav>

                <!-- Widgets do Cabeçalho -->
                <div class="flex items-center space-x-4 ml-auto md:ml-6 mt-4 md:mt-0">
                    <!-- Ícones Sociais (Escondidos em mobile/tablet pelo exemplo) -->
                    <div class="hidden lg:flex items-center space-x-3 text-white">
                        <a href="https://www.facebook.com/" target="_blank" aria-label="Facebook" class="block transform hover:scale-110 transition-transform duration-200 social-icon">
                            <svg class="w-6 h-6 fill-current" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><path d="M18.518 32.438V17.799h4.88l.751-5.693h-5.631V8.477c0-1.627.438-2.753 2.815-2.753h3.003V.657c-.5-.125-2.315-.25-4.379-.25-4.379 0-7.32 2.628-7.32 7.507v4.192H7.695v5.693h4.942v14.639z"></path></svg>
                        </a>
                        <a href="https://twitter.com/" target="_blank" aria-label="Twitter" class="block transform hover:scale-110 transition-transform duration-200 social-icon">
                            <svg class="w-6 h-6 fill-current" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M14.258 10.152 23.176 0h-2.113l-7.747 8.813L7.133 0H0l9.352 13.328L0 23.973h2.113l8.176-9.309 6.531 9.309h7.133zm-2.895 3.293-.949-1.328L2.875 1.56h3.246l6.086 8.523.945 1.328 7.91 11.078h-3.246zm0 0"></path></svg>
                        </a>
                        <a href="https://t.me/" target="_blank" aria-label="Telegram" class="block transform hover:scale-110 transition-transform duration-200 social-icon">
                            <svg class="w-6 h-6 fill-current" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 27"><path fill-rule="evenodd" d="M24.512 26.372c.43.304.983.38 1.476.193.494-.188.857-.609.966-1.12C28.113 20 30.924 6.217 31.978 1.264a1.041 1.041 0 0 0-.347-1.01c-.293-.25-.7-.322-1.063-.187C24.979 2.136 7.762 8.596.724 11.2a1.102 1.102 0 0 0-.722 1.065c.016.472.333.882.79 1.019 3.156.944 7.299 2.257 7.299 2.257s1.936 5.847 2.945 8.82c.127.374.419.667.804.768.384.1.795-.005 1.082-.276l4.128-3.897s4.762 3.492 7.463 5.416Zm-14.68-11.57 2.24 7.385.497-4.676 13.58-12.248a.37.37 0 0 0 .043-.503.379.379 0 0 0-.5-.085L9.831 14.803Z"></path></svg>
                        </a>
                        <a href="https://www.instagram.com/" target="_blank" aria-label="Instagram" class="block transform hover:scale-110 transition-transform duration-200 social-icon">
                            <svg class="w-6 h-6 fill-current" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><path d="M16.016 3.284c4.317 0 4.755.063 6.444.125 1.627.063 2.44.313 3.003.5.751.313 1.314.688 1.814 1.189.563.563.938 1.126 1.189 1.814.25.626.5 1.439.563 3.003.063 1.752.125 2.19.125 6.506s-.063 4.755-.125 6.444c-.063 1.627-.313 2.44-.5 3.003-.313.751-.688 1.314-1.189 1.814-.563.563-1.126.938-1.814 1.189-.626.25-1.439.5-3.003.563-1.752.063-2.19.125-6.506.125s-4.755-.063-6.444-.125c-1.627-.063-2.44-.313-3.003-.5-.751-.313-1.314-.688-1.814-1.189-.563-.563-.938-1.126-1.189-1.814-.25-.626-.5-1.439-.563-3.003-.063-1.752-.125-2.19-.125-6.506s.063-4.755.125-6.444c.063-1.627.313-2.44.5-3.003.313-.751.688-1.314 1.189-1.814.563-.563 1.126-.938 1.814-1.189.626-.25 1.439-.5 3.003-.563 1.752-.063 2.19-.125 6.506-.125m0-2.877c-4.379 0-4.88.063-6.569.125-1.752.063-2.94.313-3.879.688-1.064.438-2.002 1.001-2.878 1.877S1.251 4.911.813 5.975C.438 6.976.187 8.102.125 9.854.062 11.543 0 12.044 0 16.423s.063 4.88.125 6.569c.063 1.752.313 2.94.688 3.879.438 1.064 1.001 2.002 1.877 2.878s1.814 1.439 2.878 1.877c1.001.375 2.127.626 3.879.688 1.689.063 2.19.125 6.569.125s4.88-.063 6.569-.125c1.752-.063 2.94-.313 3.879-.688 1.064-.438 2.002-1.001 2.878-1.877s1.439-1.814 1.877-2.878c.375-1.001.626-2.127.688-3.879.063-1.689.125-2.19.125-6.569s-.063-4.88-.125-6.569c-.063-1.752-.313-2.94-.688-3.879-.438-1.064-1.001-2.002-1.877-2.878s-1.814-1.439-2.878-1.877C25.463.845 24.337.594 22.585.532c-1.689-.063-2.19-.125-6.569-.125zm0 7.757c-4.567 0-8.258 3.691-8.258 8.258s3.691 8.258 8.258 8.258c4.567 0 8.258-3.691 8.258-8.258s-3.691-8.258-8.258-8.258zm0 13.639c-2.94 0-5.38-2.44-5.38-5.38s2.44-5.38 5.38-5.38 5.38 2.44 5.38 5.38-2.44 5.38-5.38 5.38zM26.463 7.851c0 1.064-.813 1.939-1.877 1.939s-1.939-.876-1.939-1.939c0-1.064.876-1.877 1.939-1.877s1.877.813 1.877 1.877z"></path></svg>
                        </a>
                    </div>
                    
                    <!-- Dark Mode Toggle -->
                    <div class="hidden lg:block">
                        <label class="flex items-center cursor-pointer" for="lightdarkswitch">
                            <div class="relative">
                                <input type="checkbox" id="lightdarkswitch" class="sr-only">
                                <div class="block bg-gray-600 w-14 h-8 rounded-full"></div>
                                <div class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition transform duration-300"></div>
                            </div>
                        </label>
                    </div>

                    <!-- Search Icon and Form -->
                    <div class="relative" aria-haspopup="true">
                        <a href="#" class="text-white text-2xl hover:text-pink-200 transition-colors duration-300" id="search-toggle-btn" aria-label="Search">
                            <i class="fas fa-search"></i>
                        </a>
                        <div id="search-form-container" class="absolute hidden right-0 mt-2 p-4 bg-white text-gray-800 rounded-lg shadow-lg w-64 z-50">
                            <form role="search" aria-label="Site Search" method="get" class="flex items-center space-x-2 w-full" action="https://blog.seguirplay.com/">
                                <label class="sr-only" for="search-input">Search for:</label>
                                <input type="search" id="search-input" class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-pink-500 text-gray-900" placeholder="Search" value="" name="s" autocomplete="off">
                                <button type="submit" class="bg-[#FF455B] text-white p-2 rounded hover:bg-[#FF6E04] transition-colors duration-300">
                                    <i class="fas fa-arrow-right"></i>
                                </button>
                                <button type="button" class="absolute top-1 right-1 text-gray-500 hover:text-gray-800" id="search-close-btn" aria-label="Close Search">
                                    <i class="fas fa-times"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Botão QUERO TURBINAR -->
                    <div class="hidden md:block">
                        <a href="https://www.seguirplay.com/" class="bg-[#FF455B] hover:bg-[#FF6E04] text-white font-bold py-2 px-4 rounded-full transition-colors duration-300" target="_blank" rel="noopener noreferrer" role="button">
                            QUERO TURBINAR
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="container mx-auto p-4 md:p-8 flex-grow">
        <article class="bg-white rounded-xl shadow-md p-6 lg:p-8 mb-8">
            <?php if (!empty($post->featured_image)): ?>
                <img src="<?php echo $post->featured_image; ?>" alt="<?php echo htmlspecialchars($post->title); ?>" class="w-full h-64 object-cover rounded-lg mb-6">
            <?php else: ?>
                <div class="w-full h-64 flex items-center justify-center text-white text-2xl font-bold rounded-lg mb-6" style="background: linear-gradient(257.28deg, #FF455B 0%, #FF6E04 100%);">
                    [Image of Placeholder]
                </div>
            <?php endif; ?>
            <h1 class="text-4xl font-extrabold text-gray-900 mb-4"><?php echo htmlspecialchars($post->title); ?></h1>
            <div class="flex justify-start items-center text-sm text-gray-500 mb-6 space-x-4">
                <span><i class="fas fa-user-circle mr-1"></i> <?php echo htmlspecialchars($post->author); ?></span>
                <span><i class="fas fa-calendar-alt mr-1"></i> <?php echo date("d/m/Y H:i", strtotime($post->published_at)); ?></span>
            </div>
            <div class="prose max-w-none leading-relaxed text-lg text-gray-800">
                <?php echo $post->content; ?>
            </div>
            <div class="mt-8 flex justify-between items-center flex-wrap gap-4">
                <a href="/" class="inline-flex items-center bg-[#781F60] text-white font-semibold py-3 px-6 rounded-full hover:bg-[#952852] transition-colors duration-300">
                    <i class="fas fa-arrow-left mr-2"></i> Voltar para o Blog
                </a>
                
                <!-- Botões de Compartilhamento em Redes Sociais -->
                <div class="flex space-x-3">
                    <span class="text-gray-700 font-semibold text-lg">Compartilhe:</span>
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $share_url; ?>&quote=<?php echo $share_title; ?>" target="_blank" class="text-blue-600 hover:text-blue-800 text-2xl" aria-label="Compartilhar no Facebook">
                        <i class="fab fa-facebook-square"></i>
                    </a>
                    <a href="https://twitter.com/intent/tweet?text=<?php echo $share_title; ?>&url=<?php echo $share_url; ?>" target="_blank" class="text-blue-400 hover:text-blue-600 text-2xl" aria-label="Compartilhar no X (Twitter)">
                        <i class="fab fa-x-twitter"></i>
                    </a>
                    <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $share_url; ?>&title=<?php echo $share_title; ?>" target="_blank" class="text-blue-700 hover:text-blue-900 text-2xl" aria-label="Compartilhar no LinkedIn">
                        <i class="fab fa-linkedin"></i>
                    </a>
                    <a href="https://api.whatsapp.com/send?text=<?php echo $share_title; ?>%20-%20<?php echo $share_url; ?>" target="_blank" class="text-green-500 hover:text-green-700 text-2xl" aria-label="Compartilhar no WhatsApp">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                </div>
            </div>
        </article>

        <!-- Seção de Artigos Mais Lidos da Semana (ou Relacionados) -->
        <section class="bg-white rounded-xl shadow-md p-6 lg:p-8 mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-3 border-gray-200">Artigos Mais Lidos da Semana</h2>
            <?php if (!empty($related_posts)): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <?php foreach ($related_posts as $r_post): ?>
                        <div class="flex items-start space-x-4">
                            <?php if (!empty($r_post->featured_image)): ?>
                                <img src="<?php echo $r_post->featured_image; ?>" alt="<?php echo htmlspecialchars($r_post->title); ?>" class="w-24 h-16 object-cover rounded-md flex-shrink-0">
                            <?php else: ?>
                                <div class="w-24 h-16 bg-gray-200 rounded-md flex-shrink-0 flex items-center justify-center text-gray-500 text-sm">
                                    [Image]
                                </div>
                            <?php endif; ?>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 leading-tight">
                                    <a href="post.php?slug=<?php echo htmlspecialchars($r_post->slug); ?>" class="hover:text-[#FF455B]"><?php echo htmlspecialchars($r_post->title); ?></a>
                                </h3>
                                <p class="text-sm text-gray-600 line-clamp-2"><?php echo substr(strip_tags($r_post->content), 0, 80); ?>...</p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="text-gray-600">Nenhum artigo relacionado encontrado no momento.</p>
            <?php endif; ?>
            <p class="text-sm text-gray-500 mt-4">
                *Esta seção exibe outros artigos publicados. Para 'mais lidos', um sistema de contagem de visualizações seria necessário.
            </p>
        </section>

        <!-- Seção de Guias Dinâmicos (NOVO) -->
        <section class="bg-white rounded-xl shadow-md p-6 lg:p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-3 border-gray-200">Guias da Seguir Play</h2>
            <?php if (!empty($published_guides)): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($published_guides as $guide_item): ?>
                        <a href="<?php echo htmlspecialchars($guide_item->url); ?>" class="block bg-gray-50 p-4 rounded-lg hover:bg-gray-100 transition-colors duration-200 text-gray-800">
                            <?php if (!empty($guide_item->image)): ?>
                                <img src="<?php echo htmlspecialchars($guide_item->image); ?>" alt="<?php echo htmlspecialchars($guide_item->title); ?>" class="w-full h-32 object-cover rounded-md mb-3">
                            <?php else: ?>
                                <div class="w-full h-32 bg-gray-200 rounded-md mb-3 flex items-center justify-center text-gray-500 text-sm">
                                    [Image]
                                </div>
                            <?php endif; ?>
                            <h3 class="font-semibold text-lg"><i class="fas fa-book mr-2 text-[#781F60]"></i> <?php echo htmlspecialchars($guide_item->title); ?></h3>
                            <p class="text-sm text-gray-600 line-clamp-2"><?php echo htmlspecialchars($guide_item->description); ?></p>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="text-gray-600">Nenhum guia publicado ainda. Volte em breve!</p>
            <?php endif; ?>
        </section>

    </main>

    <footer class="bg-gray-800 text-white p-6 mt-12 rounded-t-lg">
        <div class="container mx-auto text-center text-sm">
            <p>&copy; <?php echo date("Y"); ?> Seguir Play Blog. Todos os direitos reservados.</p>
            <p class="mt-2">
                <a href="#" class="text-gray-400 hover:text-white mx-2">Política de Privacidade</a> |
                <a href="#" class="text-gray-400 hover:text-white mx-2">Termos de Uso</a>
            </p>
        </div>
    </footer>

    <!-- Tailwind CSS (CDN para prototipagem rápida) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        poppins: ['Poppins', 'sans-serif'], // Define Poppins como fonte padrão do Tailwind
                    },
                    colors: {
                        seguirPlayPrimary: '#952852',
                        seguirPlaySecondary: '#781F60',
                        seguirPlayAccent1: '#FF455B',
                        seguirPlayAccent2: '#FF6E04',
                    },
                }
            }
        }
    </script>
    <!-- jQuery (necessário para o Summernote no dashboard, mas incluído aqui para consistência) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>
