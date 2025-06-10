<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seguir Play - Baixe nosso APP</title>
    <!-- Incluindo Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Incluindo a fonte Inter do Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-KK8CVLZ');</script>
    <!-- End Google Tag Manager -->
</head>
<body>
    <!-- Header com logo -->
    <header class="w-full max-w-5xl px-4 py-8 flex justify-center">
        <a href="https://seguirplay.com" class="block logo-header">
            <!-- Substitua a URL da imagem abaixo pelo seu logo real. -->
            <img src="https://seguirplay.com/web_assets/img/logo.png" alt="Logo da Seguir Play" >
        </a>
    </header>

    <!-- Conteúdo principal - Hero Section -->
    <main class="flex flex-col lg:flex-row items-center justify-center flex-grow
                 bg-white p-8 sm:p-12 lg:p-16 rounded-3xl shadow-2xl max-w-5xl w-full
                 transform transition-all duration-500 ease-in-out hover:scale-[1.01] mt-8 lg:mt-0 hero-section">

        <!-- Lado esquerdo: Texto e Botões -->
        <div class="flex-1 lg:pr-12 mb-10 lg:mb-0 text-center lg:text-left hero-text-content">
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-gray-800 mb-6 leading-tight">
                Baixe nosso APP 
            </h1>
            <p class="text-lg sm:text-xl lg:text-2xl text-gray-600 mb-10">
               Facilite suas compras no dia-dia. Disponível para <span class="font-bold text-blue-700">iOS</span> e <span class="font-bold text-gray-800">Android</span>.
            </p>
            <div class="flex flex-col sm:flex-row justify-center lg:justify-start gap-5 w-full hero-buttons">
                <button id="iosButton" class="btn-custom btn-ios w-full sm:w-auto">
                    <!-- License: Logo. Made by vorillaz: https://github.com/vorillaz/devicons -->
                    <svg width="80px" height="80px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <path fill="#ffffff" d="M23.023 17.093c-0.033-3.259 2.657-4.822 2.777-4.901-1.512-2.211-3.867-2.514-4.705-2.548-2.002-0.204-3.91 1.18-4.926 1.18-1.014 0-2.583-1.15-4.244-1.121-2.185 0.033-4.199 1.271-5.323 3.227-2.269 3.936-0.58 9.769 1.631 12.963 1.081 1.561 2.37 3.318 4.061 3.254 1.63-0.064 2.245-1.055 4.215-1.055s2.524 1.055 4.248 1.021c1.753-0.032 2.864-1.591 3.936-3.159 1.24-1.814 1.751-3.57 1.782-3.659-0.038-0.017-3.416-1.312-3.451-5.202zM19.783 7.53c0.897-1.089 1.504-2.602 1.34-4.108-1.294 0.053-2.861 0.86-3.79 1.948-0.832 0.965-1.561 2.502-1.365 3.981 1.444 0.112 2.916-0.734 3.816-1.821z"></path>
                    </svg>
                    Download para iOS
                </button>
                <button id="androidButton" class="btn-custom btn-android w-full sm:w-auto">
                    <!-- License: MIT. Made by teenyicons: https://github.com/teenyicons/teenyicons -->
                    <svg width="80px" height="80px" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M7.5 4C6.44445 4 5.44766 4.25161 4.56634 4.69812L2.91603 2.22266L2.08398 2.77736L3.71104 5.21794C2.06927 6.39771 1 8.32399 1 10.5V13H14V10.5C14 8.32399 12.9307 6.39772 11.289 5.21795L12.916 2.77736L12.084 2.22266L10.4337 4.69812C9.55235 4.25161 8.55556 4 7.5 4ZM5 10H4V9H5V10ZM10 10H11V9H10V10Z" fill="#ffff"/>
                    </svg>
                    Download para Android
                </button>
            </div>
            <button id="supportButton" onclick="window.location.href='https://seguirplay.bio.link/'" class="btn-custom btn-support w-full sm:w-auto mt-5 sm:mt-6 lg:mt-8">
                Suporte
            </button>
        </div>
        <!-- Lado direito: Imagem do App -->
        <div class="flex-1 flex justify-center items-center p-4">
            <!-- Por favor, substitua a URL da imagem abaixo por um mockup real do seu aplicativo em um celular. -->
            <img src="assets/app.png" alt="Mockup do aplicativo Seguir Play no celular" class="w-64 sm:w-72 lg:w-80 h-auto rounded-xl  transform rotate-3 hover:rotate-0 transition-transform duration-500">
        </div>
    </main>

    <!-- Modal para iOS -->
    <div id="iosModal" class="modal">
        <div class="modal-content text-left">
            <span class="close" onclick="closeIosModal()">&times;</span>
            <h2 class="text-3xl font-extrabold text-gray-800 mb-4">Tutorial para iOS</h2>
            <p class="text-base text-gray-700 mb-6">Siga as instruções abaixo para baixar o aplicativo:</p>
            <ol class="list-decimal list-inside space-y-3 text-gray-700">
                <h3 class="font-bold text-lg mb-2 text-gray-800">Obrigatório</h3>
                <li>Baixe a foto mais bonita da Seguir Play <a href="https://drive.google.com/drive/folders/1nprUT-803D-H-G-YhwQKx7w-v3JUeiGb?usp=sharing" target="_blank" class="tutorial-link">Baixe Agora</a></li>
                <li>iOS atualizado: Este atalho é otimizado para iOS 17 e iOS 18, mas provavelmente também funcionará em versões mais antigas do iOS.</li>
                <li>Atalhos: O aplicativo da Apple vem pré-instalado no seu iPhone, mas se você o excluiu, pode <a href="https://apps.apple.com/us/app/shortcuts/id915249334" target="_blank" class="tutorial-link">reinstalá-lo</a> na App Store</li>
                <li>Veja o vídeo tutorial abaixo:</li>
            </ol>
            <div class="video-container">
                <iframe src="https://drive.google.com/file/d/1sm34ttaMLvrRvmV5QATUmtyR8N6zbQop/preview" allow="autoplay" allowfullscreen></iframe>
            </div>
            <a href="https://www.icloud.com/shortcuts/ea21c55de67a497c99be9dffe5154329" target="_blank" class="modal-download-btn">Baixar App para iOS</a>
        </div>
    </div>

    <!-- Modal para Android -->
    <div id="androidModal" class="modal">
        <div class="modal-content text-left">
            <span class="close" onclick="closeAndroidModal()">&times;</span>
            <h2 class="text-3xl font-extrabold text-gray-800 mb-4">Tutorial para Android</h2>
            <p class="text-base text-gray-700 mb-6">Siga as instruções abaixo para baixar o aplicativo:</p>
            <ol class="list-decimal list-inside space-y-3 text-gray-700">
                <li>Clique no botão "Baixar App para Android"</li>
                <li>Toque no botão "Instalar" e aguarde o download ser concluído.</li>
                <li>Abra o aplicativo e aproveite!</li>
                <li>Veja o vídeo tutorial abaixo:</li>
            </ol>
            <div class="video-container">
                <iframe src="https://drive.google.com/file/d/1959PJqktspJMQR9HuQUfJ-PCbbvB7sx2/preview" allow="autoplay" allowfullscreen></iframe>
            </div>
            <a href="assets/app/seguirplay.apk" target="_blank" class="modal-download-btn">Baixar App para Android</a>
        </div>
    </div>

    <!-- Footer -->
    <footer class="w-full max-w-4xl px-4 py-6 text-center text-white text-sm">
        <p>Copyright &copy; <script>document.write(new Date().getFullYear())</script> Seguir Play - Todos os direitos reservados.</p>
    </footer>

    <!-- Script JavaScript para funcionalidade do modal -->
    <script src="js/script.js"></script>
</body>
</html>
