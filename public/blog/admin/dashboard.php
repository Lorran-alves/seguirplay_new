<?php
// admin/dashboard.php

// Inclui o arquivo de autenticação. Se o usuário não estiver logado,
// auth.php exibirá o formulário de login e encerrará a execução do script.
require_once 'auth.php';


// Inclui o arquivo de configuração do banco de dados.
// É importante que este seja incluído APÓS a autenticação,
// para que a conexão só seja tentada se o usuário estiver logado.
require_once '../includes/db_config.php';

// Lógica de logout (permanece aqui, já que é uma acão direta do dashboard)
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: dashboard.php');
    exit();
}

// Geração de slug a partir do título
function generate_slug($title) {
    $slug = strtolower($title);
    $slug = preg_replace('/[^\w\s-]/', '', $slug); // Remove caracteres especiais
    $slug = preg_replace('/\s+/', '-', $slug);    // Substitui espaços por hífens
    $slug = trim($slug, '-');                     // Remove hífens extras do início/fim
    return $slug;
}

$message = ''; // Mensagem para feedback ao utilizador
$error = '';   // Mensagem de erro

// Lógica para adicionar/editar post
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_post'])) {
    $title = trim($_POST['title'] ?? '');
    // Importante: Summernote (assim como TinyMCE) envia o conteúdo HTML, então NÃO use htmlspecialchars para o content.
    $content = $_POST['content'] ?? ''; 
    $author = trim($_POST['author'] ?? 'Seguir Play');
    $status = $_POST['status'] ?? 'draft'; 
    $meta_description = trim($_POST['meta_description'] ?? '');
    $meta_keywords = trim($_POST['meta_keywords'] ?? '');
    // O campo featured_image agora virá diretamente do input hidden (preenchido por JS se upload ocorrer)
    $featured_image = trim($_POST['featured_image'] ?? ''); 
    $post_id = $_POST['post_id'] ?? null;

    if (empty($title) || empty($content)) {
        $error = "Título e conteúdo não podem ser vazios.";
    } else {
        $slug = generate_slug($title);
        if ($post_id) {
            // Editar post existente
            $stmt = $pdo->prepare("UPDATE posts SET title = :title, slug = :slug, content = :content, author = :author, status = :status, meta_description = :meta_description, meta_keywords = :meta_keywords, featured_image = :featured_image WHERE id = :id");
            $stmt->bindParam(':id', $post_id, PDO::PARAM_INT);
            $message = "Post atualizado com sucesso!";
        } else {
            // Criar novo post
            $stmt = $pdo->prepare("INSERT INTO posts (title, slug, content, author, status, meta_description, meta_keywords, featured_image) VALUES (:title, :slug, :content, :author, :status, :meta_description, :meta_keywords, :featured_image)");
            $message = "Post criado com sucesso!";
        }
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':slug', $slug, PDO::PARAM_STR);
        $stmt->bindParam(':content', $content, PDO::PARAM_STR); // Salva o HTML gerado pelo Summernote
        $stmt->bindParam(':author', $author, PDO::PARAM_STR);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->bindParam(':meta_description', $meta_description, PDO::PARAM_STR);
        $stmt->bindParam(':meta_keywords', $meta_keywords, PDO::PARAM_STR);
        $stmt->bindParam(':featured_image', $featured_image, PDO::PARAM_STR);

        try {
            $stmt->execute();
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) { // Código de erro para entrada duplicada (slug UNIQUE)
                $error = "Já existe um post com este título. Por favor, escolha outro.";
            } else {
                $error = "Erro ao salvar o post: " . $e->getMessage();
            }
        }
    }
}

// Lógica para excluir post
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_post'])) {
    $post_id_to_delete = $_POST['post_id_to_delete'] ?? null;
    if ($post_id_to_delete) {
        try {
            $stmt = $pdo->prepare("DELETE FROM posts WHERE id = :id");
            $stmt->bindParam(':id', $post_id_to_delete, PDO::PARAM_INT);
            $stmt->execute();
            $message = "Post excluído com sucesso!";
        } catch (PDOException $e) {
            $error = "Erro ao excluir o post: " . $e->getMessage(); 
        }
    } else {
        $error = "ID do post para exclusão não fornecido.";
    }
}

