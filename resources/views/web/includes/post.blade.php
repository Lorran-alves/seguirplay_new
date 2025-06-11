<style>
    #ipt-value{
        height: 42px;
        width: 100%;
        text-align: center;
        border-radius: 5px;
        background: #f7f7f7;
        border: 1px solid #dddddd;
        font-family: 'Manrope';
        font-style: normal;
        font-weight: 800;
        font-size: 16px;
        line-height: 25px;
        color: #131313;
    }
    button.voltar{
        width: 40px;
        height: 20px;
        text-align: center;
        justify-content: center;
        display: flex;
        align-items: center;
    }
    i.voltar{
        color: #9A9A9A;
        font-size: 20px
    }
    .block {
        display: block;
    }
    .none {
        display: none
    }
    .swal2-confirm{
        background-color:#FF6E04 !important;
    }
    .swal2-cancel{
        background-color: rgb(125, 37, 93) !important;
    }
    .video {
        position: relative;
        width: 100%;
        padding-top: 56.25%; /* Proporção 16:9 */
        background-size: cover;
        background-position: center;
        border-radius: 8px;
        cursor: pointer;
        transition: transform 0.3s ease;
    }
    .video:hover {
        transform: scale(1.05);
    }
   .video input[type="checkbox"] {
    position: absolute;
    top: 10px;
    right: 10px;
    transform: scale(1.5);
    opacity: 0.8;
    width: 10px;
    height: auto;
   }
   .video.selected {
    border: 3px solid #0d6efd; /* Borda azul para selecionados */
   }
   #videoGrid {
    list-style-type: none;
    padding: 0;
    margin: 0;
   }
   .page-link{
    color: #0d6efd !important;
   }
   .div-card{
    display: flex;
    flex-direction: column;
    align-items: center;
   }

    #paymentForm input, select, #paymentForm__cardNumber input, #paymentForm__expirationDate input, #paymentForm__securityCode input {
        text-align: left !important;
        width: 100% !important;
        height: 60px !important;
        padding: 20px 0 15px 5px !important;
        background: #FFFFFF !important;
        border: 1px solid #ECECEC !important;
        margin-bottom: 10px !important;
        color: #666666 !important;
    }
    #paymentForm__cardNumber, #paymentForm__expirationDate, #paymentForm__securityCode {
        padding: 20px 0 15px 5px !important;
        border: 1px solid #ECECEC !important;
        font-family: 'Manrope';
        font-style: normal;
        font-weight: 400;
        font-size: 18px;
        line-height: 25px;
        color: #666666;
        background: #FFFFFF;
        border: 1px solid #ECECEC;
        border-radius: 5px;
        margin-bottom: 15px;
        height: 60px;
    }
    
    .ocutar {
        display: none;
    }

</style>
<!-- Modal -->
<div class="modal fade" id="passo01" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
   aria-labelledby="staticBackdropLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeModal()"></button>
         </div>
         <div class="modal-body text-center">
            <img class="icons img-category" src="{{ asset('web_assets/img/value-icon01.png') }}">
            <h2 id="title01">Digite seu nome de usuário</h2>
            <p class="modal_paragraf"><a style="color:#781f60"target="_blank">ATENÇÃO!</a></p>
            <p class="modal_paragraf">Tem duvidas como solitar o pedido entra no <a style="color:#781f60" href="https://typebot.io/seguirplay" target="_blank">Chat Online</a>
            <p class="modal_paragraf">Prazo de entrega é de até 24 horas e pode chegar a até 72 horas em alguns casos, para fazer a entrega dos serviços.</p>
            <p class="modal_paragraf">Prazo de entrega em serviços em LIVES é de 10 minutos a 20 minutos.</p>
            <p class="modal_paragraf">Prazo de entrega para hora de exibições é de 7/30 dias, não é possível acelerar.</p>
            <p class="modal_paragraf">Necessário que o <a style="color:#781f60"target="_blank">PERFIL, CANAL, VIDEOS, GRUPO, FOTO OU REELS</a> esteje totalmente em <a style="color:#781f60"target="_blank">MODO PÚBLICO.</a></p>
            <p class="modal_paragraf">Ao solicitar este serviço, você concorda em ter lido e entendido os <a style="color:#781f60" href="https://seguirplay.com/termos-e-condicoes" target="_blank">Termos e condições</a> e <a style="color:#781f60" href="https://seguirplay.com/politicas-de-privacidade" target="_blank">Políticas de privacidade</a></p>
            <form id="formUserPurchase">
               <input id="linkEmbed" type="text" placeholder="Por favor, Insira o link aqui 🙂" autocapitalize="none" autocomplete="none">
               <input type="hidden" id="urlEscolhida">
               <input type="hidden" id="purchase_id">
               <p class="text-danger d-none">Preencha esse campo</p>
               <p class="text-danger" id="retornoVerificaLink"tyle="display: none;"></p>
               <div id="divRetornoDadosApi" style="display: none;"></div>
               <div id="divInstagram">
                  <iframe id="frameEmbed" width="320" height="568" frameborder="0"></iframe>
               </div>
               <div id="divInstagramLike" style="display:none;">
                  <p>Visualizar se estão corretas as informações: <a id="framelike" target='_blank'>Click aqui</a></p>
               </div>
               <div id="confirmInsta">
                  <p class="modal_paragraf">Antes de prosseguir com a aquisição, por favor, marque os seguintes campos para confirmar seu entendimento e concordância.</p>
                  <div class="checkbox-compra">
                     <input id="check_link" name="checkinsta" type='checkbox' style="height: 15px;" required>
                     <label for="check_link" id="label_link">Confirmo que o <a style="color:#781f60"target="_blank">LINK ESTÁ CORRETO</a> e o perfil totalmente em <a style="color:#781f60"target="_blank">MODO PÚBLICO.</a></label>
                  </div>
                  <div class="checkbox-compra">
                     <input id="accept_email" name="" type='checkbox' style="height: 15px;">
                     <label for="accept_email" id="label_link">Aceito receber e-mails promocionais de cupons (opcional)</label>
                  </div>
                  <div class="checkbox-compra">
                     <input id="check_insta" name="checkinsta" type='checkbox' style="height: 15px;" required>
                     <label for="check_insta" id="label_termos">Eu li e concordo com os <a style="color:#781f60" href="https://seguirplay.com/termos-e-condicoes" target="_blank">Termos e condições</a> e <a style="color:#781f60" href="https://seguirplay.com/politicas-de-privacidade" target="_blank">Políticas de privacidade</a></label>
                  </div>
               </div>
               <button id="button_checkbox">Continuar <i class="fas fa-arrow-right"></i></button>
            </form>
         </div>
      </div>
   </div>
</div>
<!-- Modal -->
<div class="modal fade modalShowSocial" id="passo022" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
   aria-labelledby="staticBackdropLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content rounded-4 shadow-lg">
         <div class="modal-header border-0">
            <button class="btn voltar" onclick="voltarAoModal(2)">
               <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="20" height="20">
                  <path fill="#7f7f7f" d="M257.5 445.1l-22.2 22.2c-9.4 9.4-24.6 9.4-33.9 0L7 273c-9.4-9.4-9.4-24.6 0-33.9L201.4 44.7c9.4-9.4 24.6-9.4 33.9 0l22.2 22.2c9.5 9.5 9.3 25-.4 34.3L136.6 216H424c13.3 0 24 10.7 24 24v32c0 13.3-10.7 24-24 24H136.6l120.5 114.8c9.8 9.3 10 24.8 .4 34.3z"/>
               </svg>
            </button>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeModal()"></button>
         </div>
         <div style="display: flex" class="justify-content-center w-100 py-5" id="imageLoading">
            <div class="spinner-border text-primary" role="status">
               <span class="visually-hidden">Carregando...</span>
            </div>
         </div>
         <div class="modal-body text-center p-4">
            <img id="socialImage" class="icons img-category mb-3" src="" alt="Ícone">
            <h2 id="socialname" class="mb-3"></h2>
            <!-- Informações do perfil -->
            <div class="d-flex justify-content-center gap-4 mb-3">
               <div class="text-center">
                  <strong class="d-block fs-4" id="socialFollowers"></strong>
                  <span class="text-muted">Seguidores</span>
               </div>
               <div class="text-center">
                  <strong class="d-block fs-4" id="socialFollowing"></strong>
                  <span class="text-muted">Seguindo</span>
               </div>
            </div>
            <!-- Descrição -->
            <p class="text-muted mb-4" id="socialDescription"></p>
            <!-- Frase de confirmação -->
            <h5 class="mb-3 text-dark fw-semibold">Esse é seu perfil?</h5>
            <!-- Botão continuar -->
            <button class="btn btn-primary px-4 py-2 rounded-pill continueButton">
            Continuar <i class="fas fa-arrow-right ms-2"></i>
            </button>
         </div>
      </div>
   </div>
