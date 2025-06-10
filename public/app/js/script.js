 // Obtenha os elementos do modal
        const iosModal = document.getElementById('iosModal');
        const androidModal = document.getElementById('androidModal');

        // Obtenha os botões que abrem os modais
        const iosButton = document.getElementById('iosButton');
        const androidButton = document.getElementById('androidButton');

        // Função para abrir o modal iOS
        function openIosModal() {
            iosModal.style.display = 'flex';
            document.body.style.overflow = 'hidden'; // Impede o scroll do body
        }

        // Função para fechar o modal iOS
        function closeIosModal() {
            iosModal.style.display = 'none';
            document.body.style.overflow = 'auto'; // Permite o scroll do body novamente
        }

        // Função para abrir o modal Android
        function openAndroidModal() {
            androidModal.style.display = 'flex';
            document.body.style.overflow = 'hidden'; // Impede o scroll do body
        }

        // Função para fechar o modal Android
        function closeAndroidModal() {
            androidModal.style.display = 'none';
            document.body.style.overflow = 'auto'; // Permite o scroll do body novamente
        }

        // Quando o usuário clicar em qualquer lugar fora do conteúdo do modal, feche-o
        window.onclick = function(event) {
            if (event.target == iosModal) {
                closeIosModal();
            }
            if (event.target == androidModal) {
                closeAndroidModal();
            }
        }

        // Adiciona event listeners aos botões
        iosButton.addEventListener('click', openIosModal);
        androidButton.addEventListener('click', openAndroidModal);