// Lógica para adicionar/editar guia (NOVA LÓGICA DE GUIA)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_guide'])) {
    $title = trim($_POST['guide_title'] ?? '');
    $description = trim($_POST['guide_description'] ?? '');
    $url = trim($_POST['guide_url'] ?? '');
    $image = trim($_POST['guide_image'] ?? '');
    $status = $_POST['guide_status'] ?? 'draft';
    $guide_id = $_POST['guide_id'] ?? null;

    if (empty($title) || empty($description)) {
        $error = "Título e descrição do guia não podem ser vazios.";
    } else {
        $slug = generate_slug($title); // Reutiliza a função de slug
        if ($guide_id) {
            // Editar guia existente
            $stmt = $pdo->prepare("UPDATE guides SET title = :title, slug = :slug, description = :description, url = :url, image = :image, status = :status WHERE id = :id");
            $stmt->bindParam(':id', $guide_id, PDO::PARAM_INT);
            $message = "Guia atualizado com sucesso!";
        } else {
            // Criar novo guia
            $stmt = $pdo->prepare("INSERT INTO guides (title, slug, description, url, image, status) VALUES (:title, :slug, :description, :url, :image, :status)");
            $message = "Guia criado com sucesso!";
        }
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':slug', $slug, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':url', $url, PDO::PARAM_STR);
        $stmt->bindParam(':image', $image, PDO::PARAM_STR);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);

        try {
            $stmt->execute();
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) { // Código de erro para entrada duplicada (slug UNIQUE)
                $error = "Já existe um guia com este título. Por favor, escolha outro.";
            } else {
                $error = "Erro ao salvar o guia: " . $e->getMessage();
            }
        }
    }
}

// Lógica para excluir guia (NOVA LÓGICA DE GUIA)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_guide'])) {
    $guide_id_to_delete = $_POST['guide_id_to_delete'] ?? null;
    if ($guide_id_to_delete) {
        try {
            $stmt = $pdo->prepare("DELETE FROM guides WHERE id = :id");
            $stmt->bindParam(':id', $guide_id_to_delete, PDO::PARAM_INT);
            $stmt->execute();
            $message = "Guia excluído com sucesso!";
        } catch (PDOException $e) {
            $error = "Erro ao excluir o guia: " . $e->getMessage();
        }
    } else {
        $error = "ID do guia para exclusão não fornecido.";
    }
}

// Lógica para buscar guia para edicão (NOVA LÓGICA DE GUIA)
$edit_guide = null;
if (isset($_GET['edit_guide_id'])) {
    $edit_guide_id = $_GET['edit_guide_id'];
    try {
        $stmt = $pdo->prepare("SELECT * FROM guides WHERE id = :id");
        $stmt->bindParam(':id', $edit_guide_id, PDO::PARAM_INT);
        $stmt->execute();
        $edit_guide = $stmt->fetch();
    } catch (PDOException $e) {
        $error = "Erro ao carregar guia para edicão: " . $e->getMessage();
    }
}


// Lógica para alterar senha de utilizador
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password_submit'])) {
    $user_id_to_change_password = $_POST['user_id_to_change_password'] ?? null;
    $new_password = $_POST['new_password'] ?? '';
    $confirm_new_password = $_POST['confirm_new_password'] ?? '';

    if (empty($user_id_to_change_password) || empty($new_password) || empty($confirm_new_password)) {
        $error = "Todos os campos de senha são obrigatórios.";
    } elseif (strlen($new_password) < 6) { // Adiciona validacão simples de comprimento de senha
        $error = "A nova senha deve ter pelo menos 6 caracteres.";
    } elseif ($new_password !== $confirm_new_password) {
        $error = "As senhas não coincidem.";
    } else {
        try {
            // Hashing da nova senha com SHA-256
            $hashed_new_password = hash('sha256', $new_password); 

            $stmt = $pdo->prepare("UPDATE users SET password = :password WHERE id = :id");
            $stmt->bindParam(':password', $hashed_new_password, PDO::PARAM_STR);
            $stmt->bindParam(':id', $user_id_to_change_password, PDO::PARAM_INT);
            $stmt->execute();
            $message = "Senha do utilizador atualizada com sucesso!";
        } catch (PDOException $e) {
            $error = "Erro ao alterar a senha: " . $e->getMessage();
        }
    }
}


// Lógica para buscar post para edicão
$edit_post = null;
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    try {
        $stmt = $pdo->prepare("SELECT * FROM posts WHERE id = :id");
        $stmt->bindParam(':id', $edit_id, PDO::PARAM_INT);
        $stmt->execute();
        $edit_post = $stmt->fetch();
    } catch (PDOException $e) {
        $error = "Erro ao carregar post para edicão: " . $e->getMessage();
    }
}