</div>
<!-- Bootstrap Modal com seleção de imagem -->
<div class="modal fade" id="modalImagens" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
   aria-labelledby="staticBackdropLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content rounded-4 shadow-lg">
         <div class="modal-header border-0">
            <h5 class="modal-title fw-bold text-dark">Selecione sua postagem</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeModal()"></button>
         </div>
         <div class="modal-body p-4">
            <!-- Imagens reais para seleção -->
            <div class="row g-3" id="imageSelection"></div>
            <div style="display: flex" class="justify-content-center w-100 py-5" id="imageLoading">
               <div class="spinner-border text-primary" role="status">
                  <span class="visually-hidden">Carregando...</span>
               </div>
            </div>
            <hr class="my-4">
            <div class="text-center">
               <h5 class="fw-semibold mb-3">Selecione sua postagem</h5>
               <button class="btn btn-primary px-4 py-2 rounded-pill continueButton d-none">
               Continuar <i class="fas fa-arrow-right ms-2"></i>
               </button>
            </div>
         </div>
      </div>
   </div>
</div>
<style>
   .selectable-img {
   cursor: pointer;
   border: 3px solid transparent;
   transition: 0.3s ease;
   }
   .selectable-img:hover {
   transform: scale(1.05);
   }
   .selectable-img.selected {
   border-color: #0d6efd;
   box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.25);
   }
</style>
<!-- Modal -->
<div class="modal fade" id="passo02" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
   aria-labelledby="staticBackdropLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button class="btn voltar" onclick="voltarAoModal(2)">
               <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                  <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                  <path fill="#7f7f7f" d="M257.5 445.1l-22.2 22.2c-9.4 9.4-24.6 9.4-33.9 0L7 273c-9.4-9.4-9.4-24.6 0-33.9L201.4 44.7c9.4-9.4 24.6-9.4 33.9 0l22.2 22.2c9.5 9.5 9.3 25-.4 34.3L136.6 216H424c13.3 0 24 10.7 24 24v32c0 13.3-10.7 24-24 24H136.6l120.5 114.8c9.8 9.3 10 24.8 .4 34.3z"/>
               </svg>
            </button>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeModal()"></button>
         </div>
         <div class="modal-body text-center">
            <img class="icons img-category" src="{{ asset('web_assets/img/value-icon01.png') }}">
            <h2 class="userInstagram"></h2>
            <form method="post" id="formPurchase">
               @csrf
               <input type="email" placeholder="E-mail" name="email" required id="inputEmail">
               <input type="tel" name="telefone" id="phone" placeholder="Número de telefone" required>
               <input type="hidden" id="phone_code" value="+55" required>
               <p style="color:red; display: none;" id="telefone_erro">Número inválido</p>
               <input type="hidden" name="profile">
               <input type="hidden" name="accept_email">
               <input type="hidden" name="cupom" value="" id='cupomForm'>
               <input type="hidden" name="quantity" cmnt="q">
               <input type="hidden" name="urlActionCart" value="">
               <input type="hidden" name="plano_id" value="">
               <input type="hidden" name="categoria_id" value="">
               <input type="hidden" name="cmnt_q">
               <input type="hidden" id="amount" value="100.00">
               <input type="hidden" id="amount" value="">
               <button>Continuar <i class="fas fa-arrow-right"></i></button>
               <button>Adicionar ao carrinho<i class="fas fa-arrow-right"></i></button>
            </form>
            <p class="modal_paragraf">Você devera colocar o <b>NÚMERO VALIDO</b> ou <b>WhatsApp</b> com DDD e número, assim podemos entra em contato caso tenha algum dúvida sobre seu pedido</p>
            <p class="modal_paragraf">Você será notificado via e-mail assim que a remessa for enviada.</p>
         </div>
      </div>
   </div>
</div>
<!-- Modal -->
<div class="modal fade" id="passo03" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
   aria-labelledby="staticBackdropLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button class="btn voltar" onclick="voltarAoModal(3)">
               <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                  <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                  <path fill="#7f7f7f" d="M257.5 445.1l-22.2 22.2c-9.4 9.4-24.6 9.4-33.9 0L7 273c-9.4-9.4-9.4-24.6 0-33.9L201.4 44.7c9.4-9.4 24.6-9.4 33.9 0l22.2 22.2c9.5 9.5 9.3 25-.4 34.3L136.6 216H424c13.3 0 24 10.7 24 24v32c0 13.3-10.7 24-24 24H136.6l120.5 114.8c9.8 9.3 10 24.8 .4 34.3z"/>
               </svg>
            </button>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeModal()"></button>
         </div>
         <div class="modal-body text-center">
            <div id="contentCupomDetalhes">
               <img class="icons img-category" src="{{ asset('web_assets/img/value-icon01.png') }}">
               <h2 class="userInstagram"></h2>
               <p id="quantityInstagram"></p>
            </div>
            <div id="contentCupomCart" style="display: none;">
               <img src="{{ asset('web_assets/img/cart.png') }}">
            </div>
            <div class="div-buttom">
               <input type="text" id="cupomInputEntrada" placeholder="Digite o cupom (opcional)"  style="text-transform: uppercase;">
               <i class="fa-solid fa-check icon-cupom " onclick="aplicarDesconto()"></i>
            </div>
            <p id="feedbackCupom" style="color:red;"></p>
            <h2 id="totalInstagram" style="margin-bottom: 0"></h2>
            <h2 id="totalPrice" style="margin-bottom: 0"></h2>
            <button data-bs-toggle="modal" data-bs-target="#passo04" onclick="atualizarValorBotao()">
            Continuar
            <i class="fas fa-arrow-right"></i>
            </button>
            <!--  <button onclick="adicionarCarrinho()">
               Adicionar ao carrinho
               <i class="fas fa-arrow-right"></i>
               </button> -->
         </div>
      </div>
   </div>
</div>
<!-- Modal -->
<div class="modal fade" id="passo04" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
   aria-labelledby="staticBackdropLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button class="btn voltar" onclick="voltarAoModal(4)">
               <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                  <!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                  <path fill="#7f7f7f" d="M257.5 445.1l-22.2 22.2c-9.4 9.4-24.6 9.4-33.9 0L7 273c-9.4-9.4-9.4-24.6 0-33.9L201.4 44.7c9.4-9.4 24.6-9.4 33.9 0l22.2 22.2c9.5 9.5 9.3 25-.4 34.3L136.6 216H424c13.3 0 24 10.7 24 24v32c0 13.3-10.7 24-24 24H136.6l120.5 114.8c9.8 9.3 10 24.8 .4 34.3z"/>
               </svg>
            </button>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeModal()"></button>
         </div>
         <div class="modal-body text-center">
            <img class="icons img-category" src="{{ asset('web_assets/img/value-icon01.png') }}">
            <h2 class="userInstagram"></h2>
            <button id="btnPIX" class="mb-3">Pagar com PIX - R$ <span class="valor-botao-pix" style="color: white"></span> <i class="fas fa-arrow-right"></i></button>
            <button id="btnCard" class="mb-3" style="display:none;">Pagar com Cartão - R$ <span class="valor-botao-cartao" style="color: white"></span> <i class="fas fa-arrow-right"></i></button>
            <p class="modal_paragraf">
               <b>
                  Como pagar pelo PIX ou Cartão de Crédito
            <p></b>
            <p style="font-size: 12px">Gere o QR Code e Pague no seu banco na opção Pagar com Pix - Copie e Cole, Caso o QR não esteja funcionando Atualize a página.</p>
            <p style="font-size: 12px">Pague o QR code com <b>Cartão de Crédito</b>. Veja como realizar o pagamento pelo <a style="color:#781f60" href="https://www.youtube.com/watch?v=gLDhZ6vVLrs" target="_blank">Nubank</a>, <a style="color:#781f60" href="https://www.youtube.com/watch?v=bjh5Df1MxVA" target="_blank">Itaú</a>, <a style="color:#781f60" href="https://www.youtube.com/watch?v=vv_4cH0hlwM" target="_blank">PicPay</a>, <a style="color:#781f60" href="https://www.youtube.com/watch?v=txKq3RpgD9I&t=75s" target="_blank">Mercado Pago</a> ou <a style="color:#781f60" href="https://www.youtube.com/watch?v=NzFF3XmIKgE" target="_blank">RecargaPay</a>.</p>
            <p style="font-size: 12px">Funciona 24 horas por dia, pagamento reconhecido automaticamente pelo nosso sistema.</p>
            <p class="modal_paragraf">
               <b>
                  Você será notificado via e-mail assim que o seu pedido for enviada.
            <p></b>
         </div>
      </div>
   </div>
