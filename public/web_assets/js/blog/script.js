const apiUrl = "https://blog.seguirplay.com//wp-json/wp/v2/posts?per_page=3&_embed"; // Inclui '_embed' para carregar imagens destacadas
            
                    fetch(apiUrl)
                        .then(response => response.json())
                        .then(posts => {
                            let postsHtml = ""; // Variável para armazenar o HTML das postagens
            
                            posts.forEach(post => {
                                // Obtém a URL da imagem destacada embutida
                                const featuredImage = post._embedded && post._embedded['wp:featuredmedia'] 
                                    ? post._embedded['wp:featuredmedia'][0].source_url 
                                    : "https://via.placeholder.com/300x200"; // Imagem de placeholder caso não exista
            
                                // Criação do HTML para cada postagem
                                postsHtml += `
                                    <div class="col-md-4">
                                        <div class="card h-100 shadow-sm">
                                            <img src="${featuredImage}" class="card-img-top" alt="${post.title.rendered}" style="height: 200px; object-fit: cover;">
                                            <div class="card-body">
                                                <h5 class="card-title"><a href="${post.link}" target="_blank">${post.title.rendered}</a></h5>
                                                <p class="card-text">${post.excerpt.rendered.replace(/<[^>]*>?/gm, '').substring(0, 120)}</p>
                                            </div>
                                            <div class="card-footer bg-transparent">
                                                <a href="${post.link}" target="_blank" class="btn btn-outline-primary w-100">Leia mais</a>
                                            </div>
                                        </div>
                                    </div>
                                `;
                            });
            
                            // Exibe os posts no container
                            document.getElementById("blog-posts").innerHTML = postsHtml;
                        }) .catch(error => console.error("Erro ao carregar API:", error));