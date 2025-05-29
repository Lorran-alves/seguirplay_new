<!-- Modal de Promoção -->
<div class="modal fade" id="promocao" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
     aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Modo Zoom no PC use "modal-lg"-->
        <div class="modal-content" style="background-color: #080808;">
            <div class="modal-header" style="position: absolute;top: 0;right: 0; z-index:200;">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center" style="padding: 0;">
                <div class="modal-body p-0">
                    <!-- Principal imagem -->
                    <a href="https://whatsapp.com/channel/0029Vb0Hhba72WTvfc2ugV2s/161">
                        <img src="{{ asset('web_assets/img/pubs/canal/enquet.png') }}" 
                             class="media-object img-responsive img-thumbnail">
                    </a> 
                </div> 
                <!-- Principal Imagem grande com cupom 
                <div class="carousel-inner rounded">
                    <img src="{{ asset('web_assets/img/pubs/canal/consu.png') }}" 
                         class="d-block w-100 img-promocao coupon-image-principal"
                         alt="Cupom de Desconto"
                         style="cursor: pointer;">
                </div> -->
                
                <!-- Segunda imagem pequeno sem cupom 
                <div class="carousel-inner rounded">
                    <a href="https://whatsapp.com/channel/0029Vb0Hhba72WTvfc2ugV2s/135">
                        <img src="{{ asset('web_assets/img/pubs/canal/enquete.gif') }}" 
                             class="media-object img-responsive img-thumbnail">
                    </a> 
                </div> -->
                
                <!-- Segunda imagem pequeno com cupom 
                <div class="carousel-inner rounded">
                    <img src="{{ asset('web_assets/img/pubs/canal/diavpo.gif') }}" 
                         class="d-block w-100 img-promocao coupon-image-pequena"
                         alt="Cupom de Desconto"
                         style="cursor: pointer;"> -->
                </div>
                <!-- Segunda imagem pequeno com cupom -->
                            <div class="carousel-inner rounded">
                                <img src="{{ asset('web_assets/img/pubs/canal/viralcupm.gif') }}" 
                         class="d-block w-100 img-promocao coupon-image-carrossel"
                         alt="Cupom de Desconto"
                         style="cursor: pointer;">
                </div> 
            
                <!-- Carrossel -->
                <div class="modall-body p-0">
                    <div id="carouselPromo" class="carousel slide" data-bs-ride="carousel" data-bs-interval="10000">
                        <div class="carousel-inner rounded">
                            <!-- Primeira imagem com link -->
                            <div class="carousel-item active">
                                <img src="{{ asset('web_assets/img/pubs/canal/app.png') }}" 
                                     class="d-block w-100 img-promocao"
                                     alt="Promoção 1"
                                     onclick="window.location.href='https://www.seguirplay.com/app'"
                                     style="cursor: pointer;"> 
                            </div>
                            <!-- Terceira imagem com link 
                            <div class="carousel-item">
                                <img src="{{ asset('web_assets/img/pubs/canal/viralcupm.gif') }}" 
                                     class="d-block w-100 img-promocao coupon-image-carrossel"
                                     alt="Cupom de Desconto"
                                     style="cursor: pointer;"> 
                            </div> -->
                            <!-- Quarto imagem com link -->
                            <div class="carousel-item">
                                <img src="{{ asset('web_assets/img/pubs/canal/viral.gif') }}" 
                                     class="d-block w-100 img-promocao"
                                     alt="Promoção 2"
                                     onclick="window.location.href='http://ganchosviral.seguirplay.com.br/'"
                                     style="cursor: pointer;">
                            </div>
                        </div>
                    
                        <!-- Controles do carrossel -->
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselPromo" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Anterior</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselPromo" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Próximo</span>
                        </button>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<button data-bs-toggle="modal" data-bs-target="#promocao" id="buttonPromocao" style="display: none;"></button>

<!-- Script para copiar o cupom -->
<script>
    // Função para copiar cupom principal
    function copiarCupomPrincipal() {
        const cupom = 'SUPERDIA30';
        navigator.clipboard.writeText(cupom)
            .then(() => {
                alert(`🎉 Cupom "${cupom}" copiado para a área de transferência!`);
            })
            .catch(err => {
                console.error('Erro ao copiar:', err);
                alert('Ocorreu um erro ao copiar o cupom');
            });
    }

    // Função para copiar cupom da imagem pequena
    function copiarCupomPequena() {
        const cupom = 'DIAVIP20';
        navigator.clipboard.writeText(cupom)
            .then(() => {
                alert(`🎉 Cupom "${cupom}" copiado para a área de transferência!`);
            })
            .catch(err => {
                console.error('Erro ao copiar:', err);
                alert('Ocorreu um erro ao copiar o cupom');
            });
    }

    // Função para copiar cupom do carrossel
    function copiarCupomCarrossel() {
        const cupom = 'VIRAL';
        navigator.clipboard.writeText(cupom)
            .then(() => {
                alert(`🎉 Cupom "${cupom}" copiado para a área de transferência!`);
            })
            .catch(err => {
                console.error('Erro ao copiar:', err);
                alert('Ocorreu um erro ao copiar o cupom');
            });
    }

    document.addEventListener("DOMContentLoaded", function () {
        // Adiciona eventos às imagens dos cupons
        const couponImagePrincipal = document.querySelector('.coupon-image-principal');
        if (couponImagePrincipal) {
            couponImagePrincipal.addEventListener('click', copiarCupomPrincipal);
        }

        const couponImagePequena = document.querySelector('.coupon-image-pequena');
        if (couponImagePequena) {
            couponImagePequena.addEventListener('click', copiarCupomPequena);
        }

        const couponImageCarrossel = document.querySelector('.coupon-image-carrossel');
        if (couponImageCarrossel) {
            couponImageCarrossel.addEventListener('click', copiarCupomCarrossel);
        }
    });
</script>

<!-- Estilos -->
<style>
    .modall-body button {
        background: linear-gradient(257.28deg, #FF5722 0.51%, #FF5722 104.36%);
        border-radius: 20px;
        border: none;
        margin-top: 20px;
    }
    .carousel-item img {
        transition: transform 0.5s ease, filter 0.3s ease;
        height: auto;
        object-fit: cover;
    }

    .carousel-item img:hover {
        transform: scale(1.05);
        filter: brightness(100%);
    }

    .carousel-control-prev,
    .carousel-control-next {
        width: 4%;
        opacity: 0.8;
        outline: black;
        background-color: rgba(0, 0, 0, 0.3);
        background-size: 100%, 100%;
    }

    .carousel-control-prev:hover,
    .carousel-control-next:hover {
        opacity: 1;
    }

    .carousel-indicators {
        bottom: 1rem;
    }

    .carousel-indicators [data-bs-target] {
        background-color: #fff;
        opacity: 0.7;
        width: 12px;
        height: 12px;
        border-radius: 50%;
    }

    .carousel-indicators .active {
        opacity: 1;
        width: 16px;
        height: 16px;
    }
</style>