</div>
<!-- Modal -->
<div class="modal fade" id="pix" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
   aria-labelledby="staticBackdropLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeModal()"></button>
         </div>
         <div class="modal-body text-center">
            <img class="icons img-category" src="{{ asset('web_assets/img/value-icon01.png') }}">
            <h2> Realize seu pagamento via PIX</h2>
            <img id="load" src="https://upload.wikimedia.org/wikipedia/commons/b/b1/Loading_icon.gif?20151024034921" alt="">
            <div class="row" id="dix-pix" style="display:none;" >
               <div class="col-md-12">
                  <img src="" id="img-pix" width="100%" alt="">
               </div>
               <div class="col-md-12">
                  <input type="text" id="code-pix" name="code-pix" class="form-control mt-3 m-auto" readonly value="testeValorPix">
                  <button class="btn btn-secondary mt-3" onclick="copyPixCode()">Copiar o QR PIX</button>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- Modal para pagamento com cartão -->
<div class="modal fade" id="card" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
   aria-labelledby="staticBackdropLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeModal()"></button>
         </div>
         <div class="modal-body text-center">
            <img  src="{{ asset('web_assets/img/cart.svg') }}">
            <h2>Realize seu pagamento via Cartão de Crédito</h2>
            <div class="div-card">
               <form id="paymentForm">
                    <div id="paymentForm__cardNumber" class="container-div-form-card"></div>
                    <div id="paymentForm__expirationDate" class="container-div-form-card"></div>
                    <div id="paymentForm__securityCode" class="container-div-form-card"></div>
                    <input type="text" id="paymentForm__cardholderName"/>
                    <select id="paymentForm__issuer" class="form-control select-form-card ocutar"></select>
                    <select id="paymentForm__installments" class="form-control select-form-card"></select>
                    <select id="paymentForm__identificationType" class="form-control select-form-card ocutar"></select>
                    <input type="text" id="paymentForm__identificationNumber"/>
                    <input type="email" id="paymentForm__cardholderEmail"/>
                    <button type="submit" id="paymentForm__submit">Pagar</button>
                    <progress value="0" class="progress-bar ocutar">Carregando...</progress>
                </form>
            </div>
            <div class="cow-footer"><hr class="divider" aria-hidden="true">
                    <div><img width="100" alt="Logotipo &quot;from Seguir Play&quot;"  referrerpolicy="origin-when-cross-origin" src="{{ asset('web_assets/img/mercado_pago.png') }}"></div>
                    <div class="cow-payment_summary__security-payment"><svg width="12" height="16" viewBox="0 0 12 16" fill="none"><path d="M7.18502 10.3949C7.18502 11.0549 6.65 11.5899 5.99002 11.5899C5.33004 11.5899 4.79502 11.0549 4.79502 10.3949C4.79502 9.7349 5.33004 9.19988 5.99002 9.19988C6.65 9.19988 7.18502 9.7349 7.18502 10.3949Z" fill="black" fill-opacity="0.55"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M11.2012 6.20015H9.60941V3.80941C9.60941 1.81599 7.99343 0.200012 6.00002 0.200012C4.0066 0.200012 2.39062 1.81599 2.39062 3.80941V6.20015H0.798828V12.798C0.798828 14.4549 2.14197 15.798 3.79883 15.798H8.2012C9.85806 15.798 11.2012 14.4549 11.2012 12.798V6.20015ZM8.40941 3.80941V6.20015H3.59062V3.80941C3.59062 2.47873 4.66934 1.40001 6.00002 1.40001C7.33069 1.40001 8.40941 2.47873 8.40941 3.80941ZM1.99883 12.798V7.40015H10.0012V12.798C10.0012 13.7921 9.19532 14.598 8.2012 14.598H3.79883C2.80472 14.598 1.99883 13.7921 1.99883 12.798Z" fill="black" fill-opacity="0.55"></path></svg><span class="andes-typography andes-typography--type-body andes-typography--size-xs andes-typography--color-primary andes-typography--weight-semibold">Pagamento seguro</span></div>
                    <span class="andes-visually-hidden">Processado pelo <a style="color:#781f60" href="https://www.mercadopago.com.br" target="_blank">Mercado Pago.</a>
                </span>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- Modal -->
<div class="modal fade" id="success" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
   aria-labelledby="staticBackdropLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeModal()"></button>
         </div>
         <div class="modal-body text-center">
            <img class="icons" src="{{ asset('web_assets/img/value-icon01.png') }}">
            <h2>Pagamento Realizado com Sucesso <i style="color:#00FF00;" class="fas fa-check"></i></h2>
            <button> <a href="{{ route('web.pedidos')}}" class="acompanhe-pedido">Acompanhe seu pedido </a><i class="fas fa-arrow-right"></i></button>
            <p class="modal_paragraf">Você será notificado via e-mail assim que a remessa for enviada.</p>
         </div>
      </div>
   </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modalCookie" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
   aria-labelledby="staticBackdropLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="recusarCookie()"></button>
         </div>
         <div class="modal-body text-center">
            <img src="{{ asset('web_assets/img/cookes.png') }}">
            <p class="modal_paragraf">Utilizamos cookies para melhorar sua experiência em nosso site. Essas informações incluem seu e-mail, telefone e o serviço escolhido, armazenadas temporariamente por até 2 horas. Após esse período, os dados serão automaticamente excluídos.</p>
            <p>Saiba mais em <a style="color:#781f60" href="https://seguirplay.com/politicas-de-privacidade/#cookie" target="_blank">Políticas de privacidade</a></p>
            <button onclick="aceitarCookies()">Aceitar cookies</button>
         </div>
      </div>
   </div>
</div>
<div class="modal fade" id="modalAcceptCard" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
   aria-labelledby="staticBackdropLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="recusarCard()"></button>
         </div>
         <div class="modal-body text-center">
            <img src="{{ asset('web_assets/img/cart.svg') }}">
            <p class="modal_paragraf">Termo de Utilização do CPF em Compras com Cartão de Crédito</p>
            <p class="modal_paragraf">Ao realizar uma compra com cartão de crédito em nosso site, o cliente concorda com a solicitação do número do CPF, que será utilizado exclusivamente para os seguintes fins:</p>
            <p class="modal_paragraf">Emissão de Nota Fiscal Eletrônica: conforme exigido pela legislação brasileira, é necessário informar o CPF para registrar a compra de forma legal.</p>
            <p class="modal_paragraf">Segurança da Compra: o CPF é utilizado para verificar a identidade do comprador, ajudando a prevenir fraudes e garantir que a transação seja segura.</p>
            <p class="modal_paragraf">Todos os dados fornecidos, incluindo o CPF, são tratados com confidencialidade e armazenados de forma segura, em conformidade com a Lei Geral de Proteção de Dados (LGPD).</p>
            <p class="modal_paragraf">Ao finalizar a compra, o cliente declara estar ciente e de acordo com a utilização do CPF conforme descrito neste termo.</p>
            <p>Saiba mais em <a style="color:#781f60" href="https://seguirplay.com/politicas-de-privacidade/#Compra-no-Cartao-de-Credito" target="_blank">Políticas de privacidade</a></p>
            <button onclick="aceitarCard()">Prosseguir</button>
         </div>
      </div>
   </div>
</div>
<div class="modal fade" id="modalInfoCard" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
   aria-labelledby="staticBackdropLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeModal()"></button>
         </div>
         <div class="modal-body text-center">
            <h2>Preencha os dados</h2>
            <form id="formInfoCard" class="div-card">
               @csrf
               <div class="mb-3">
                  <label for="cpf" class="form-label">CPF</label>
                  <input type="text" class="form-control" id="cpf" placeholder="Digite o CPF" required>
               </div>
               <div class="mb-3">
                  <label for="nomeCompleto" class="form-label">Nome Completo</label>
                  <input type="text" class="form-control" id="nomeCompleto" placeholder="Nome Completo">
               </div>
               <div class="mb-3">
                  <label for="dataNascimento" class="form-label">Data de Nascimento</label>
                  <input type="date" class="form-control" id="dataNascimento">
               </div>
               <button type="button" class="btn btn-primary" onclick="prosseguirCardPagamento() ">Prosseguir</button>
            </form>
         </div>
      </div>
   </div>
</div>
<div class="modal fade" id="modalCart" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
   aria-labelledby="staticBackdropLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeModal()"></button>
         </div>
         <div class="modal-body text-center">
            <h2>Serviços adicionados</h2>
            <div id="corpo_carrinho">
            </div>
            <button data-bs-toggle="modal" onclick="abrirModalCupom()" id="continuarCompraCarrinhoButton">
            Continuar
            <i class="fas fa-arrow-right"></i>
            </button>
            <button onclick="adicionarServicos()">Adicionar mais serviços</button>
            <button onclick="limparCarrinho()" id="limparCarrinho">Limpar Carrinho</button>
         </div>
      </div>
   </div>
