<?php
// index.php

// --- INÍCIO: LINHAS DE DEPURACÃO (REMOVA EM PRODUÇÃO!) ---
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// --- FIM: LINHAS DE DEPURACÃO ---

require_once 'includes/db_config.php'; // Inclui o arquivo de configuração do banco de dados

// Verifica se a conexão PDO foi estabelecida com sucesso
if (!isset($pdo) || $pdo === null) {
    echo "<div style='background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; padding: 15px; margin: 20px; border-radius: 8px;'>";
    echo "<h1>Erro Crítico: Conexão com o Banco de Dados Indisponível!</h1>";
    echo "<p>O blog não pode exibir conteúdo porque a conexão com o banco de dados falhou. Por favor, verifique as configurações do banco de dados.</p>";
    echo "</div>";
    exit(); 
}


// Função para buscar posts do banco de dados local
function get_posts($pdo, $limit = 10) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM posts WHERE status = 'published' ORDER BY published_at DESC LIMIT :limit");
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (PDOException | Exception $e) { 
        error_log("Erro ao buscar posts no frontend: " . $e->getMessage());
        echo "<div style='background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; padding: 15px; margin: 20px; border-radius: 8px;'>";
        echo "<h1>Erro ao Carregar Posts</h1>";
        echo "<p>Não foi possível carregar os posts do blog no momento. Por favor, tente novamente mais tarde.</p>";
        echo "</div>";
        return [];
    }
}

$posts = get_posts($pdo); // Obtém os posts publicados do DB local
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Seguir Play - Notícias e Conteúdos Exclusivos</title>
    <meta name="description" content="Fique por dentro das últimas notícias, tutoriais e artigos exclusivos da Seguir Play. Tudo sobre tecnologia, streaming e entretenimento.">
    <meta name="keywords" content="Seguir Play, blog, notícias, tecnologia, streaming, entretenimento, artigos, tutoriais">
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
                <a href="https://blog.seguirplay.com/" rel="home">
                    <img src="https://seguirplay.com/web_assets/img/logo.png" alt="Blog Seguir Play" class="h-10 md:h-12 w-auto">
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
                    <div> <!-- Removido hidden lg:block para visibilidade em todas as versões -->
                        <label class="flex items-center cursor-pointer" for="lightdarkswitch">
                            <div class="relative">
                                <input type="checkbox" id="lightdarkswitch" class="sr-only">
                                <div class="block bg-gray-600 w-14 h-8 rounded-full"></div>
                                <div class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition transform duration-300"></div>
                            </div>
                        </label>
                    </div>

                    <!-- Search Icon and Form - Removido -->
                    <!-- <div class="relative" aria-haspopup="true">
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
                    </div> -->

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
        <section id="hero" class="text-center py-16 px-4 mb-12 rounded-xl" style="background: linear-gradient(257.28deg, #FF455B 0%, #FF6E04 100%); color: white;">
            <h2 class="text-4xl md:text-5xl font-extrabold mb-4 animate-fade-in-down">Bem-vindo ao Blog Seguir Play!</h2>
            <p class="text-xl md:text-2xl opacity-90 animate-fade-in-up">Descubra o universo do streaming, tecnologia e muito mais.</p>
            <a href="#posts" class="mt-8 inline-block bg-white text-[#FF455B] font-bold py-3 px-8 rounded-full shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                Ver Últimos Artigos <i class="fas fa-chevron-down ml-2"></i>
            </a>
        </section>

        <section id="posts" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php if (!empty($posts)): ?>
                <?php foreach ($posts as $post): ?>
                    <article class="bg-white rounded-xl shadow-md overflow-hidden transform hover:scale-105 transition-transform duration-300 ease-in-out border border-transparent hover:border-pink-300">
                        <?php if (!empty($post->featured_image)): ?>
                            <img src="<?php echo $post->featured_image; ?>" alt="<?php echo htmlspecialchars($post->title); ?>" class="w-full h-48 object-cover">
                        <?php else: ?>
                            <div class="w-full h-48 flex items-center justify-center text-white text-xl font-bold rounded-t-xl" style="background: linear-gradient(257.28deg, #FF455B 0%, #FF6E04 100%);">
                                                            </div>
                        <?php endif; ?>
                        <div class="p-6">
                            <h3 class="text-2xl font-bold text-gray-900 mb-3 leading-tight"><a href="post.php?slug=<?php echo htmlspecialchars($post->slug); ?>" class="hover:text-[#FF455B]"><?php echo htmlspecialchars($post->title); ?></a></h3>
                            <p class="text-gray-700 text-base mb-4 line-clamp-3"><?php echo substr($post->content, 0, 150); ?>...</p>
                            <div class="flex justify-between items-center text-sm text-gray-500 mb-4">
                                <span><i class="fas fa-user-circle mr-1"></i> <?php echo htmlspecialchars($post->author); ?></span>
                                <span><i class="fas fa-calendar-alt mr-1"></i> <?php echo date("d/m/Y", strtotime($post->published_at)); ?></span>
                            </div>
                            <!-- Botão "Ler Mais" centralizado com mt-4 e mb-4 para espaçamento -->
                            <div class="mt-4 mb-4 text-center">
                                <a href="post.php?slug=<?php echo htmlspecialchars($post->slug); ?>" class="inline-block bg-[#FF455B] text-white font-semibold py-2 px-5 rounded-full hover:bg-[#FF6E04] transition-colors duration-300 ease-in-out">
                                    Ler Mais <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="col-span-full text-center text-lg text-gray-600 py-10">Nenhum post publicado ainda. Volte em breve!</p>
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
                        // Novas cores para o botão do blog externo
                        externalBlogButton: '#ff7200',
                        externalBlogButtonHover: '#c7681a',
                    },
                    keyframes: {
                        'fade-in-down': {
                            '0%': { opacity: '0', transform: 'translateY(-20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        'fade-in-up': {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        }
                    },
                    animation: {
                        'fade-in-down': 'fade-in-down 0.6s ease-out forwards',
                        'fade-in-up': 'fade-in-up 0.6s ease-out forwards 0.2s',
                    }
                }
            }
        }
    </script>
    <!-- jQuery (necessário para o Summernote no dashboard, mas incluído aqui para consistência) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/script.js"></script>
  
</body>
</html>