// Funão para buscar todos os posts para exibicão na lista
function get_all_posts($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM posts ORDER BY published_at DESC");
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log("Erro ao buscar todos os posts: " . $e->getMessage());
        return [];
    }
}
$all_posts = get_all_posts($pdo);

// Funão para buscar todos os utilizadores (novo)
function get_all_users($pdo) {
    try {
        $stmt = $pdo->query("SELECT id, username, email, created_at FROM users ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }
    catch (PDOException $e) {
        error_log("Erro ao buscar utilizadores: " . $e->getMessage());
        return [];
    }
}
$all_users = get_all_users($pdo); // Obtenha a lista de utilizadores

// Funão para buscar todos os guias (NOVO)
function get_all_guides($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM guides ORDER BY created_at DESC");
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log("Erro ao buscar guias: " . $e->getMessage());
        return [];
    }
}
$all_guides = get_all_guides($pdo); // Obtenha a lista de guias


// Logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: dashboard.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Seguir Play Blog</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Google Fonts - Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <!-- jQuery (necessário para Summernote) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Summernote Lite CSS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <!-- Summernote Lite JS -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

    <script>
        $(document).ready(function() {
            // Inicializacão do Summernote para o campo de conteúdo
            $('#content').summernote({
                height: 400, // Altura do editor
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']], // Adicionado vídeo também
                    ['view', ['fullscreen', 'code', 'help']] // Opções de visualizacão, código HTML e ajuda
                ],
                callbacks: {
                    onImageUpload: function(files) {
                        // Implementacão de upload de imagem para Summernote
                        var editor = $(this);
                        var data = new FormData();
                        data.append('file', files[0]);

                        $.ajax({
                            url: 'post_image_upload.php', 
                            cache: false,
                            contentType: false,
                            processData: false,
                            data: data,
                            type: 'POST',
                            dataType: 'json', 
                            success: function(response) {
                                if (response && response.location) {
                                    editor.summernote('insertImage', response.location);
                                } else {
                                    // Melhorar a mensagem de erro se a resposta não for conforme o esperado
                                    alert('Erro ao fazer upload da imagem: ' + (response.error || 'Resposta inválida do servidor.'));
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                alert('Erro de AJAX no upload da imagem: ' + textStatus + " - " + errorThrown + "\nResposta do servidor: " + jqXHR.responseText);
                            }
                        });
                    }
                }
            });

            // Lógica para upload de Imagem Destacada (para posts e guias)
            // Reutiliza o mesmo input de arquivo, mas os botões acionam-no e o JS preenche o campo hidden correto.
            $('#upload_featured_image_btn, #upload_guide_image_btn').on('click', function() {
                // Armazena qual campo deve ser preenchido após o upload
                var targetInputId = $(this).data('target-input');
                $('#featured_image_file_input').data('current-target-input', targetInputId);
                $('#featured_image_file_input').trigger('click'); 
            });

            $('#featured_image_file_input').on('change', function() {
                var fileInput = this;
                var currentTargetInput = $(this).data('current-target-input'); // Pega o ID do campo a ser preenchido

                if (fileInput.files && fileInput.files[0]) {
                    var formData = new FormData();
                    formData.append('featured_image_file', fileInput.files[0]);

                    $.ajax({
                        url: 'upload_featured_image.php', 
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        dataType: 'json',
                        success: function(response) {
                            if (response && response.location) {
                                // Preenche o campo hidden correto (post ou guia)
                                $('#' + currentTargetInput).val(response.location); 
                                
                                // Atualiza a imagem de preview relevante
                                if (currentTargetInput === 'featured_image' && $('#current_featured_image_preview').length) {
                                    $('#current_featured_image_preview').attr('src', response.location);
                                } else if (currentTargetInput === 'guide_image' && $('#current_guide_image_preview').length) {
                                    $('#current_guide_image_preview').attr('src', response.location);
                                }

                                alert('Imagem carregada com sucesso!');
                            } else {
                                alert('Erro no upload da imagem: ' + (response.error || 'Resposta inválida.'));
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            alert('Erro de AJAX no upload da imagem: ' + textStatus + " - " + errorThrown + "\nResposta do servidor: " + jqXHR.responseText);
                        }
                    });
                }
            });

            // Lógica para alternar visibilidade da secão de utilizadores
            $('#toggle_user_management').on('click', function() {
                $('#user_management_container').toggleClass('hidden');
                var buttonText = $(this).text();
                if (buttonText.includes('Mostrar')) {
                    $(this).html('Ocultar Gestão de Utilizadores <i class="fas fa-eye-slash ml-2"></i>');
                } else {
                    $(this).html('Mostrar Gestão de Utilizadores <i class="fas fa-eye ml-2"></i>');
                }
            });
        });
    </script>
</head>
<body class="font-poppins bg-gray-100 text-gray-800 flex flex-col min-h-screen">
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-XXXXXXX"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <header class="bg-gradient-to-r from-[#952852] to-[#781F60] text-white p-6 shadow-lg rounded-b-lg">
        <div class="container mx-auto flex flex-col md:flex-row justify-between items-center">
            <h1 class="text-3xl font-bold mb-2 md:mb-0">
                <a href="dashboard.php" class="hover:text-pink-200 transition-colors duration-300">Seguir Play Dashboard</a>
            </h1>
            <nav>
                <ul class="flex space-x-6 text-lg">
                    <li><a href="../" class="hover:text-pink-200 transition-colors duration-300">Ver Blog <i class="fas fa-external-link-alt"></i></a></li>
                    <li><a href="dashboard.php?logout=true" class="hover:text-pink-200 transition-colors duration-300">Sair <i class="fas fa-sign-out-alt"></i></a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container mx-auto p-4 md:p-8 flex-grow">
        <?php if (!empty($message)): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                <strong class="font-bold">Sucesso!</strong>
                <span class="block sm:inline"><?php echo $message; ?></span>
            </div>
        <?php endif; ?>
        <?php if (!empty($error)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                <strong class="font-bold">Erro!</strong>
                <span class="block sm:inline"><?php echo $error; ?></span>
            </div>
        <?php endif; ?>

        <section class="bg-white p-6 rounded-lg shadow-md mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6"><?php echo $edit_post ? 'Editar Post' : 'Criar Novo Post'; ?></h2>
            <form action="dashboard.php" method="POST">
                <input type="hidden" name="post_id" value="<?php echo $edit_post ? htmlspecialchars($edit_post->id) : ''; ?>">

                <div class="mb-4">
                    <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Título do Post:</label>
                    <input type="text" id="title" name="title" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="<?php echo $edit_post ? htmlspecialchars($edit_post->title) : ''; ?>" required>
                </div>

                <div class="mb-4">
                    <label for="content" class="block text-gray-700 text-sm font-bold mb-2">Conteúdo:</label>
                    <!-- O Summernote será inicializado neste textarea -->
                    <textarea id="content" name="content" rows="10" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required><?php echo $edit_post ? htmlspecialchars($edit_post->content) : ''; ?></textarea>
                </div>

                <div class="mb-4">
                    <label for="meta_description" class="block text-gray-700 text-sm font-bold mb-2">Meta Descrição (SEO):</label>
                    <textarea id="meta_description" name="meta_description" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"><?php echo $edit_post ? htmlspecialchars($edit_post->meta_description) : ''; ?></textarea>
                    <p class="text-gray-600 text-xs mt-1">Máximo de 160 caracteres. Importante para o Google.</p>
                </div>

                <div class="mb-4">
                    <label for="meta_keywords" class="block text-gray-700 text-sm font-bold mb-2">Meta Keywords (separadas por vírgula):</label>
                    <input type="text" id="meta_keywords" name="meta_keywords" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="<?php echo $edit_post ? htmlspecialchars($edit_post->meta_keywords) : ''; ?>">
                    <p class="text-gray-600 text-xs mt-1">Palavras-chave relevantes para o seu conteúdo.</p>
                </div>

                <div class="mb-4">
                    <label for="featured_image" class="block text-gray-700 text-sm font-bold mb-2">Imagem Destacada:</label>
                    <div class="flex space-x-2 items-center">
                        <!-- Campo oculto para armazenar a URL da imagem destacada -->
                        <input type="hidden" id="featured_image" name="featured_image" value="<?php echo $edit_post ? htmlspecialchars($edit_post->featured_image) : ''; ?>">
                        
                        <!-- Input de arquivo oculto para upload da imagem destacada -->
                        <input type="file" id="featured_image_file_input" name="featured_image_file_input" class="hidden" accept="image/*">
                        
                        <button type="button" id="upload_featured_image_btn" data-target-input="featured_image" class="bg-[#FF6E04] hover:bg-[#FF455B] text-white font-bold py-2 px-4 rounded-full focus:outline-none focus:shadow-outline transition-colors duration-300">
                            Carregar Imagem Destacada <i class="fas fa-upload ml-1"></i>
                        </button>
                    </div>
                    <p class="text-gray-600 text-xs mt-1">Clique para carregar a imagem destacada.</p>
                    <?php if (!empty($edit_post->featured_image)): ?>
                        <div class="mt-2">
                            <p class="text-gray-600 text-xs">Imagem atual:</p>
                            <img src="<?php echo htmlspecialchars($edit_post->featured_image); ?>" alt="Imagem Destacada Atual" class="max-w-xs h-auto rounded-md shadow-sm mt-1" id="current_featured_image_preview">
                        </div>
                    <?php endif; ?>
                </div>

                <div class="mb-4">
                    <label for="author" class="block text-gray-700 text-sm font-bold mb-2">Autor:</label>
                    <input type="text" id="author" name="author" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="<?php echo $edit_post ? htmlspecialchars($edit_post->author) : 'Seguir Play'; ?>">
                </div>

                <div class="mb-6">
                    <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Estado:</label>
                    <select id="status" name="status" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="draft" <?php echo (isset($edit_post) && $edit_post->status === 'draft') ? 'selected' : ''; ?>>Rascunho</option>
                        <option value="published" <?php echo (isset($edit_post) && $edit_post->status === 'published') ? 'selected' : (!isset($edit_post) ? 'selected' : ''); ?>>Publicado</option>
                    </select>
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit" name="submit_post" class="bg-[#FF455B] hover:bg-[#FF6E04] text-white font-bold py-2 px-4 rounded-full focus:outline-none focus:shadow-outline transition-colors duration-300">
                        <?php echo $edit_post ? 'Atualizar Post' : 'Criar Post'; ?>
                    </button>
                    <?php if ($edit_post): ?>
                        <a href="dashboard.php" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-full focus:outline-none focus:shadow-outline transition-colors duration-300">
                            Cancelar Edicão
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </section>

        <!-- Seção de Gerenciamento de Guias (Nova) -->
        <section class="bg-white p-6 rounded-lg shadow-md mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6"><?php echo $edit_guide ? 'Editar Guia' : 'Criar Novo Guia'; ?></h2>
            <form action="dashboard.php" method="POST">
                <input type="hidden" name="guide_id" value="<?php echo $edit_guide ? htmlspecialchars($edit_guide->id) : ''; ?>">

                <div class="mb-4">
                    <label for="guide_title" class="block text-gray-700 text-sm font-bold mb-2">Título do Guia:</label>
                    <input type="text" id="guide_title" name="guide_title" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="<?php echo $edit_guide ? htmlspecialchars($edit_guide->title) : ''; ?>" required>
                </div>

                <div class="mb-4">
                    <label for="guide_description" class="block text-gray-700 text-sm font-bold mb-2">Descricão do Guia:</label>
                    <textarea id="guide_description" name="guide_description" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required><?php echo $edit_guide ? htmlspecialchars($edit_guide->description) : ''; ?></textarea>
                </div>

                <div class="mb-4">
                    <label for="guide_url" class="block text-gray-700 text-sm font-bold mb-2">URL do Guia (opcional):</label>
                    <input type="url" id="guide_url" name="guide_url" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="<?php echo $edit_guide ? htmlspecialchars($edit_guide->url) : ''; ?>" placeholder="Ex: https://seusite.com/meu-guia">
                    <p class="text-gray-600 text-xs mt-1">Se o guia é uma página externa ou interna específica.</p>
                </div>

                <div class="mb-4">
                    <label for="guide_image" class="block text-gray-700 text-sm font-bold mb-2">Imagem do Guia (opcional):</label>
                    <div class="flex space-x-2 items-center">
                        <input type="hidden" id="guide_image" name="guide_image" value="<?php echo $edit_guide ? htmlspecialchars($edit_guide->image) : ''; ?>">
                        <!-- Reutiliza o input de arquivo existente -->
                        <input type="file" id="guide_image_file_input_alt" name="guide_image_file_input_alt" class="hidden" accept="image/*">
                        <button type="button" id="upload_guide_image_btn" data-target-input="guide_image" class="bg-[#FF6E04] hover:bg-[#FF455B] text-white font-bold py-2 px-4 rounded-full focus:outline-none focus:shadow-outline transition-colors duration-300">
                            Carregar Imagem Guia <i class="fas fa-upload ml-1"></i>
                        </button>
                    </div>
                    <p class="text-gray-600 text-xs mt-1">Clique para carregar a imagem do guia.</p>
                    <?php if (!empty($edit_guide->image)): ?>
                        <div class="mt-2">
                            <p class="text-gray-600 text-xs">Imagem atual:</p>
                            <img src="<?php echo htmlspecialchars($edit_guide->image); ?>" alt="Imagem Guia Atual" class="max-w-xs h-auto rounded-md shadow-sm mt-1" id="current_guide_image_preview">
                        </div>
                    <?php endif; ?>
                </div>

                <div class="mb-6">
                    <label for="guide_status" class="block text-gray-700 text-sm font-bold mb-2">Estado do Guia:</label>
                    <select id="guide_status" name="guide_status" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="draft" <?php echo (isset($edit_guide) && $edit_guide->status === 'draft') ? 'selected' : ''; ?>>Rascunho</option>
                        <option value="published" <?php echo (isset($edit_guide) && $edit_guide->status === 'published') ? 'selected' : (!isset($edit_guide) ? 'selected' : ''); ?>>Publicado</option>
                    </select>
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit" name="submit_guide" class="bg-[#952852] hover:bg-[#781F60] text-white font-bold py-2 px-4 rounded-full focus:outline-none focus:shadow-outline transition-colors duration-300">
                        <?php echo $edit_guide ? 'Atualizar Guia' : 'Criar Guia'; ?>
                    </button>
                    <?php if ($edit_guide): ?>
                        <a href="dashboard.php" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-full focus:outline-none focus:shadow-outline transition-colors duration-300">
                            Cancelar Edicão
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </section>

        <section class="bg-white p-6 rounded-lg shadow-md mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Guias Existentes</h2>
            <?php if (!empty($all_guides)): ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white rounded-lg overflow-hidden">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">ID</th>
                                <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Título</th>
                                <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Estado</th>
                                <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Acões</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($all_guides as $guide_item): ?>
                                <tr class="border-b last:border-b-0 hover:bg-gray-50">
                                    <td class="py-3 px-4 text-sm text-gray-700"><?php echo htmlspecialchars($guide_item->id); ?></td>
                                    <td class="py-3 px-4 text-sm text-gray-700"><?php echo htmlspecialchars($guide_item->title); ?></td>
                                    <td class="py-3 px-4 text-sm text-gray-700 capitalize">
                                        <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full <?php echo ($guide_item->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'); ?>">
                                            <?php echo htmlspecialchars($guide_item->status); ?>
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-sm">
                                        <a href="dashboard.php?edit_guide_id=<?php echo htmlspecialchars($guide_item->id); ?>" class="text-[#781F60] hover:text-[#952852] mr-3">
                                            <i class="fas fa-edit"></i> Editar
                                        </a>
                                        <form action="dashboard.php" method="POST" class="inline-block" onsubmit="return confirm('Tem certeza que deseja excluir este guia?');">
                                            <input type="hidden" name="guide_id_to_delete" value="<?php echo htmlspecialchars($guide_item->id); ?>">
                                            <button type="submit" name="delete_guide" class="text-red-600 hover:text-red-800">
                                                <i class="fas fa-trash-alt"></i> Excluir
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="text-center text-lg text-gray-600 py-5">Nenhum guia encontrado. Comece criando um!</p>
            <?php endif; ?>
        </section>

        <!-- Botão para alternar a visibilidade da secão de utilizadores -->
        <div class="mb-8 text-center">
            <button type="button" id="toggle_user_management" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 px-6 rounded-full focus:outline-none focus:shadow-outline transition-colors duration-300">
                Mostrar Gestão de Utilizadores <i class="fas fa-eye ml-2"></i>
            </button>
        </div>

        <!-- Secão de Gerenciamento de Utilizadores (Oculta por padrão) -->
        <div id="user_management_container" class="hidden">
            <section class="bg-white p-6 rounded-lg shadow-md mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Alterar Senha de Utilizador</h2>
                <form action="dashboard.php" method="POST">
                    <input type="hidden" name="change_password_submit" value="1">
                    <div class="mb-4">
                        <label for="user_id_to_change_password" class="block text-gray-700 text-sm font-bold mb-2">ID do Utilizador:</label>
                        <input type="number" id="user_id_to_change_password" name="user_id_to_change_password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    </div>
                    <div class="mb-4">
                        <label for="new_password" class="block text-gray-700 text-sm font-bold mb-2">Nova Senha:</label>
                        <input type="password" id="new_password" name="new_password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    </div>
                    <div class="mb-6">
                        <label for="confirm_new_password" class="block text-gray-700 text-sm font-bold mb-2">Confirmar Nova Senha:</label>
                        <input type="password" id="confirm_new_password" name="confirm_new_password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    </div>
                    <div class="flex items-center justify-between">
                        <button type="submit" class="bg-[#781F60] hover:bg-[#952852] text-white font-bold py-2 px-4 rounded-full focus:outline-none focus:shadow-outline transition-colors duration-300">
                            Alterar Senha
                        </button>
                    </div>
                </form>
            </section>

            <section class="bg-white p-6 rounded-lg shadow-md mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Utilizadores Existentes</h2>
                <?php if (!empty($all_users)): ?>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white rounded-lg overflow-hidden">
                            <thead class="bg-gray-200">
                                <tr>
                                    <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">ID</th>
                                    <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Utilizador</th>
                                    <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Email</th>
                                    <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Criado em</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($all_users as $user_item): ?>
                                    <tr class="border-b last:border-b-0 hover:bg-gray-50">
                                        <td class="py-3 px-4 text-sm text-gray-700"><?php echo htmlspecialchars($user_item->id); ?></td>
                                        <td class="py-3 px-4 text-sm text-gray-700"><?php echo htmlspecialchars($user_item->username); ?></td>
                                        <td class="py-3 px-4 text-sm text-gray-700"><?php echo htmlspecialchars($user_item->email); ?></td>
                                        <td class="py-3 px-4 text-sm text-gray-700"><?php echo date("d/m/Y H:i", strtotime($user_item->created_at)); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-center text-lg text-gray-600 py-5">Nenhum utilizador encontrado.</p>
                <?php endif; ?>
            </section>
        </div>


        <section class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Posts Existentes</h2>
            <?php if (!empty($all_posts)): ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white rounded-lg overflow-hidden">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">ID</th>
                                <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Título</th>
                                <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Estado</th>
                                <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Acões</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($all_posts as $post_item): ?>
                                <tr class="border-b last:border-b-0 hover:bg-gray-50">
                                    <td class="py-3 px-4 text-sm text-gray-700"><?php echo htmlspecialchars($post_item->id); ?></td>
                                    <td class="py-3 px-4 text-sm text-gray-700"><?php echo htmlspecialchars($post_item->title); ?></td>
                                    <td class="py-3 px-4 text-sm text-gray-700 capitalize">
                                        <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full <?php echo ($post_item->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'); ?>">
                                            <?php echo htmlspecialchars($post_item->status); ?>
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-sm text-gray-700"><?php echo date("d/m/Y H:i", strtotime($post_item->published_at)); ?></td>
                                    <td class="py-3 px-4 text-sm">
                                        <a href="dashboard.php?edit_id=<?php echo htmlspecialchars($post_item->id); ?>" class="text-[#781F60] hover:text-[#952852] mr-3">
                                            <i class="fas fa-edit"></i> Editar
                                        </a>
                                        <form action="dashboard.php" method="POST" class="inline-block" onsubmit="return confirm('Tem certeza que deseja excluir este post?');">
                                            <input type="hidden" name="post_id_to_delete" value="<?php echo htmlspecialchars($post_item->id); ?>">
                                            <button type="submit" name="delete_post" class="text-red-600 hover:text-red-800">
                                                <i class="fas fa-trash-alt"></i> Excluir
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="text-center text-lg text-gray-600 py-5">Nenhum post encontrado. Comece criando um!</p>
            <?php endif; ?>
        </section>
    </main>

    <footer class="bg-gray-800 text-white p-6 mt-12 rounded-t-lg">
        <div class="container mx-auto text-center text-sm">
            <p>&copy; <?php echo date("Y"); ?> Seguir Play Dashboard. Todos os direitos reservados.</p>
        </div>
    </footer>

    <!-- Tailwind CSS (CDN para prototipagem rápida) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        poppins: ['Poppins', 'sans-serif'], 
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
</body>
</html>
