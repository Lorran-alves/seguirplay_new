<?php
// api/posts.php
// Este script fornece posts do blog em formato JSON para consumo externo.

header('Content-Type: application/json'); // Define o tipo de conteúdo como JSON
header('Access-Control-Allow-Origin: *'); // Permite requisições de qualquer origem (CORS) - ajuste em produção para domínios específicos

// --- INÍCIO: LINHAS DE DEPURACÃO (REMOVA EM PRODUÇÃO!) ---
ini_set('display_errors', 0); // Desativa a exibição de erros no output JSON em produção
ini_set('display_startup_errors', 1); // Ativa a exibição de erros na inicialização (útil para logs)
error_reporting(E_ALL);
// --- FIM: LINHAS DE DEPURACÃO ---

// Inclui o arquivo de configuração do banco de dados
// O caminho deve ser relativo à raiz do blog se este ficheiro estiver em 'api/'
require_once '../includes/db_config.php'; 

// Verifica se a conexão PDO foi estabelecida com sucesso
if (!isset($pdo) || $pdo === null) {
    echo json_encode(['error' => 'Erro interno do servidor: Conexão com o banco de dados indisponível.']);
    // Registra o erro internamente, mas não expõe detalhes sensíveis
    error_log("API Error: PDO connection failed in api/posts.php");
    exit(); 
}

// --- ATENÇÃO AQUI: AJUSTE ESTA LINHA COM BASE NA ESTRUTURA DO SEU BLOG PHP! ---
// Se o seu blog PHP está em 'http://seguirplay.com/blog/', use '/blog/'
// Se o seu blog PHP está na raiz do seu domínio 'http://seguirplay.com/', use '/'
define('BLOG_WEB_ROOT_PATH', '/blog/'); // <--- AJUSTE CONFORME A URL RAIZ DO SEU BLOG PHP!

try {
    // Busca posts publicados, ordenados por data de publicação decrescente
    // Limita a 10 posts por padrão, você pode adicionar um parâmetro GET para controlar isso (ex: ?limit=5)
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
    if ($limit <= 0 || $limit > 50) $limit = 10; // Limita o limite para evitar abusos

    $stmt = $pdo->prepare("SELECT id, title, slug, content, author, published_at, featured_image FROM posts WHERE status = 'published' ORDER BY published_at DESC LIMIT :limit");
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC); // Busca como array associativo para JSON

    // Ajusta o conteúdo para pegar um resumo e a URL correta da imagem
    foreach ($posts as &$post) { // Usa & para modificar o array original
        // Limita o resumo do conteúdo
        $post['excerpt'] = strip_tags($post['content']); // Remove HTML para o resumo
        $post['excerpt'] = mb_substr($post['excerpt'], 0, 150, 'UTF-8') . (mb_strlen($post['excerpt'], 'UTF-8') > 150 ? '...' : ''); // Limita a 150 caracteres e adiciona '...' se truncado

        // Constrói a URL completa da imagem destacada se for um caminho relativo
        if (!empty($post['featured_image'])) {
            // Verifica se já é uma URL completa (começa com http/https)
            if (strpos($post['featured_image'], 'http://') === 0 || strpos($post['featured_image'], 'https://') === 0) {
                $post['featured_image_full_url'] = $post['featured_image']; // Já é uma URL completa
            } else {
                // Assume que é um caminho relativo (ex: /uploads/imagem.jpg)
                $post['featured_image_full_url'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]" . BLOG_WEB_ROOT_PATH . ltrim($post['featured_image'], '/');
            }
        } else {
            $post['featured_image_full_url'] = ''; // Sem imagem destacada
        }

        // Constrói a URL completa do post para o link "Leia mais"
        $post['full_post_link'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]" . BLOG_WEB_ROOT_PATH . "post.php?slug=" . $post['slug'];

        // Registra a URL da imagem no log para depuração
        error_log("API Post Debug: Post ID " . $post['id'] . ", Imagem: " . $post['featured_image_full_url'] . ", Link: " . $post['full_post_link']);

        // Remove campos desnecessários ou sensíveis para a API externa
        unset($post['content']);
        unset($post['meta_description']);
    }

    echo json_encode($posts);

} catch (PDOException $e) {
    echo json_encode(['error' => 'Erro ao buscar posts: ' . $e->getMessage()]);
    error_log("API Error: Failed to fetch posts - " . $e->getMessage());
} catch (Exception $e) {
    echo json_encode(['error' => 'Erro inesperado na API: ' . $e->getMessage()]);
    error_log("API Error: Unexpected error - " . $e->getMessage());
}

?>
