<?php
// admin/auth.php

// --- INÍCIO: LINHAS DE DEPURACÃO (REMOVA EM PRODUÇÃO!) ---
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
error_log("auth.php: Ponto de Depuração 1: Início do script auth.php");
// --- FIM: LINHAS DE DEPURACÃO ---

// session_start() DEVE SER A PRIMEIRA COISA EXECUTÁVEL QUE GERA SAÍDA.
session_start(); // Inicia a sessão para controlo de login

// Inclui o arquivo de configuração do banco de dados.
error_log("auth.php: Ponto de Depuração 2: Antes de incluir db_config.php");
require_once '../includes/db_config.php';
error_log("auth.php: Ponto de Depuração 3: Depois de incluir db_config.php");


$login_error = ''; // Inicializa a variável de erro de login
// $login_success = false; // Flag para indicar login bem-sucedido (removida para operação normal)

// --- AVISO DE SEGURANÇA CRÍTICO ---
// Para senhas, as funções password_hash() e password_verify() do PHP são FORTEMENTE RECOMENDADAS.
// Elas usam algoritmos mais seguros que incluem salting e múltiplas iterações (cost),
// tornando as senhas muito mais resistentes a ataques de força bruta e tabelas rainbow.
// O uso de SHA-256 direto (como neste exemplo) para senhas é menos seguro.
// Exemplo de uso seguro: password_hash($password, PASSWORD_DEFAULT);
// Exemplo de verificação segura: password_verify($password, $hashed_password);
// --- FIM DO AVISO ---

/*
// --- Lógica para criar um utilizador administrador inicial (APENAS PARA FACILITAR O PRIMEIRO SETUP!) ---
// REMOVA ESTE BLOCO APÓS CRIAR SEU PRIMEIRO UTILIZADOR ADMIN MANUALMENTE OU VIA DASHBOARD FUTURAMENTE.
// Esta lógica só é executada se a conexão PDO ($pdo) foi bem-sucedida.
if (isset($pdo) && $pdo !== null) {
    try {
        $stmt = $pdo->query("SELECT COUNT(*) FROM users");
        $user_count = $stmt->fetchColumn();

        if ($user_count == 0) {
            $default_username = 'admin';
            // --- USANDO SHA-256 conforme solicitado ---
            $default_password_hash = hash('sha256', 'seguirplay123'); // Senha padrão: seguirplay123
            $default_email = 'admin@seguirplay.com';

            $stmt = $pdo->prepare("INSERT INTO users (username, password, email) VALUES (:username, :password, :email)");
            $stmt->bindParam(':username', $default_username);
            $stmt->bindParam(':password', $default_password_hash);
            $stmt->bindParam(':email', $default_email);
            $stmt->execute();
            // Nenhuma mensagem de erro aqui, pois a criação é em segundo plano.
            // O utilizador será redirecionado para o formulário de login.
        }
    } catch (PDOException $e) {
        error_log("Erro ao verificar/criar utilizador admin inicial: " . $e->getMessage());
        // Este erro não deve impedir o resto do script, mas é bom registá-lo.
    }
} else {
    // Se $pdo não está definido ou é nulo, a conexão falhou em db_config.php e já deve ter exibido um erro/logado.
    // Nenhuma ação adicional aqui, o db_config.php já cuida da interrupção/erro.
}
// --- FIM DA LÓGICA DE CRIAÇÃO DE UTILIZADOR INICIAL ---
*/

error_log("auth.php: Ponto de Depuração 4: Antes do processamento do POST de login. REQUEST_METHOD: " . ($_SERVER['REQUEST_METHOD'] ?? 'UNDEFINED') . ", POST_login_isset: " . (isset($_POST['login']) ? 'true' : 'false'));

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    error_log("auth.php: Ponto de Depuração 5: Dentro do processamento do POST de login. Utilizador: " . $username);

    // Verifica se a conexão PDO ($pdo) está disponível antes de tentar a autenticação
    if (isset($pdo) && $pdo !== null) {
        error_log("auth.php: Ponto de Depuração 6: Conexão PDO disponível.");
        try {
            $stmt = $pdo->prepare("SELECT id, username, password FROM users WHERE username = :username LIMIT 1");
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $user = $stmt->fetch();

            error_log("auth.php: Ponto de Depuração 7: Consulta de utilizador executada. Utilizador encontrado: " . ($user ? 'Sim' : 'Não'));

            // --- VERIFICAÇÃO DE SENHA COM SHA-256 conforme solicitado ---
            if ($user && hash('sha256', $password) === $user->password) {
                error_log("auth.php: Ponto de Depuração 8: Login bem-sucedido. Redirecionando.");
                $_SESSION['loggedin'] = true;
                $_SESSION['user_id'] = $user->id;
                $_SESSION['username'] = $user->username;
                header('Location: dashboard.php'); // Redireciona para o dashboard após o login
                exit(); // É crucial parar a execução após um redirecionamento
            } else {
                error_log("auth.php: Ponto de Depuração 9: Utilizador ou senha incorretos.");
                $login_error = "Utilizador ou senha incorretos.";
            }
        } catch (PDOException $e) {
            error_log("auth.php: Ponto de Depuração 10: Erro de PDO durante a autenticação: " . $e->getMessage());
            $login_error = "Erro no servidor ao tentar autenticar. Tente novamente.";
        }
    } else {
        error_log("auth.php: Ponto de Depuração 11: Conexão PDO indisponível.");
        $login_error = "Erro: Conexão com o banco de dados indisponível.";
    }
}

error_log("auth.php: Ponto de Depuração 12: Antes de exibir o formulário de login (se não estiver logado)");

// Se o utilizador não estiver logado, exibe o formulário de login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    ?>
    <!DOCTYPE html>
    <html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login - Seguir Play Dashboard</title>
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    </head>
    <body class="font-poppins bg-gray-200 flex items-center justify-center min-h-screen" style="background: linear-gradient(257.28deg, #952852 0.51%, #781F60 104.36%);">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
            <h2 class="text-3xl font-bold text-center mb-6 text-gray-800">Acesso ao Dashboard</h2>
            <?php if (!empty($login_error)): ?>
                <p class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Erro!</strong>
                    <span class="block sm:inline"><?php echo $login_error; ?></span>
                </p>
            <?php endif; ?>
            <form action="auth.php" method="POST">
                <div class="mb-4">
                    <label for="username" class="block text-gray-700 text-sm font-bold mb-2">Utilizador:</label>
                    <input type="text" id="username" name="username" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="mb-6">
                    <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Senha:</label>
                    <input type="password" id="password" name="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="flex items-center justify-between">
                    <button type="submit" name="login" class="bg-[#FF455B] hover:bg-[#FF6E04] text-white font-bold py-2 px-4 rounded-full focus:outline-none focus:shadow-outline transition-colors duration-300 w-full">
                        Entrar
                    </button>
                </div>
            </form>
            <p class="text-center text-gray-600 text-xs mt-4">
                <a href="../" class="text-gray-600 hover:text-gray-800">Voltar para o Blog</a>
            </p>
        </div>
    </body>
    </html>
    <?php
    exit(); // Encerra o script após exibir o formulário de login
}

// Se chegou até aqui, significa que o utilizador está logado e o dashboard pode continuar.
// Nenhuma saída HTML ou exit() aqui, pois o dashboard.php vai continuar a execução.
?>
