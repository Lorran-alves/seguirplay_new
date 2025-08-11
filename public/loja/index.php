<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos à Venda</title>
    <!-- Inclui o Tailwind CSS para estilização rápida e responsiva -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-16855212060"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
    
      gtag('config', 'AW-16855212060');
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
        }
        /* Define a cor de gradiente para os botões */
        .btn-gradient {
            background-image: linear-gradient(257.28deg, #952852 0.51%, #781F60 104.36%);
        }
        /* Estilos para o dropdown */
        .dropdown-menu {
            position: absolute;
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            z-index: 10;
            display: none;
            min-width: 12rem;
            margin-top: 0.5rem;
            list-style: none;
            padding: 0.5rem 0;
        }
        .dropdown:hover .dropdown-menu {
            display: block;
        }
        .dropdown-item {
            display: block;
            padding: 0.5rem 1rem;
            color: #4a5568;
            transition: background-color 0.2s ease-in-out;
        }
        .dropdown-item:hover {
            background-color: #e2e8f0;
        }
    </style>
</head>
<body class="p-6 flex flex-col min-h-screen">
    <!-- Novo Cabeçalho com navegação (refeito com Tailwind) -->
    <nav class="bg-white p-4 shadow-md rounded-xl max-w-7xl mx-auto w-full mb-12">
        <div class="container mx-auto flex justify-between items-center flex-wrap">
            <!-- Logo -->
            <a class="flex items-center" href="https://seguirplay.com">
                <img src="https://seguirplay.com/web_assets/img/logo_footer.png" alt="Seguir Play" class="h-10">
            </a>

            <!-- Botão do menu mobile -->
            <button id="mobile-menu-button" class="md:hidden p-2 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
            </button>

            <!-- Menu de navegação -->
            <div id="nav-menu" class="hidden md:flex flex-col md:flex-row md:items-center w-full md:w-auto mt-4 md:mt-0">
                <ul class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-6 list-none p-0 m-0">
                    <li class="nav-item">
                        <a class="nav-link text-gray-600 hover:text-[#781F60] font-semibold transition-colors" href="https://seguirplay.com/comprar-seguidores-tik-tok">TikTok</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-gray-600 hover:text-[#781F60] font-semibold transition-colors" href="https://seguirplay.com/comprar-seguidores-youtube">Youtube</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-gray-600 hover:text-[#781F60] font-semibold transition-colors" href="https://seguirplay.com/comprar-seguidores-kwai">Kwai</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-gray-600 hover:text-[#781F60] font-semibold transition-colors" href="https://seguirplay.com/comprar-seguidores-facebook">Facebook</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-gray-600 hover:text-[#781F60] font-semibold transition-colors" href="https://seguirplay.com/comprar-seguidores-instagram">Instagram</a>
                    </li>
                    
                    <!-- Dropdown de Serviços -->
                    <li class="nav-item dropdown relative" id="servicos-dropdown">
                        <button class="text-gray-600 hover:text-[#781F60] font-semibold transition-colors flex items-center focus:outline-none">
                            + Serviços
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="https://seguirplay.com/comprar-seguidores-twitch">Twitch</a></li>
                            <li><a class="dropdown-item" href="https://seguirplay.com/comprar-seguidores-rumble">Rumble</a></li>
                            <li><a class="dropdown-item" href="https://seguirplay.com/comprar-seguidores-x-twitter">X Twitter</a></li>
                            <li><a class="dropdown-item" href="https://seguirplay.com/comprar-seguidores-kick">Kick</a></li>
                            <li><a class="dropdown-item" href="https://seguirplay.com/comprar-seguidores-whatsApp">WhatsApp</a></li>
                            <li><a class="dropdown-item" href="https://seguirplay.com/comprar-seguidores-telegram">Telegram</a></li>
                            <li><a class="dropdown-item" href="https://seguirplay.com/comprar-seguidores-linkedin">Linkedin</a></li>
                            <li><a class="dropdown-item" href="https://seguirplay.com/comprar-seguidores-shopee">Shopee</a></li>
                        </ul>
                    </li>
                    
                    <li class="nav-item ps-0" id="link_cart" style="display: none;" onclick="mostrarCarrinho()">
                        <button class="h_btn btn-gradient text-white px-4 py-2 rounded-lg font-semibold shadow-md hover:bg-opacity-90 transition-colors">Carrinho</button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Título da página agora é parte do conteúdo principal -->
    <header class="text-center mb-12">
        <h1 class="text-4xl md:text-5xl font-bold text-[#781F60]">Produtos Recomendados</h1>
        <p class="text-lg text-gray-600 mt-2">Confira as ofertas incríveis que preparamos para você!</p>
    </header>

    <!-- Container principal dos produtos -->
    <main id="product-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8 max-w-7xl mx-auto flex-grow"></main>

    <!-- Novo Rodapé com afiliação e outras informações -->
    <footer class="mt-12 bg-gray-100 py-12 px-6">
        <div class="container mx-auto max-w-7xl">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Coluna 1: Logo e Descrição -->
                <div class="flex flex-col items-start">
                    <img src="https://seguirplay.com/web_assets/img/logo_footer.png" alt="Seguir Play" class="h-10 mb-4">
                    <p class="text-gray-600 text-sm">Potencialize as suas redes sociais e expanda seu engajamento com a Seguir Play. Uma forma eficiente e segura de alcançar os seus objetivos.</p>
                </div>

                <!-- Coluna 2: Categorias -->
                <div>
                    <h2 class="font-bold text-lg text-gray-800 mb-4">Categorias</h2>
                    <ul class="space-y-2 text-sm">
                        <li><a href="https://seguirplay.com/comprar-seguidores-instagram" class="text-gray-600 hover:text-[#781F60] transition-colors">Instagram</a></li>
                        <li><a href="https://seguirplay.com/comprar-seguidores-youtube" class="text-gray-600 hover:text-[#781F60] transition-colors">Youtube</a></li>
                        <li><a href="https://seguirplay.com/comprar-seguidores-tik-tok" class="text-gray-600 hover:text-[#781F60] transition-colors">TikTok</a></li>
                        <li><a href="https://seguirplay.com/comprar-seguidores-facebook" class="text-gray-600 hover:text-[#781F60] transition-colors">Facebook</a></li>
                        <li><a href="https://seguirplay.com/comprar-seguidores-kwai" class="text-gray-600 hover:text-[#781F60] transition-colors">Kwai</a></li>
                        <li><a href="https://seguirplay.com/comprar-seguidores-twitch" class="text-gray-600 hover:text-[#781F60] transition-colors">Twitch</a></li>
                        <!-- Dropdown de serviços adaptado para o rodapé -->
                        <li class="dropdown relative mt-4">
                            <button class="text-gray-600 hover:text-[#781F60] transition-colors flex items-center focus:outline-none text-sm font-semibold">
                                + Serviços
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="https://seguirplay.com/comprar-seguidores-twitch">Twitch</a></li>
                                <li><a class="dropdown-item" href="https://seguirplay.com/comprar-seguidores-rumble">Rumble</a></li>
                                <li><a class="dropdown-item" href="https://seguirplay.com/comprar-seguidores-x-twitter">X Twitter</a></li>
                                <li><a class="dropdown-item" href="https://seguirplay.com/comprar-seguidores-kick">Kick</a></li>
                                <li><a class="dropdown-item" href="https://seguirplay.com/comprar-seguidores-whatsApp">WhatsApp</a></li>
                                <li><a class="dropdown-item" href="https://seguirplay.com/comprar-seguidores-telegram">Telegram</a></li>
                                <li><a class="dropdown-item" href="https://seguirplay.com/comprar-seguidores-linkedin">Linkedin</a></li>
                                <li><a class="dropdown-item" href="https://seguirplay.com/comprar-seguidores-shopee">Shopee</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>

                <!-- Coluna 3: Informações -->
                <div>
                    <h2 class="font-bold text-lg text-gray-800 mb-4">Informações</h2>
                    <ul class="space-y-2 text-sm">
                        <li><a href="https://seguirplay.com/perguntas-frequentes" class="text-gray-600 hover:text-[#781F60] transition-colors">Perguntas Frequentes</a></li>
                        <li><a href="https://blog.seguirplay.com/o-que-e-seguir-play" class="text-gray-600 hover:text-[#781F60] transition-colors">O que é Seguir Play?</a></li>
                        <li><a href="https://seguirplay.com/politicas-de-privacidade" class="text-gray-600 hover:text-[#781F60] transition-colors">Políticas de privacidade</a></li>
                        <li><a href="https://seguirplay.com/termos-e-condicoes" class="text-gray-600 hover:text-[#781F60] transition-colors">Termos e Condições</a></li>
                        <li><a href="https://www.blog.seguirplay.com/" target="_blank" class="text-gray-600 hover:text-[#781F60] transition-colors">Blog Seguir Play</a></li>
                        <li><a href="https://www.monetizeseucanal.seguirplay.com" class="text-gray-600 hover:text-[#781F60] transition-colors">Monetize seu YouTube</a></li>
                    </ul>
                </div>

                <!-- Coluna 4: Rede Social e Pagamento -->
                <div>
                    <h2 class="font-bold text-lg text-gray-800 mb-4">Rede Social</h2>
                    <div class="flex space-x-3 mb-4">
                        <a href="https://www.facebook.com/seguirplaybr/" target="_blank"><img src="https://seguirplay.com/web_assets/img/facebook.png" class="h-6" alt="Facebook"></a>
                        <a href="gruoposeguirplay.bio.link" target="_blank"><img src="https://seguirplay.com/web_assets/img/instagram.png" class="h-6" alt="Instagram"></a>
                        <a href="https://seguirplay.com/contato"><img src="https://seguirplay.com/web_assets/img/telefone.png" class="h-6" alt="Telefone"></a>
                    </div>
                    <div class="flex items-center space-x-3 mt-8">
                        
                    </div>
                </div>
            </div>

            <!-- Seção de direitos autorais e afiliação -->
            <div class="mt-8 pt-8 border-t border-gray-300 text-center">
                <p class="text-sm text-gray-600 mb-2">Copyright © 2025 Seguir Play LDTA CNPJ: 42.299.542/0001-57. Todos os direitos reservados.</p>
                <p class="text-sm text-gray-600">Atenção: Somos afiliados e não vendemos diretamente os produtos. Qualquer questão sobre a compra, entrega ou qualidade do produto deve ser tratada diretamente com o vendedor.</p>
                <p class="text-sm text-gray-600 mt-2">Não somos endossados ou certificados por nenhuma das plataformas de mídia social mencionadas neste site. Todos os logotipos e marcas registradas exibidos são de propriedade de seus respectivos proprietários. As imagens apresentadas são meramente ilustrativas e não indicam parcerias ou afiliações. O uso do nosso site constitui aceitação dos nossos termos de uso.</p>
            </div>
        </div>
    </footer>

   

    <script>
        // Array de objetos com os dados dos produtos
        const products = [
            {
                id: 1,
                name: 'Espremedor Elétrico',
                description: 'Se você gosta de suco fresco natural, este espremedor automático é perfeito para você!',
                price: 179,
                imageUrl: 'https://down-br.img.susercontent.com/file/br-11134207-7r98o-lzwy3lleuhsl89.webp',
                link: 'https://s.shopee.com.br/5pxkiXCsOv'
            },
            {
                id: 2,
                name: '40 Peças / 46 Peças Jogo De Chave ',
                description: '0 Peças / 46 Peças Jogo De Chave Catraca Caixa De Ferramentas Completa Reversível Soquetes Maleta',
                price: 29.79,
                imageUrl: 'https://down-br.img.susercontent.com/file/br-11134207-7r98o-m9dxs5n7zx1e75.webp',
                link: 'https://s.shopee.com.br/5Ai3vd6Vi6'
            },
            {
                id: 3,
                name: 'Torneira Com Chuveiro 360° - Inox ',
                description: 'Inox Prata Torneira Com Chuveiro Com Rotação De 360° Cozinha Luxo Parede Promoção',
                price: 26.99,
                imageUrl: 'https://down-br.img.susercontent.com/file/br-11134207-7r98o-lyoglpiep47pc3@resize_w450_nl.webp',
                link: 'https://s.shopee.com.br/2B4SMEshXn'
            },
            {
                id: 4,
                name: 'Mini Processador Triturador Sem Fio',
                description: 'Mini Processador Triturador Sem Fio Elétrico 250ML De Alimentos Para Legumes Alho Gengibre',
                price: 20.89,
                imageUrl: 'https://down-br.img.susercontent.com/file/br-11134207-7r98o-mc1tmn4659d32c.webp',
                link: 'https://s.shopee.com.br/1BBvAXss9Q'
            },
            {
                id: 5,
                name: 'Kit 3 Garrafa Copo Agua',
                description: 'Kit 3 Garrafa Copo Agua Squeeze C/ Adesivos Lembretes beber Agua Tendencia NOVA',
                price: 28.99,
                imageUrl: 'https://down-br.img.susercontent.com/file/br-11134207-7r98o-m7k40cwtg7d677.webp',
                link: 'https://s.shopee.com.br/802FJCVewi'
            },
            {
                id: 6,
                name: 'Maquina de Café Cafeteira Italiana',
                description: 'A Cafeteira Expresso Italiana de inox representa um padrão de qualidade notável',
                price: 45.90,
                imageUrl: 'https://down-br.img.susercontent.com/file/br-11134207-7r98o-ltys8ulu86sga6.webp',
                link: 'https://s.shopee.com.br/3AwzYUo14B'
            },
            {
                id: 7,
                name: 'Torneira Gourmet Com Filtro Slim',
                description: 'Torneira Gourmet Com Filtro Slim para Cozinha Preta de PAREDE Mesa',
                price: 108.99,
                imageUrl: 'https://down-br.img.susercontent.com/file/br-11134207-7r98o-m6iaxob950mf73.webp',
                link: 'https://s.shopee.com.br/4q5DXqs010'
            },
            {
                id: 8,
                name: 'Mop Spray Rodo Prático',
                description: 'Mop Spray Rodo Prático Eficiente Mágica Esfregão Reservatório Refil Microfibra Higiênico Limpeza',
                price: 50.92,
                imageUrl: 'https://down-br.img.susercontent.com/file/br-11134207-7r98r-llmj5xue9djn36.webp',
                link: 'https://s.shopee.com.br/709i88xFVu'
            },
            {
                id: 9,
                name: 'Limpador para Frestas',
                description: 'Limpador para Frestas Vãos Fendas Box e Janelas - 2 Luva Microfibra + Suporte',
                price: 24.50,
                imageUrl: 'https://down-br.img.susercontent.com/file/br-11134207-7r98o-ma9v63wjp4mue9@resize_w450_nl.webp',
                link: 'https://s.shopee.com.br/709i88xFVu'
            },
            {
                id: 10,
                name: 'Toalha de Banho Bebê Cobertor',
                description: 'Toalha de Banho Bebê Cobertor Grande Manta de Menino e Menina Toalha de banho Infantil Toalha quadrada 110*110cm',
                price: 29.50,
                imageUrl: 'https://down-tx-br.img.susercontent.com/br-11134207-7r98o-m682zeis7dl181.webp',
                link: 'https://s.shopee.com.br/7AT8KiPLiO'
            },
            {
                id: 10,
                name: 'Mop Giratorio Cabo Inox limpeza',
                description: 'Mop Giratorio Cabo Inox limpeza Cesto Em Inox 14 Lt -Balde Esfregão 360 Universal Original',
                price: 54.90,
                imageUrl: 'https://down-br.img.susercontent.com/file/br-11134207-7r98o-m9kghrogq795b2@resize_w450_nl.webp',
                link: 'https://s.shopee.com.br/2B4SNgsMv6'
            },
            {
                id: 10,
                name: 'Cobertor Manta Casal',
                description: 'Cobertor Manta Casal Macio 2,00X1,80 Microfibra Liso Estampado',
                price: 44.90,
                imageUrl: 'https://down-br.img.susercontent.com/file/br-11134207-7r98o-ma2tl6b8r4si05@resize_w450_nl.webp',
                link: 'https://s.shopee.com.br/1g8BmtCcNA'
            }
        ];

        // Função para renderizar os produtos na página
        function renderProducts() {
            const container = document.getElementById('product-container');
            container.innerHTML = ''; // Limpa o container antes de renderizar

            products.forEach(product => {
                // Cria o elemento do cartão do produto
                const productCard = document.createElement('div');
                productCard.className = 'bg-white rounded-xl shadow-lg hover:shadow-2xl transition-shadow duration-300 overflow-hidden transform hover:-translate-y-1 relative';
                
                // Insere o HTML interno do cartão, usando os dados do produto
                productCard.innerHTML = `
                    <span class="absolute top-2 left-2 bg-gray-900 text-white text-xs font-bold px-3 py-1 rounded-full z-10">${product.id}</span>
                    <img src="${product.imageUrl}" alt="Imagem do produto: ${product.name}" class="w-full h-100 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900">${product.name}</h3>
                        <p class="text-gray-600 mt-2 text-sm">${product.description}</p>
                        <div class="flex items-center justify-between mt-4">
                            <span class="text-2xl font-bold text-[#FF6E04]">R$ ${product.price.toFixed(2).replace('.', ',')}</span>
                            <!-- Botão de "Comprar" agora é um link de afiliação -->
                            <a href="${product.link}" target="_blank" class="btn-gradient text-white px-4 py-2 rounded-lg font-semibold shadow-md hover:bg-opacity-90 transition-colors">Comprar</a>
                        </div>
                    </div>
                `;
                container.appendChild(productCard);
            });
        }
        
        // Função para alternar a visibilidade do menu de navegação em dispositivos móveis
        document.getElementById('mobile-menu-button').addEventListener('click', () => {
            const navMenu = document.getElementById('nav-menu');
            navMenu.classList.toggle('hidden');
            navMenu.classList.toggle('flex');
        });

        // Adiciona funcionalidade para o dropdown de serviços
        const dropdown = document.getElementById('servicos-dropdown');
        dropdown.addEventListener('mouseenter', () => {
            const dropdownMenu = dropdown.querySelector('.dropdown-menu');
            dropdownMenu.style.display = 'block';
        });
        dropdown.addEventListener('mouseleave', () => {
            const dropdownMenu = dropdown.querySelector('.dropdown-menu');
            dropdownMenu.style.display = 'none';
        });

        // Renderiza os produtos quando a página é carregada
        window.onload = renderProducts;

    </script>
    <script type="module">
        import Typebot from 'https://cdn.jsdelivr.net/npm/@typebot.io/js@0.1/dist/web.js';
        
        Typebot.initBubble({
            typebot: "seguirplay",
            previewMessage: {
                avatarUrl:
                    "https://s3.fr-par.scw.cloud/typebot/public/typebots/clm98rbfr000fl60fdm561veh/hostAvatar?v=1694112967241",
            },
            theme: {
                button: { backgroundColor: "#7D255D", size: "average" },
                chatWindow: { backgroundColor: "#ffffff" },
            },
        });
    </script>
</body>
</html>
