// external_blog_script.js
// Este script carrega posts do blog Seguir Play via API e os exibe em outro site.

document.addEventListener('DOMContentLoaded', function() {
    // URL do endpoint da API do seu blog PHP
    // ATENÇÃO: SUBSTITUA PELA URL REAL DO SEU BLOG ONDE api/posts.php ESTÁ LOCALIZADO
    const apiUrl = "https://seguirplay.com/blog/api/posts.php?limit=3"; // Exemplo: 3 posts
    const targetElementId = "seguirplay-blog-posts-container"; // ID do elemento onde os posts serão exibidos no seu OUTRO site

    const targetContainer = document.getElementById(targetElementId);

    if (!targetContainer) {
        console.error(`Erro: Elemento com ID '${targetElementId}' não encontrado. Certifique-se de que o div existe no seu HTML.`);
        return;
    }

    // Adiciona um spinner de carregamento inicial
    targetContainer.innerHTML = `
        <div style="text-align: center; padding: 20px; color: #6c757d;">
            Carregando últimas postagens...
        </div>
    `;

    fetch(apiUrl)
        .then(response => {
            if (!response.ok) {
                // Tenta ler a resposta de erro do servidor se não for OK
                return response.json().then(errorData => {
                    throw new Error(`HTTP error! Status: ${response.status}, Details: ${errorData.error || 'Nenhum detalhe de erro.'}`);
                }).catch(() => {
                    // Se a resposta não for JSON, apenas retorna o status
                    throw new Error(`HTTP error! Status: ${response.status}`);
                });
            }
            return response.json();
        })
        .then(posts => {
            let postsHtml = "";

            if (!posts || posts.length === 0) {
                postsHtml = `
                    <div style="text-align: center; padding: 20px; color: #6c757d;">
                        Nenhum post encontrado no momento.
                    </div>
                `;
            } else {
                posts.forEach(post => {
                    const postLink = `https://seguirplay.com/blog/post.php?slug=${post.slug}`; // URL do post no seu blog PHP
                    const featuredImage = post.featured_image_full_url || "https://placehold.co/300x200/952852/ffffff?text=Sem+Imagem";
                    const excerpt = post.excerpt; // O resumo já vem pronto da API
                    const title = post.title;

                    // Adaptação dos estilos CSS fornecidos para classes Tailwind (ou estilos inline)
                    // Nota: As cores personalizadas do seu blog ('#FF455B', '#FF6E04', etc.)
                    // devem ser definidas no tailwind.config do OUTRO SITE ou adicionadas via CSS inline.
                    // Para o botão, estamos a usar as cores '#ff7200' e '#c7681a' como no seu exemplo.
                    postsHtml += `
                        <div class="flex flex-col bg-white rounded-xl shadow-md overflow-hidden h-full">
                            <img src="${featuredImage}" class="w-full h-48 object-cover" alt="${title}">
                            <div class="p-6 flex flex-col flex-grow">
                                <h5 class="text-xl font-semibold text-gray-900 mb-2 leading-tight">
                                    <a href="${postLink}" target="_blank" class="hover:underline text-gray-900">${title}</a>
                                </h5>
                                <p class="text-base text-gray-700 mb-4 flex-grow">${excerpt}</p>
                                <div class="mt-auto text-center">
                                    <a href="${postLink}" target="_blank" 
                                       style="font-weight: 600; background-color:#ff7200; border: none; color: #fff; padding: 15px; border-radius:100px; display: inline-block; width: 100%; text-decoration: none;"
                                       onmouseover="this.style.backgroundColor='#c7681a'" 
                                       onmouseout="this.style.backgroundColor='#ff7200'">
                                        Leia mais
                                    </a>
                                </div>
                            </div>
                        </div>
                    `;
                });
            }
            targetContainer.innerHTML = postsHtml;
        })
        .catch(error => {
            console.error("Erro ao carregar posts do blog Seguir Play:", error);
            targetContainer.innerHTML = `
                <div style="text-align: center; padding: 20px; color: #dc3545; background-color: #f8d7da; border: 1px solid #f5c6cb; border-radius: 5px;">
                    Erro ao carregar as postagens. Por favor, tente novamente mais tarde.
                    <br>Detalhes: ${error.message}
                </div>
            `;
        });
});
