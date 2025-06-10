$(document).ready(function() {
    console.log("script.js carregado e documento pronto.");

    // --- Lógica para o Menu Hamburguer (Mobile) ---
    const mobileNavToggler = $('#mobile-nav-toggler');
    const primaryNavigationContent = $('#primary-navigation-content');

    if (mobileNavToggler.length) {
        mobileNavToggler.on('click', function() {
            primaryNavigationContent.toggleClass('hidden'); // Alterna a visibilidade
            const expanded = $(this).attr('aria-expanded') === 'true' ? false : true;
            $(this).attr('aria-expanded', expanded);
            console.log("Mobile nav toggler clicado. Menu está oculto: " + primaryNavigationContent.hasClass('hidden'));
        });

        // Fechar o menu mobile se o ecrã for redimensionado para desktop
        $(window).on('resize', function() {
            if ($(window).width() >= 768) { // md breakpoint em Tailwind
                if (primaryNavigationContent.hasClass('hidden') === false) {
                    primaryNavigationContent.addClass('hidden');
                    mobileNavToggler.attr('aria-expanded', 'false');
                    console.log("Menu mobile fechado devido a resize para desktop.");
                }
            }
        });

    } else {
        console.log("ERRO: Elementos do menu mobile (toggler ou content) não encontrados.");
        if (!mobileNavToggler.length) console.log(" -> #mobile-nav-toggler não encontrado.");
        if (!primaryNavigationContent.length) console.log(" -> #primary-navigation-content não encontrado.");
    }

    // --- Lógica para o Dark Mode Toggle ---
    const lightDarkSwitch = $('#lightdarkswitch');

    if (lightDarkSwitch.length) {
        console.log("Dark Mode Switch (#lightdarkswitch) encontrado. Iniciando lógica.");

        // Carregar preferência do utilizador
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            $('html').addClass('dark');
            lightDarkSwitch.prop('checked', true); // Marca o checkbox se o tema for dark
            console.log("Tema inicial definido para dark (via localStorage ou preferência do sistema).");
        } else {
            $('html').removeClass('dark');
            localStorage.setItem('theme', 'light');
            console.log("Tema inicial definido para light.");
        }

        lightDarkSwitch.on('change', function() {
            if (this.checked) {
                $('html').addClass('dark');
                localStorage.setItem('theme', 'dark');
                console.log("Switch do Dark Mode acionado. Tema alterado para dark.");
            } else {
                $('html').removeClass('dark');
                localStorage.setItem('theme', 'light');
                console.log("Switch do Dark Mode desativado. Tema alterado para light.");
            }
        });
    } else {
        console.log("ERRO: Switch do Dark Mode (#lightdarkswitch) não encontrado. Verifique o HTML.");
    }

    // Lógica para o botão "Pedidos" (placeholder)
    $('[data-bs-toggle="modal"][data-bs-target="#pedido"]').on('click', function() {
        console.log('Botão "Pedidos" clicado. O modal #pedido deve ser exibido se a lógica Bootstrap estiver incluída.');
    });

    // Lógica para o botão "Carrinho" (placeholder)
    window.mostrarCarrinho = function() {
        console.log('Função mostrarCarrinho() chamada. Lógica do carrinho aqui.');
    };
});