</div>
@foreach($plans as $plan)
<div class="col-lg-4 box">
   <div class="row">
      <div class="col-lg-12 box_01">
         <img class="icons" src="{{ $plan->category->image_icon }}">
         <h3>{{ $plan->title }}</h3>
         <div class="row value-mais">
            @if(!empty($plan->quantity_min))
            <div class="col-lg col-4">
               <img class="plan-quantity-less" data-price="{{ $plan->price }}"
                  data-quantity="{{ $plan->quantity_min }}" data-id="{{ $plan->id }}"
                  src="{{ asset('web_assets/img/menos.svg') }}" style="cursor: pointer">
            </div>
            @endif
            <div class="col-lg col-4"><input id="ipt-value" @if(empty($plan->quantity_min))disabled @endif name="quantity_value" value="{{ $plan->quantity_min ?? $plan->quantity }}" data-mask="####0"></div>
            @if(!empty($plan->quantity_min))
            <div class="col-lg col-4">
               <img class="plan-quantity-max" data-price="{{ $plan->price }}"
                  data-quantity="{{ $plan->quantity_min ?? $plan->quantity }}" data-id="{{ $plan->id }}"
                  src="{{ asset('web_assets/img/mais.svg') }}" style="cursor: pointer">
            </div>
            @endif
         </div>
         <h4>R$ {{ $plan->convert_price }}</h4>
         <button 
         onclick="alteraIcon(this,'{{ $plan->category->image_icon }}')"
         class="purchase-button" data-bs-toggle="modal" data-bs-target="#passo01" 
         data-price="{{ (empty($plan->quantity_min) ? $plan->price : $plan->price * $plan->quantity_min ?? $plan->quantity) }}"
         data-action="{{ route('web.purchases.buy', ['plan' => $plan]) }}"
         data-action-cart="{{ route('cartAdd', ['plan' => $plan]) }}"
         data-plano-id="{{ $plan->id }}"
         data-categoria-id="{{ $plan->category->id }}"
         data-quantity="{{ $plan->quantity_min ?? $plan->quantity }}" data-id="{{ $plan->id }}"
         data-socialservice="{{ $plan->social }}" 
         data-socialtype="{{ $plan->type_social }}"
         data-islink="{{ $plan->type }}"
         @if($plan->type == 4) cmnt="c" @endif >
         Comprar Agora
         <i class="fas fa-arrow-right"></i></button>
      </div>
   </div>
</div>
<!-- Overlay de loading -->
<div id="loading" style="display: none;position: fixed;z-index: 9999;top: 0;left: 0;    width: 100%;    height: 100%;    background: rgba(0, 0, 0, 0.2);  justify-content: center;    align-items: center;">
    <div class="spinner-border text-light" role="status" style="width: 3rem; height: 3rem;">
        <span class="sr-only">Carregando...</span>
    </div>
</div>


