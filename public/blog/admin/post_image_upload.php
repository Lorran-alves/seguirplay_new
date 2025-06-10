<?php
// admin/post_image_upload.php
// ESTE É UM EXEMPLO BÁSICO E INSEGURO PARA DEMONSTRAÇÃO.
// EM PRODUÇÃO, VOCÊ DEVE IMPLEMENTAR VALIDAÇÕES ROBUSTAS DE TIPO DE ARQUIVO, TAMANHO,
// E SEGURANÇA PARA EVITAR UPLOAD DE ARQUIVOS MALICIOSOS.

header('Content-Type: application/json');

if (isset($_FILES['file'])) {
    $uploadDir = '../uploads/'; // Pasta para salvar as imagens (crie esta pasta na raiz do blog)
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true); // Cria a pasta se não existir
    }

    $fileName = uniqid() . '_' . basename($_FILES['file']['name']);
    $filePath = $uploadDir . $fileName;

    if (move_uploaded_file($_FILES['file']['tmp_name'], $filePath)) {
        // Retorna a URL da imagem para o TinyMCE
        echo json_encode(['location' => '../uploads/' . $fileName]);
    } else {
        echo json_encode(['error' => 'Falha no upload da imagem.']);
    }
} else {
    echo json_encode(['error' => 'Nenhum arquivo enviado.']);
}
?>