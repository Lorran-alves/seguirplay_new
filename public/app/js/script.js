// Funções para abrir e fechar os modais
function openIosModal() {
    document.getElementById('iosModal').style.display = 'block';
}

function closeIosModal() {
    document.getElementById('iosModal').style.display = 'none';
}

function openAndroidModal() {
    document.getElementById('androidModal').style.display = 'block';
}

function closeAndroidModal() {
    document.getElementById('androidModal').style.display = 'none';
}

// Event listeners para os botões
document.getElementById('iosButton').addEventListener('click', openIosModal);
document.getElementById('androidButton').addEventListener('click', openAndroidModal);


document.getElementById('supportButton').addEventListener('click', function() {
    window.open('https://seguirplay.bio.link/', '_blank'); // Abre o link em uma nova aba
})

// Fecha o modal ao clicar fora dele
window.onclick = function(event) {
    const iosModal = document.getElementById('iosModal');
    const androidModal = document.getElementById('androidModal');

    if (event.target === iosModal) {
        iosModal.style.display = 'none';
    }

    if (event.target === androidModal) {
        androidModal.style.display = 'none';
    }
};