@endforeach
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script>
   let socialService;
   let buttonServiceClick;
   let socialType;
   
   //ultimo botão clicado
   let lastClickedButton = null;
   var mostrarComentarios = false;
   var type = 0;
   var valorTotal = 0;
   var urlProcessPaymentCard = "{{ route('web.purchases.processPaymentCard') }}";
   var urlRedirectSuccess = "{{ route('web.compraFinalizada') }}";
   
   $('#formUserPurchase').submit(handleUserPurchaseSubmit);
   $('.purchase-button').click(handlePurchaseButtonClick);
   
   function handlePurchaseButtonClick(e) {
       buttonServiceClick = $(e.currentTarget);
       socialService = $(this).data('socialservice');
       socialType = $(this).data('socialtype');
       console.log(socialType);
   }
   
   function handleUserPurchaseSubmit(e) {
   e.preventDefault();
   
   const type = socialType; // 'profile' ou 'post'
   const social = socialService; // 'instagram', 'tiktok', etc.
   const input = $('#linkEmbed').val().trim();
   
   if (social === '') {
      if(cookies){
               $("#modalCart").modal('show');
           }else{
               // Abrir o Modal 1
               $('#passo02').modal('show');
           }
       return;
   }
   
   let isValid = false;
   
   const validators = {
        instagram: {
            profile: link => {
                const cleaned = link.trim();
                return (
                    // Valida nomes de usuário (ex: @usuario ou usuario)
                    /^@?[A-Za-z0-9._]+$/.test(cleaned) ||
                    // Valida URLs de perfil do Instagram sem parâmetros de consulta
                    // (ex: https://www.instagram.com/usuario ou https://www.instagram.com/usuario/)
                    /^https:\/\/(www\.)?instagram\.com\/[A-Za-z0-9._]+\/?$/.test(cleaned) ||
                    // Adicionado: Valida URLs de perfil do Instagram com parâmetros de consulta
                    // (ex: https://www.instagram.com/usuario?igsh=xxxx&utm_source=qr)
                    /^https:\/\/(www\.)?instagram\.com\/[A-Za-z0-9._]+\/?\?.+$/.test(cleaned)
                );
            },
            post: link => /^https:\/\/(www\.)?instagram\.com\/(p|reel|tv)\/[A-Za-z0-9_-]+\/?(?:\?.*)?$/.test(link)
        },
        tiktok: {
            profile: link =>
                // @username direto ou URL de perfil/live
                /^@?[\w.-]+$/.test(link) ||
                /^https:\/\/(www\.)?tiktok\.com\/@[\w.-]+(\/live)?\/?$/.test(link),
        
            post: link =>
                // Vídeos padrão ou links encurtados (vm.tiktok.com)
                /^https:\/\/(www\.)?tiktok\.com\/@[\w.-]+\/video\/\d+\/?(?:\?.*)?$/.test(link) ||
                /^https:\/\/vm\.tiktok\.com\/[\w/-]+\/?$/.test(link)
        },
        kwai: {
                profile: link =>
                // 1. Formato local: @nome.usuario ou nome.usuario
                /^@?[\w.-]+$/.test(link) ||
        
                // 2. Formato web padrão: https://www.kwai.com/@nome.usuario
                /^https:\/\/(www\.)?kwai\.com\/@[\w.-]+\/?$/.test(link) ||
        
                // 3. Formato k.kwai.com com barra após @: https://k.kwai.com/u/@/nome.usuario
                // (Revertido para [\w.-] para permitir pontos, consistência com o novo padrão)
                /^https:\/\/k\.kwai\.com\/u\/@\/[\w.-]+\/?$/.test(link) ||
        
                // 4. NOVO Formato k.kwai.com com nome e código: https://k.kwai.com/u/@nome.usuario/codigoaleatorio
                /^https:\/\/k\.kwai\.com\/u\/@[\w.-]+\/[\w-]+\/?$/.test(link),
                post: link => // (supondo que a validação de post permanece a mesma da sua solicitação anterior)
                    /^https:\/\/(www\.)?kwai\.com\/(@[\w.-]+\/video|short-video)\/[\w-]+\/?(?:\?.*)?$/.test(link) ||
                    /^https:\/\/k\.kwai\.com\/p\/[\w-]+\/?(?:\?.*)?$/.test(link)
        },
        youtube: {
            profile: link =>
                // @username direto
                /^@?[\w.-]+$/.test(link) ||
        
                // URLs padrão do YouTube com /c/, /channel/, ou /@ e nomes válidos
                /^https:\/\/(www\.)?youtube\.com\/(c\/[\w.-]+|@[\w.-]+|channel\/[A-Za-z0-9_-]{24})\/?$/.test(link),
        
            post: link =>
                // watch?v=, shorts/, live/, ou youtu.be com ou sem parâmetros
                /^https:\/\/(www\.)?youtube\.com\/(watch\?v=|shorts\/|live\/)[\w-]+(?:[&?][\w=.-]*)*$/.test(link) ||
                /^https:\/\/youtu\.be\/[\w-]+(\?[A-Za-z0-9=&._-]+)?$/.test(link)
        },
        facebook: {
            profile: link =>
                // 1. Formato genérico de nome de usuário
                /^@?[\w.-]+$/.test(link) ||
        
                // 2. Perfil padrão: facebook.com/nome.usuario
                /^https:\/\/(www\.)?facebook\.com\/[A-Za-z0-9._-]+\/?$/.test(link) ||
        
                // 3. Perfil por ID numérico: facebook.com/profile.php?id=100001234567890
                /^https:\/\/(www\.)?facebook\.com\/profile\.php\?id=\d+(?:&.*)?\/?$/.test(link) ||
        
                // 4. Links de compartilhamento (ex: facebook.com/share/1EWMoC3Wrb/)
                /^https:\/\/(www\.)?facebook\.com\/share\/[\w-]+\/?(?:\?.*)?$/.test(link) ||
        
                // 5. NOVO: Links de Grupo: facebook.com/groups/NOME_OU_ID_DO_GRUPO/
                /^https:\/\/(www\.)?facebook\.com\/groups\/[A-Za-z0-9._-]+\/?(?:\?.*)?$/.test(link),
        
            post: link =>
                // 1. Post padrão: facebook.com/username/posts/IDPOST ou facebook.com/USER_ID/posts/POST_ID/
                /^https:\/\/(www\.)?facebook\.com\/[A-Za-z0-9._-]+\/posts\/\d+\/?(?:\?.*)?$/.test(link) ||
        
                // 2. Links de Foto (via fbid): facebook.com/photo/?fbid=IDFBID ou photo.php?fbid=IDFBID
                /^https:\/\/(www\.)?facebook\.com\/(?:photo\.php|photo\/)\?(?:[^#]*&)?fbid=\d+(?:&[^#]*)?$/.test(link) ||
        
                // 3. Links de Reel: facebook.com/reel/REEL_ID
                /^https:\/\/(www\.)?facebook\.com\/reel\/\d+\/?(?:\?.*)?$/.test(link) ||
        
                // 4. Links de Vídeo (Watch): facebook.com/watch/?v=VIDEO_ID ou facebook.com/watch?v=VIDEO_ID
                /^https:\/\/(www\.)?facebook\.com\/watch\/?\?(?:[^#]*&)?v=\d+(?:&[^#]*)?$/.test(link)
        },            
        twitch: {
            profile: link =>
                /^@?[\w]+$/.test(link) ||
                /^https:\/\/(www\.)?twitch\.tv\/\w+\/?$/.test(link), // Usando \w para consistência
        
            post: link =>
                // 1. Links de Clipes: twitch.tv/USERNAME/clip/CLIP_ID
                //    (Também lida com a variação twitch.tv//USERNAME/clip/CLIP_ID)
                /^https:\/\/(www\.)?twitch\.tv\/(?:\/)?\w+\/clip\/[\w-]+\/?(?:\?.*)?$/.test(link) ||
        
                // 2. Links de Vídeos (VODs): twitch.tv/videos/VIDEO_ID (numérico)
                /^https:\/\/(www\.)?twitch\.tv\/videos\/\d+\/?(?:\?.*)?$/.test(link)
       },
       rumble: {
           profile: link =>
               /^https:\/\/(www\.)?rumble\.com\/user\/[A-Za-z0-9_-]+\/?$/.test(link),
           post: link =>
               /^https:\/\/(www\.)?rumble\.com\/[A-Za-z0-9_-]+\.html(?:\?.*)?$/.test(link)
       },
       twitter: {
           profile: link =>
               /^@?[\w]+$/.test(link) ||
               /^https:\/\/(www\.)?(twitter|x)\.com\/[\w]+\/?$/.test(link),
           post: link =>
               /^https:\/\/(www\.)?(twitter|x)\.com\/[\w]+\/status\/\d+(?:\?.*)?$/.test(link)
       },
       kick: {
           profile: link =>
               /^@?[\w]+$/.test(link) ||
               /^https:\/\/(www\.)?kick\.com\/[A-Za-z0-9_]+\/?$/.test(link),
           post: () => false
       },
       whatsapp: {
           profile: link =>
            // 1. Links "wa.me" para iniciar conversa com número de telefone
            /^https:\/\/wa\.me\/\d{8,15}\/?$/.test(link) ||
    
            // 2. NOVO: Links para Canais do WhatsApp
            /^https:\/\/whatsapp\.com\/channel\/[\w.-]+\/?(?:\?.*)?$/.test(link),
           post: () => false
       },
       telegram: {
           profile: link =>
               /^@?[\w\d_]+$/.test(link) ||
               /^https:\/\/t\.me\/[\w\d_]+\/?$/.test(link),
           post: link =>
               /^https:\/\/t\.me\/[\w\d_]+\/\d+(?:\?.*)?$/.test(link)
       },
       linkedin: {
           profile: link =>
               /^https:\/\/(www\.)?linkedin\.com\/in\/[A-Za-z0-9-]+\/?$/.test(link),
           post: link =>
               /^https:\/\/(www\.)?linkedin\.com\/posts\/[A-Za-z0-9-]+/.test(link)
       },
       shopee: {
           profile: link =>
               /^https:\/\/(shopee\.br|shopee\.com\.br)\/(shop|seller)\/\d+/.test(link),
           post: link =>
               /^https:\/\/(shopee\.br|shopee\.com\.br)\/product\/\d+\/\d+/.test(link)
       }
       };
   
    // Verificação adicional para impedir QR PIX
    const lowerInput = input.toLowerCase();
    if (lowerInput.includes("pix") && lowerInput.includes("qr")) {
        voltarAoModal(2);
        alert('Ah, parece que você colou um QR Code do Pix. 😅 Para continuar, insira um link do conteúdo — links de pagamento não são aceitos por aqui.');
        setTimeout(() => {
            voltarAoModal(2);
        }, 300);
        return false;
    }
   
   
   if (validators[social] && validators[social][type]) {
       isValid = validators[social][type](input);
   }
    
    // Verificação link's
    if (!isValid) {
        voltarAoModal(2);
        
        if (type === 'profile') {
            alert('Opa! Esse link não parece ser de um perfil ou canal válido. Dá uma conferida no formato e tenta colar novamente! 😊');
        } else if (type === 'post') {
            alert('Hmm... Esse link não parece levar para uma foto ou vídeo válido. Que tal verificar rapidinho e tentar de novo! 📸🎥');
        } else {
            alert('Ei! Precisamos de um link válido para continuar com esse serviço. Dá uma olhadinha no link e tenta de novo! 😉');
        }
    
        setTimeout(() => {
            voltarAoModal(2);
        }, 300);
        
        return false;
    }
   
   // Se for Instagram + perfil, vamos validar na API
   if (social === 'instagram' && type === 'profile') {
       let username = clear_link('instagram', input);
       
       $.ajax({
           url: `https://instagram-premium-api-2023.p.rapidapi.com/v1/user/web_profile_info?username=${username}`,
           method: 'GET',
           headers: {
               'X-RapidAPI-Key': 'c19b4ece3dmsh5d3d8bd548f5b9fp160874jsn65a2a11324e0',
               'X-RapidAPI-Host': 'instagram-premium-api-2023.p.rapidapi.com'
           }
       }).done(function (response) {
           if (response.user.is_private) {
               alert('Opa! Parece que o perfil está privado. Para seguirmos com o serviço, você pode deixá-lo público temporariamente? 🔓🙂');
               setTimeout(() => {
                   voltarAoModal(2)
               }, 300);
               return;
           }
           
           if(cookies){
               $("#modalCart").modal('show');
           }else{
               // Abrir o Modal 1
               $('#passo02').modal('show');
           }
       }).fail(function () {
           if(cookies){
               $("#modalCart").modal('show');
           }else{
               // Abrir o Modal 1
               $('#passo02').modal('show');
           }
       });
   
       return;
   }
   
   // ✅ Se não for Instagram perfil, só mostra o modal normalmente
   if(cookies){
               $("#modalCart").modal('show');
           }else{
               // Abrir o Modal 1
               $('#passo02').modal('show');
           }
   }
   
   function clear_link(social, input) {
   if (social !== 'instagram' || !input) return null;
   input = input.trim();
   
   if (input.startsWith("@")) return input.slice(1);
   if (/^[a-zA-Z0-9._]+$/.test(input)) return input;
   
   const pattern = /(?:https?:\/\/)?(?:www\.)?instagram\.com\/([a-zA-Z0-9._]+)/;
   const match = input.match(pattern);
   return match ? match[1] : null;
   }
   
   $("#divInstagram").hide()
   $("#divInstagramLike").hide()
   $("button[cmnt='c']").click(function (e){
       quant = $('input[name="quantity"]').val()// e.target.getAttribute('data-quantity');
       
       $("input[cmnt='d']").each(function(i, e){
           e.remove()
       })
       
       for(i = 1; i <= quant; i++){
           $('input[name="quantity"]').after('<input type="text" name="cmnt_'+i+'" placeholder="Comentário" cmnt="d" required> ')
       }
       $('input[name="cmnt_q"]').val(quant)
       
       if(quant > 0){
           mostrarComentarios = true; 
       }
       
       if(cookies){
           // se tiver cookies ele ocuta o campo email e telefone
           $('.ocutar-campos').hide()
           $("#inputEmail").attr("type", 'hidden');
           $("#phone").attr("type", 'hidden');
           $(".iti").hide(); // Isso oculta o elemento de mascara do telefone
           $('.continuar-fluxo-normal').hide()
       }
       
   })
   
   $("button[data-bs-target='#passo01']").click(function(e){
       var islink = $(this).data('islink');
       type = $(this).data('islink');
        
       $("#divInstagram").hide()
       $("#divInstagramLike").hide()
       
       @if ( $category->id == 2 ) 
       if(islink == 1 || islink == 4){
           $("#title01").text('Digite link da publicação ou vídeo')
           
           $("#linkEmbed").change(function(e){
               embed =  $(this).val().slice(-1) == "/" ?  'embed' : '/embed' 
               
               $('#frameEmbed').attr('src', $(this).val()+embed)
               // $('#divInstagram').show()
           })
       }else if(islink == 2){
           $("#title01").text('Digite link da publicação ou vídeo')
       }else if(islink == 3){ 
           $("#title01").text('Digite o link do usuário')
           $("#linkInstagram").change(function(e){})
           
           $("#linkEmbed").change(function(e){
               addLink('https://www.instagram.com/', $(this).val())
           })
       }
       else{
           $("#title01").text('Digite link da publicação ou vídeo')
           $("#linkEmbed").change(function(e){
               addLink('', $(this).val())
           })
       }
       @else
           if(islink == 3){
               $("#title01").text('Digite o link do usuário')
               $("#linkEmbed").change(function(e){
                   addLink('', $(this).val())
               })
           }else{
               $("#title01").text('Digite link da publicação ou vídeo')
               $("#linkEmbed").change(function(e){
                   addLink('', $(this).val())
               })
           }
       @endif
   })
   function addLink(link, val){
       embed = link + val
       $('#framelike').attr('href', embed)
       // $('#divInstagramLike').show()
   }
   
   
   //mp
   var intervalId; // Variável para armazenar o ID do intervalo
   var urlIspay = "{{ route('web.purchases.ispay', ['purchase' => '#']) }}"; // Variável para armazenar o ID do intervalo
   
   $("#formPurchase").submit(function(e){
       
       e.preventDefault()
       
       if(!cookies){
           var telefone = $("#phone_code").val() + $("#phone").val(); 
           
           if (telefone.length < 9) {
               $("#telefone_erro").css('display', 'block');
               return;
           } else {
               $("#telefone_erro").css('display', 'none');
           }
       }
       
       var botaoClicado = e.originalEvent.submitter;
   
       if ($(botaoClicado).text().trim() === "Adicionar ao carrinho") {
           $('#passo02').modal('hide');
           adicionarCarrinho();
           return;
       }
       
       $('#passo02').modal('hide')
   
       $('#contentCupomCart').hide();
       $('#contentCupomDetalhes').show();
       
   
       $('#passo03').modal('show')
   })
   $("#btnCard").click(function(e){
   
       $("#passo04").modal('hide');
       $('#modalAcceptCard').modal('show');
   
   })
   $("#btnPIX").click(function(e){
       
       e.preventDefault()
   
       //unifica o input de telefone
       $("#phone").val($("#phone_code").val() + $("#phone").val());
   
       clearInterval(intervalId);
       $('#passo04').modal('hide');
       $('#pix').modal('show');
       
       //se tiver carrinho o fluxo é diferente
       if(cookies){
           pixCart();
           return;
       }
       
       
       $.post($('#formPurchase').attr('action') + '/pix', $('#formPurchase').serializeArray() , function(response){
           //console.log(response)
           var obj = JSON.parse(response);
   
   
           var base64 = obj.transaction_data.qr_code_base64;
           var codePix = obj.transaction_data.qr_code;
   
           $("#load").hide();
   
           $("#img-pix").attr('src', 'data:image/jpeg;base64,'+base64);
           $("#code-pix").val(codePix);
   
           $("#dix-pix").show();
   
           urlIspay = urlIspay.replace("#", obj.purchase);
   
           intervalId = setInterval(enviarRequisicao, 5000);
       });
   })
   
   function enviarRequisicao() {
       $.ajax({
           url: urlIspay,
           type: "POST",
           success: function (response) {
               //console.log("Requisição enviada com sucesso:", response);
             
               var obj = JSON.parse(response);
               if (obj.status === true) {
                   clearInterval(intervalId); // Interrompe o intervalo se o response for true
                   window.location.href = urlRedirectSuccess;
               }
           },
           error: function (xhr, status, error) {
             console.error("Erro na requisição:", error);
           }
       });
   }
   function alteraIcon(button,icon) {
       // Selecionar todas as imagens com a classe 'imagem-classe'
       var imagens = $('.img-category');
           
       // Iterar por todas as imagens e alterar o valor do atributo 'src'
       imagens.each(function () {
           $(this).attr('src', icon);
       });
       // Salvar a referência do último botão clicado
       lastClickedButton = button;
   }
   //button_checkbox 
   $("#button_checkbox").click(function (e) {
       
   if (!$("#check_link").is(":checked")) {
       e.preventDefault(); // Impede a ação padrão de avançar para o próximo modal
       $("#label_link").css("color", "red");
   } 
   });
   
   
   // AREA ONDE É TRATADO OS CUPONS 
   let cupomInputEntrada = $('#cupomInputEntrada');
   let campoPrecoOld = $("#totalInstagram");
   let campoPreco = $("#totalPrice");
   
   
   let tempo; // tempo
   let intervalo = 1000; //1 segundo
   let cupomForm = $("#cupomForm");
   let feedbackCupom = $("#feedbackCupom");
   
   //chama função apenas depois de 1 segundo de inatividade do cupom
   cupomInputEntrada.keyup('input', function () { 
       clearTimeout(tempo);
       if (cupomInputEntrada.val()) {
           tempo = setTimeout(aplicarDesconto, intervalo);
       }
   });
   
   
   $("#cupomInputEntrada").blur(function() {
       aplicarDesconto();
   });
   
   // //Logica do cupom
    function aplicarDesconto() {
       campoPrecoOld.removeClass();
       campoPreco.removeClass();
   
       var cupons = {!! $cupons !!};
       var cupomDigitado = cupomInputEntrada.val().toUpperCase();
       var categoria = $('input[name="categoria_id"]').val();
       var plano = $('input[name="plano_id"]').val();
       var email = $('input[name="email"]').val();
   
   
       //atualiza o nome do cupom que o usuario digitou
       cupomForm.val(cupomDigitado);
   
       if (cupomInputEntrada.val() == '') {
           feedbackCupom.html("");
           return;
       }
       
       var preco = parseFloat(campoPrecoOld.text().includes(',')
           ? campoPrecoOld.text().split('R$')[1].replace(',', '.')
           : campoPrecoOld.text().split(':')[1]
       );
   
       $.post("{{ route('web.verificarCupom') }}",{ 
           _token: "{{ csrf_token() }}",
           cupom: cupomDigitado,
           categoria:categoria,
           plano: plano,
           email: email,
       }, function(response) {
           if (response.status === "success") {
              
   
               var descontoDecimal = 1 - (response.desconto / 100);
               var totalComDesconto = arredondarParaDuasCasasDecimais(preco * descontoDecimal);
               
               $('#amount').val(totalComDesconto);
   
               campoPrecoOld.addClass('none');
               campoPreco.addClass('block');
   
               campoPreco.text('Total com desconto: R$' + totalComDesconto.toFixed(2));
               feedbackCupom.text("");
   
           } else {
               
               $('#amount').val(preco);
               
               campoPreco.addClass('none');
               campoPrecoOld.addClass('block');
   
               feedbackCupom.html(response.message);
           }
       }, "json")
       .fail(function() {
            
           $('#amount').val(preco);
            
           feedbackCupom.html("Erro ao validar o cupom, tente novamente.");
       }); 
   }
   
   
   function arredondarParaDuasCasasDecimais(numero) {
       var multiplicador = 100; // 10 elevado à potência do número de casas decimais desejado
       return Math.ceil(numero * multiplicador) / multiplicador;
   }
   
   
</script>
<script defer>
   function voltarAoModal(modal) {
   
       //segundo modal
       if(modal == 2){
           $('#passo02').modal('hide');
           $('#passo022').modal('hide');
   
           //limpar o input do link
           $("#linkEmbed").val('');
           $(lastClickedButton).click();
   
       }
   
       //terceiro modal
       if(modal == 3){
           
           //se tiver o carrinho aberto ele volta para o carrinho
           if(cookies){
               $("#modalCart").modal('show');
           }else{
               // Abrir o Modal 1
               $('#passo02').modal('show');
           }
           // Fechar o Modal 2
           $('#passo03').modal('hide');
       }
   
       //quarto modal
       if(modal == 4){
           
           $('#passo03').modal('show');
   
           // Fechar o Modal 2
           $('#passo04').modal('hide');
           
       }  
   
   }
   
   function closeModal(){
   
       $("#linkEmbed").val('');
       $("#check_link").prop("checked", false);
       $("#accept_email").prop("checked", false);
       $("#check_insta").prop("checked", false);
       $("#cupomInputEntrada").val('');
       $('input[name="email"]').val('');
       $('input[name="telefone"]').val('');
       $('input[name="profile"]').val('');
       $('input[name="cupom"]').val('');
       $('input[name="quantity"]').val('');
       $('input[name="cmnt_q"]').val('');
       $("#feedbackCupom").text('');
       $("#phone").val();
       $("#divRetornoDadosApi").hide();
       resetMercadoPagoForm();
   }
   
   $(document).ready(function () {
       
       $("#linkEmbed").blur(function(e){
           
           link =  $(this).val(); 
           // console.log('aqui dentor');
           let platform = '{{$category->title}}';
   
           // tranformar letras minusculas
           platform = platform.toLowerCase();
           $("#urlEscolhida").val(link);
           
           if(platform == 'youtube' || type != 3){
               //getPlatformData(link, platform, type);
               // return;
           }
   
           $("#divRetornoDadosApi").html('');
           $("#divRetornoDadosApi").hide();
           
       })
       
       // Inicializa o intlTelInput com a configuração de idioma para português
       let input = document.querySelector("#phone");
       let iti = window.intlTelInput(input, {
           utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.12/js/utils.js",
           placeholderNumberType: "MOBILE",
           initialCountry: "BR",
           separateDialCode: true,
           preferredCountries: ["BR"], // Define o Brasil como país preferido
       });
   
       $("#phone").mask('(00) 0 0000-0000', {
           translation: {
               '+': {
                   pattern: /\+/,
                   optional: true
               }
           }
       });
       
       $("#cpf").mask('000.000.000-00', {
           translation: {
               '+': {
                   pattern: /\+/,
                   optional: true
               }
           }
       });
       
   
       // Adiciona um ouvinte de evento ao campo de input gerado pelo intlTelInput
       input.addEventListener('countrychange', function () {
           var codigoPais = iti.getSelectedCountryData();
           
           // Verifica se um país foi selecionado
           if (codigoPais) {
               console.log(codigoPais.dialCode);
   
               if(codigoPais.dialCode == 55){
                   // Adiciona a máscara ao campo de input usando jQuery Mask
                   $("#phone").mask('(00) 0 0000-0000', {
                       translation: {
                           '+': {
                               pattern: /\+/,
                               optional: true
                           }
                       }
                   });
               }else{
                   // remove mascara antiga
                   $("#phone").unmask();
               }
   
               // Atualiza o valor do campo de entrada com o código de país selecionado
               $("#phone_code").val("+" + codigoPais.dialCode);
           } else {
               
               $("#phone_code").val("");
           }
       });
   });
   
   function copyPixCode() {
   
       var copyText = document.getElementById("code-pix");
       copyText.select();
       copyText.setSelectionRange(0, 99999); /* For mobile devices */
       document.execCommand("copy");
       alert("Chave PIX copiado: " + copyText.value);
   }
   
   let cookies = <?php echo isset($_COOKIE['seguirplay_cookies_aceitos']) ? 'true' : 'false' ?>;
   
   if (cookies) {
       // Verifica se o cookie 'user' existe
       let userCookie = getCookie('userCart');
       
       if (userCookie) {
           try {
               let user = JSON.parse(userCookie); // Converte JSON para objeto
                               
               // Atualiza os campos do formulário
               $('input[name="email"]').val(user.email);
               $('input[name="telefone"]').val(user.telefone);
               $('#link_cart').show();
           } catch (e) {
               console.error("Erro ao processar o cookie 'user':", e);
           }
       }
   }
   
   // Função para pegar um cookie pelo nome
   function getCookie(name) {
       let cookies = document.cookie.split('; ');
       for (let i = 0; i < cookies.length; i++) {
           let cookie = cookies[i].split('=');
           if (cookie[0] === name) {
               return decodeURIComponent(cookie[1]);
           }
       }
       return null;
   }
   
   
   
   function aceitarCookies() {
      
       cookies = true;        
   
       $.get("{{ route('cookies') }}", function(response){});
   
       $('#modalCookie').modal('hide');
   
       adicionarCarrinho();
   
   }
   
   function recusarCookie() {
       cookies = false;
       $('#modalCookie').modal('hide');
       $('#passo02').modal('show');
   }
   
   
   function adicionarCarrinho() {
       
       if(!cookies){
           $('#modalCookie').modal('show');
           return;
       }
       
       $("#continuarCompraCarrinhoButton").show();
       $("#limparCarrinho").show();
   
       $("#phone").val($("#phone_code").val() + $("#phone").val());
       let dados = $('#formPurchase').serializeArray();
       let urlCart = $('input[name="urlActionCart"]').val();
   
       //adicionar produto
       $.post(urlCart, dados, function(response){
           //traz carrinho
           
           $('#link_cart').show();
           mostrarCarrinho()
       });
   
   }
   
   function mostrarCarrinho()
   {
       $.get("{{ route('cart') }}", function(response){
           $('#corpo_carrinho').html(response);
           $('#modalCart').modal('show');
       });
   }
   
   function limparCarrinho(){
       Swal.fire({
           title: 'Tem certeza que deseja limpar o carrinho?',
           text: "Esta ação não poderá ser desfeita!",
           icon: 'warning',
           showCancelButton: true,
           confirmButtonColor: '#3085d6',
           cancelButtonColor: '#d33',
           confirmButtonText: 'Sim, limpar!',
           cancelButtonText: 'Cancelar'
       }).then((result) => {
           if (result.isConfirmed) {
               $.ajax({
                   url: "{{ route('cartClear') }}",
                   method: 'GET',
                   success: function(response) {
                      
                       
                       $("#totalCarrinhoSpan").text("0,00");
                       $('#cartItems').text("");
                       $("#continuarCompraCarrinhoButton").hide();
                       $("#limparCarrinho").hide();
   
                       Swal.fire(
                       'Limpo!',
                       'Carrinho limpo com sucesso.',
                       'success'
                       );
                   },
                   error: function() {
                       // Caso ocorra um erro
                       Swal.fire(
                           'Erro!',
                           'Ocorreu um erro ao Limpar o carrinho.',
                           'error'
                       );
                   }
               });
           }
       });
   }
   function getPlatformData(url, platform, type, pageToken = null) {
   
      
       let action = "{{ route('web.getPlatformData', ['platform' => ':platform']) }}";
       
       $.ajax({
           url: action.replace(':platform', platform),
           type: "POST",
           data: { 
               url: url,
               seguidores: type,
               pageToken: pageToken,
               _token: "{{ csrf_token() }}"
           },
           success: function (response) {
               
               $("#divRetornoDadosApi").hide();
               $('#retornoVerificaLink').hide();
               
               if (response.error) {
                   // Exibe mensagem de erro se houver
                   $('#retornoVerificaLink').html(response.error);
                   $('#retornoVerificaLink').show();
                   return;
               }
   
               
               $("#divRetornoDadosApi").html(response);
               $("#divRetornoDadosApi").show();
   
               $(".video").click(function () {
                   // Desmarca todos os checkboxes e remove a classe 'selected'
                   $(".video input[type='checkbox']").prop("checked", false);
                   $(".video").removeClass("selected");
   
                   // Marca o checkbox clicado e adiciona a classe 'selected'
                   var checkbox = $(this).find("input[type='checkbox']");
                   checkbox.prop("checked", true);
                   $(this).addClass("selected");
   
                   // Exibe o valor da URL no console
                   $("#urlEscolhida").val(checkbox.val());
   
               });
           },
           error: function (xhr) {
               console.error("Erro ao buscar dados:", xhr.responseText);
           }
       });
   }
   
   
   function pixCart(){
   
       $.ajax({
           url: "{{ route('web.purchases.pixCart') }}",
           type: 'get',
           data: {
               _token: "{{ csrf_token() }}",
               cupom: cupomForm.val()
           },
           success: function(response) {
   
               var obj = JSON.parse(response);
               var base64 = obj.transaction_data.qr_code_base64;
               var codePix = obj.transaction_data.qr_code;
   
               $("#load").hide();
   
               $("#img-pix").attr('src', 'data:image/jpeg;base64,'+base64);
               $("#code-pix").val(codePix);
   
               $("#dix-pix").show();
   
               urlIspay = urlIspay.replace("#", obj.purchase);
   
               intervalId = setInterval(enviarRequisicao, 5000);
           }
       });
   
   }
   
   function abrirModalCupom() {
       
       total = $("#totalCarrinhoSpan").text();
       $('#amount').val(total.replace('R$ ', '').replace(',', '.'));
       $("#totalInstagram").text("Total: R$ " + total);
       $('#passo03').modal('show');
       $("#modalCart").modal('hide');
       
       campoPreco.addClass('none');
       campoPrecoOld.addClass('block');
       campoPrecoOld.removeClass('none');
   
       $('#contentCupomCart').show();
       $('#contentCupomDetalhes').hide();
   }
   
   function adicionarServicos(){
       $('#modalCart').modal('hide');
       closeModal();
   }
   
   function loadPage(pageToken, channelUrl) {
       // Exibe um indicador de carregamento
       $("#videoGrid").html('<p>Carregando vídeos...</p>');
       getPlatformData(channelUrl, 'youtube', 1, pageToken);
   }
   
   function aceitarCard() {
       $('#modalAcceptCard').modal('hide');
       $('#modalInfoCard').modal('show');
   }
   
   function recusarCard() {
       $('#modalAcceptCard').modal('hide');
       $('#passo02').modal('show');
   }
   
   function prosseguirCardPagamento() 
   {
        const cpf = $('#cpf').val();
        const nomeCompleto = $('#nomeCompleto').val();
        const dataNascimento = $('#dataNascimento').val();
   
        if (!cpf || !nomeCompleto || !dataNascimento) {
            alert('Preencha todos os campos antes de prosseguir.');
            return;
        }

        const dataHoje = new Date().toISOString().split('T')[0]; // formato YYYY-MM-DD

        if (dataNascimento >= dataHoje) {
            alert('A data de nascimento deve ser anterior à data de hoje.');
            return;
        }
    
        // Preenche os campos no formulário final
        $('#formPurchase').append(`<input type="hidden" name="cpf" value="${cpf}">`);
        $('#formPurchase').append(`<input type="hidden" name="nome_completo" value="${nomeCompleto}">`);
        $('#formPurchase').append(`<input type="hidden" name="data_nascimento" value="${dataNascimento}">`);
   
        if(cookies){
            cardCart(cpf, nomeCompleto, dataNascimento);
            return;
        }

        $.post($('#formPurchase').attr('action') + '/buyCard', $('#formPurchase').serializeArray() , function(response){

            if(response.status){
                $('#modalInfoCard').modal('hide');
                $("#purchase_id").val(response.purchase_id);

            // Cria o formulário do MercadoPago
            let amount = parseFloat($('#amount').val()); // Valor da compra

            // Verifica se o valor é válido
            if (isNaN(amount) || amount <= 0) {
                alert('Valor de pagamento inválido');
                return;
            }

            // aumenta 12% no amount
            amount = (amount * 1.12).toFixed(2); // Aumenta 12% no valor

            $('paymentForm__cardholderName').val(nomeCompleto);
            $('paymentForm__identificationNumber').val(cpf);

            // Cria o formulário do MercadoPago dinamicamente
            let mp = new MercadoPago('APP_USR-0994e00d-a445-4b70-a5dc-f17ebc7a268a');
            let cardForm = mp.cardForm({
                amount: amount.toString(), // Passa o valor como string
                iframe: true,
                form: {
                    id: "paymentForm",
                    cardNumber: {
                        id: "paymentForm__cardNumber",
                        placeholder: "Número do cartão",
                    },
                    expirationDate: {
                        id: "paymentForm__expirationDate",
                        placeholder: "MM/YY",
                    },
                    securityCode: {
                        id: "paymentForm__securityCode",
                        placeholder: "Código de segurança",
                    },
                    cardholderName: {
                        id: "paymentForm__cardholderName",
                        placeholder: "Titular do cartão",
                    },
                    issuer: {
                        id: "paymentForm__issuer",
                        placeholder: "Banco emissor",
                    },
                    installments: {
                        id: "paymentForm__installments",
                        placeholder: "Parcelas",
                    },
                    identificationType: {
                        id: "paymentForm__identificationType",
                        placeholder: "Tipo de documento",
                    },
                    identificationNumber: {
                        id: "paymentForm__identificationNumber",
                        placeholder: "Número do CPF",
                    },
                    cardholderEmail: {
                        id: "paymentForm__cardholderEmail",
                        placeholder: "E-mail",
                    },
                },
                callbacks: {
                    onFormMounted: error => {
                        if (error) return console.warn("Form Mounted handling error: ", error);
                        console.log("Form mounted");
                    },
                    onSubmit: event => {
                        event.preventDefault();

                        const {
                            paymentMethodId: payment_method_id,
                            issuerId: issuer_id,
                            cardholderEmail: email,
                            amount,
                            token,
                            installments,
                            identificationNumber,
                            identificationType,
                        } = cardForm.getCardFormData();

                        const formData = new FormData();
                        formData.append('token_card', token);
                        formData.append('installments', installments);
                        formData.append('paymentMethodId', payment_method_id);
                        formData.append('email', email);
                        formData.append('cpf', identificationNumber);
                        formData.append('purchase_id', $('#purchase_id').val());
                        formData.append('_token', "{{ csrf_token() }}");

                        $.ajax({
                        url: urlProcessPaymentCard, // Sua rota Laravel para processar o pagamento
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        beforeSend: function () {
                            $('#loading').css('display', 'flex'); // Mostra o loading
                        },
                        success: function (data) {
                            console.log('Resposta do pagamento:', data);
                            if (data.success) {
                                window.location.href = urlRedirectSuccess;
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error('Erro ao enviar pagamento:', error);
                            // alert('Erro na requisição AJAX');
                        },
                        complete: function () {
                            $('#loading').css('display', 'none'); // Mostra o loading
                        }
                    });
                    },
                    onFetching: (resource) => {
                        console.log("Fetching resource: ", resource);

                        // Animate progress bar
                        const progressBar = document.querySelector(".progress-bar");
                        progressBar.removeAttribute("value");

                        return () => {
                            progressBar.setAttribute("value", "0");
                        };
                    }
                },
            });

                $("#card").modal('show');
                return;
            }

            alert('Erro ao processar o pagamento, tente novamente mais tarde.');

        });  
   
   }
   
   function cardCart(cpf, nomeCompleto, dataNascimento) {
   
       $.ajax({
           url: "{{ route('web.purchases.cardCart') }}",
           type: 'get',
           data: {
               _token: "{{ csrf_token() }}",
               cupom: cupomForm.val(),
               cpf: cpf,
               nome_completo: nomeCompleto,
               data_nascimento: dataNascimento
           },
           success: function(response) {
                console.log(response);
                
               if(response.status){
                   $('#modalInfoCard').modal('hide');
                   $("#card").modal('show');
                   $('#purchase_id').val(response.purchase_id);
                   $('#amount').val(response.amount);
                   return;
               }
   
               alert('Erro ao processar o pagamento, tente novamente mais tarde.');
           }
       });
   
   }
   
   function atualizarValorBotao() {
       let valor = parseFloat($('#amount').val());

        // valor-botao é o campo que contém o valor do botão
        if (isNaN(valor) || valor <= 0) {
              valor = 0; // Define um valor padrão se o valor for inválido
        }

        // Formata o valor para padrão BRL (ex: 1.234,56)
        function formatBRL(value) {
            return Number(value).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        }

        $('.valor-botao-pix').text(formatBRL(valor));

        // cartão acrescenta 12%
        valor = (valor * 1.12).toFixed(2); // Aumenta 12% no valor
        $('.valor-botao-cartao').text(formatBRL(valor));
        
   }


    function resetMercadoPagoForm() {
        $('.div-card').html(`
            <form id="paymentForm">
                <div id="paymentForm__cardNumber" class="container-div-form-card"></div>
                <div id="paymentForm__expirationDate" class="container-div-form-card"></div>
                <div id="paymentForm__securityCode" class="container-div-form-card"></div>
                <input type="text" id="paymentForm__cardholderName"/>
                <select id="paymentForm__issuer" class="form-control select-form-card ocutar"></select>
                <select id="paymentForm__installments" class="form-control select-form-card"></select>
                <select id="paymentForm__identificationType" class="form-control select-form-card ocutar"></select>
                <input type="text" id="paymentForm__identificationNumber"/>
                <input type="email" id="paymentForm__cardholderEmail"/>
                <button type="submit" id="paymentForm__submit">Pagar</button>
                <progress value="0" class="progress-bar ocutar">Carregando...</progress>
            </form>
        `);
        // Limpa os campos do formulário de data nascimento, CPF e nome completo
        $('#cpf').val('');
        $('#nomeCompleto').val('');
        $('#dataNascimento').val('');
    }

   
</script>
