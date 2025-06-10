<?php
// admin/upload_featured_image.php
// ESTE É UM EXEMPLO BÁSICO E INSEGURO PARA DEMONSTRAÇÃO.
// EM PRODUÇÃO, VOCÊ DEVE IMPLEMENTAR VALIDAÇÕES ROBUSTAS DE TIPO DE ARQUIVO, TAMANHO,
// E SEGURANÇA PARA EVITAR UPLOAD DE ARQUIVOS MALICIOSOS.

header('Content-Type: application/json');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// --- ATENÇÃO AQUI: AJUSTE ESTA LINHA COM BASE NA ESTRUTURA DO SEU SITE ---
// Se o seu blog está em 'http://seusite.com.br/blog/', use '/blog/'
// Se o seu blog está na raiz do seu domínio 'http://seusite.com.br/', use '/'
define('BLOG_WEB_ROOT_PATH', '/blog/'); // <--- AJUSTE CONFORME A URL RAIZ DO SEU BLOG!

if (isset($_FILES['featured_image_file'])) {
    // Define o caminho ABSOLUTO no SISTEMA DE ARQUIVOS para a pasta 'uploads'
    // Assumimos que 'uploads' está um nível acima da pasta 'admin', ou seja, em public/blog/uploads/
    $base_upload_dir_fs = __DIR__ . '/../uploads/'; 

    // Garante que o diretório de upload exista e tenha permissões de escrita
    if (!is_dir($base_upload_dir_fs)) {
        if (!mkdir($base_upload_dir_fs, 0755, true)) { // Cria a pasta recursivamente com permissões
            echo json_encode(['error' => 'Falha ao criar o diretório de upload. Verifique as permissões.']);
            exit();
        }
    }

    $file = $_FILES['featured_image_file'];
    
    // Gera um nome de arquivo único para evitar colisões
    $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $fileName = uniqid() . '.' . $fileExtension;
    
    $filePath_fs = $base_upload_dir_fs . $fileName; // Caminho completo no sistema de arquivos para salvar
    
    // A URL que será salva no DB e usada no frontend é o caminho da raiz web + uploads + nome do arquivo
    $fileUrl_path = BLOG_WEB_ROOT_PATH . 'uploads/' . $fileName; 

    // Validação básica do tipo de arquivo para imagem
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    if (!in_array($file['type'], $allowedTypes)) {
        echo json_encode(['error' => 'Tipo de arquivo não permitido. Apenas JPG, PNG, GIF, WEBP.']);
        exit();
    }

    // Validação básica de tamanho de arquivo (ex: máximo 5MB)
    $maxFileSize = 5 * 1024 * 1024; // 5 MB
    if ($file['size'] > $maxFileSize) {
        echo json_encode(['error' => 'O arquivo é muito grande. Tamanho máximo é 5MB.']);
        exit();
    }

    if (move_uploaded_file($file['tmp_name'], $filePath_fs)) {
        echo json_encode(['location' => $fileUrl_path]); // Retorna a URL completa para o frontend
    } else {
        echo json_encode(['error' => 'Falha ao mover o arquivo de upload. Erro: ' . $_FILES['featured_image_file']['error']]);
    }
} else {
    echo json_encode(['error' => 'Nenhum arquivo de imagem destacada enviado.']);
}
?>
