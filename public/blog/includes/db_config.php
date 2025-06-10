<?php
// includes/db_config.php

// --- INÍCIO: LINHAS DE DEPURACÃO (REMOVA EM PRODUÇÃO!) ---
// Ativa a exibição de erros no navegador (pode ser ignorado por algumas hospedagens)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Define um arquivo de log para erros de conexão, caso 'display_errors' esteja desativado no servidor
$error_log_file = __DIR__ . '/db_connection_errors.log';
ini_set('log_errors', 1); // Certifica que o PHP tentará logar erros
ini_set('error_log', $error_log_file); // Define o arquivo de log personalizado
// --- FIM: LINHAS DE DEPURACÃO ---


// Define as credenciais do banco de dados
// CERTIFIQUE-SE DE QUE DB_HOST, DB_NAME, DB_USER, DB_PASS ESTÃO CORRETOS PARA O SEU SERVIDOR
define('DB_HOST', '127.0.0.1'); // ATUALIZADO PARA 127.0.0.1 conforme sua informação
define('DB_NAME', 'seguir00_blog');
define('DB_USER', 'seguir00_blog');
define('DB_PASS', '9z-U1&xPbykk');

$pdo = null; // Inicializa $pdo como null para garantir que está definido desde o início

// Tenta estabelecer a conexão com o banco de dados
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS);
    // Define o modo de erro do PDO para lançar exceções em caso de problemas
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Define o modo de busca padrão para objetos, facilitando o acesso aos dados
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    // echo "Conexão com o banco de dados estabelecida com sucesso!"; // Para depuração, remova em produção
} catch (PDOException $e) {
    // Registra o erro no arquivo de log personalizado
    error_log("Erro de Conexão com o Banco de Dados: " . $e->getMessage() . 
              " | Host: " . DB_HOST . ", DB: " . DB_NAME . ", User: " . DB_USER, 0);

    // Em caso de falha na conexão, exibe uma mensagem de erro mais detalhada e encerra o script.
    // Usamos um HTML básico para garantir que a mensagem seja formatada e visível (se 'display_errors' permitir).
    echo "<!DOCTYPE html><html><head><title>Erro de Conexão com Banco de Dados</title>";
    echo "<style>body{font-family: sans-serif; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; padding: 20px; margin: 20px; border-radius: 8px;} h1{color: #dc3545;} .code{background-color: #eee; padding: 10px; border-radius: 4px; font-family: monospace; overflow-x: auto;} ul{list-style-type: disc; margin-left: 20px;} li{margin-bottom: 5px;}</style>";
    echo "</head><body>";
    echo "<h1>Erro Crítico de Conexão com o Banco de Dados!</h1>";
    echo "<p>Não foi possível conectar ao banco de dados MySQL. Por favor, verifique as configurações.</p>";
    echo "<h2>Detalhes do Erro (do PHP):</h2>";
    echo "<div class='code'>" . htmlspecialchars($e->getMessage()) . "</div>";
    echo "<p><strong>Informações de Conexão Tentadas:</strong></p>";
    echo "<ul>";
    echo "<li>Host: <strong>" . DB_HOST . "</strong></li>";
    echo "<li>Nome do Banco de Dados: <strong>" . DB_NAME . "</strong></li>";
    echo "<li>Usuário: <strong>" . DB_USER . "</strong></li>";
    echo "<li>Senha: (ocultada por segurança)</li>";
    echo "</ul>";
    echo "<p><strong>Possíveis Soluções:</strong></p>";
    echo "<ul>";
    echo "<li>Verifique se o servidor MySQL está <strong>rodando</strong>.</li>";
    echo "<li>Confira se as <strong>credenciais</strong> (usuário e senha) no arquivo <code>includes/db_config.php</code> estão <strong>exatamente corretas</strong>.</li>";
    echo "<li>Certifique-se de que o <strong>host do banco de dados</strong> ('" . DB_HOST . "') está acessível do seu servidor web.</li>";
    echo "<li>Verifique se o <strong>banco de dados</strong> ('" . DB_NAME . "') realmente existe e o usuário tem permissão para acessá-lo.</li>";
    echo "</ul>";
    echo "</body></html>";
    exit(); // Usa exit() para garantir que o script pare imediatamente.
}

// Esta verificação final serve como uma redundância, embora o try-catch já deveria ter lidado com isso.
if (!isset($pdo) || $pdo === null) {
    // Se por algum motivo o PDO ainda não foi inicializado (altamente improvável com o exit() acima)
    error_log("Erro Interno Inesperado: Variável \$pdo não definida ou é nula após a tentativa de conexão.", 0);
    echo "<!DOCTYPE html><html><head><title>Erro Interno do Banco de Dados</title></head><body>";
    echo "<h1>Erro Interno Inesperado no Banco de Dados!</h1>";
    echo "<p>A variável de conexão com o banco de dados (<code>\$pdo</code>) não foi definida corretamente, mesmo após a tentativa de conexão.</p>";
    echo "<p>Isso pode indicar um problema mais complexo na configuração do seu ambiente PHP ou MySQL.</p>";
    echo "</body></html>";
    exit();
}
?>
