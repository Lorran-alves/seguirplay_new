<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Seguir Play - Compra Realizada Com Sucesso</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* Estilos Globais */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      background-color: #f9f9f9;
      color: #333;
      line-height: 1.6;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
    }

    .container {
      max-width: 600px;
      width: 100%;
      background: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
      text-align: center;
      margin: 20px;
    }

    .logo img {
      max-width: 150px;
      margin-bottom: 20px;
    }

    h1 {
      color: #7d255d;
      font-size: 28px;
      margin-bottom: 20px;
    }

    .info {
      margin-bottom: 30px;
      text-align: left;
    }

    .info-item {
      display: flex;
      align-items: center;
      margin-bottom: 12px;
    }

    .info-item i {
      color: #7d255d;
      margin-right: 10px;
      font-size: 18px;
    }

    .info-item span {
      font-weight: bold;
      color: #555;
      padding-right: 3px
    }

    .buttons {
      display: flex;
      flex-direction: column;
      gap: 15px;
      margin-bottom: 20px;
    }

    .button {
      background-color: #7d255d;
      color: #fff;
      padding: 12px;
      border: none;
      border-radius: 250px;
      cursor: pointer;
      font-size: 16px;
      text-transform: uppercase;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      text-decoration: none
    }

    .button:hover {
      background-color: #5a1b45;
    }

    .back-home {
      background-color: #ddd;
      color: #333;
    }

    .back-home:hover {
      background-color: #ccc;
    }

    footer {
      margin-top: 20px;
      font-size: 14px;
      color: #777;
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 15px;
    }

    footer a {
      color: #7d255d;
      text-decoration: none;
      margin: 0 5px;
    }

    footer a:hover {
      text-decoration: underline;
    }

    @media (max-width: 768px) {
      .container {
        padding: 20px;
      }

      h1 {
        font-size: 24px;
      }

      .info-item {
        flex-direction: row;
        align-items: flex-start;
      }

      .info-item i {
        margin-bottom: 5px;
      }

      footer {
        flex-direction: column;
        align-items: center;
      }
    }
    .button-carrinho-customizado {
        width: 35px;
        height: 35px;
        border: none;
        border-radius: 0;
        color: black;
        background: transparent !important;
        margin-top: 0 !important;
    }

    .button-carrinho-customizado i{
        color: black;
    }

    .button-carrinho-customizado:hover{
        background-color: #f8f9fa !important;
    }
  </style>
  
  <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-16855212060"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
    
      gtag('config', 'AW-16855212060');
    </script>
  
  <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-KK8CVLZ');</script>
  <!-- End Google Tag Manager -->
</head>
<body>
  <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KK8CVLZ"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->  
  
  <div class="container">
    <div class="logo">
      <img src="https://seguirplay.com/web_assets/img/logo_footer.png" alt="Logo da Empresa">
    </div>
    <?php
      $total = 0;

      if (isset($purchases) && count($purchases) > 0) {
          foreach($purchases as $p) {
              $total += $p->price;
          }
      } else {
          $total = $purchase->price;
      }
    ?>
    
    <h1>Obrigado por sua compra!</h1>
    <div class="info">
      <div class="info-item"><i class="fas fa-hashtag"></i> <span>Número do pedido:</span> {{$purchase->id}}</div>
      <div class="info-item"><i class="fas fa-envelope"></i> <span>E-mail:</span> {{ $purchase->email }}</div>
      <div class="info-item"><i class="fas fa-phone"></i> <span>Telefone: </span> {{ $purchase->telefone }}</div>
      <div class="info-item"><i class="fas fa-money-bill-wave"></i> <span>Valor total: </span> R$ {{ number_format($total, 2, ',', '.') }}</div>
      <div class="info-item"><i class="fas fa-calendar-alt"></i> <span>Data e hora: </span> {{ date('d/m/Y H:i',strtotime($purchase->created_at)) }}</div>
    </div>
    <div class="buttons">
      <button class="button" data-bs-toggle="modal" data-bs-target="#pedidoModal">Informações do Pedido</button>
      <a href="{{ route('web.pedidos')}}" class="button">Acompanhar Pedido</a>
      <a href="https://seguirplay.bio.link/" class="button">Suporte</a>
      <a href="{{ route('web.home')}}" class="button back-home">Voltar para Página Inicial</a>
    </div>
    <footer>
      Lembrete: Prazo de entrega é 0 A 24 HORAS, EM ÚLTIMO CASO 72 HORAS.
      <div style="margin-top: 10px;">
        <a href="https://seguirplay.com/politicas-de-privacidade">Política de Privacidade</a> | 
        <a href="https://seguirplay.com/termos-e-condicoes">Termos de Uso</a> | 
        <a href="https://seguirplay.bio.link/"><i class="fab fa-instagram"></i></a> 
        <a href="https://seguirplay.bio.link/"><i class="fab fa-facebook"></i></a>
      </div>
    </footer>
  </div>
  <div class="modal fade" id="pedidoModal" tabindex="-1" aria-labelledby="pedidoModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="pedidoModalLabel">Informações do Pedido</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div style="overflow: auto;" id="cartItems">
                  @foreach ($purchases as $purchase)
                    <div class="cart-item mb-3" id="item{{ $purchase->id }}">
                      <div class="d-flex justify-content-between align-items-center" style="background-color: #f1eeee; padding: 10px; border-radius:5px;">
                        <div>
                            <strong>{{ Str::limit($purchase->plan->title, 30, '...') }}</strong>
                        </div>
                        <div>
                          <button class="button-carrinho-customizado" type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#itemDetails{{ $purchase->id }}" aria-expanded="false"
                            aria-controls="itemDetails{{ $purchase->id }}">
                            <i class="fas fa-eye"></i>
                          </button>
                        </div>
                      </div>
                      <div class="collapse" id="itemDetails{{ $purchase->id }}">
                        <div class="card card-body mt-2 paragrafos-customizado">
                          <p><strong>Serviço:</strong> {{ $purchase->plan->title }}</p>
                          <p><strong>Rede Social:</strong> {{ $purchase->plan->category->title }}</p>
                          <p><strong>Link:</strong> <a href="{{ $purchase->profile }}"
                                    target="_blank">{{ $purchase->profile }}</a></p>
                          <p><strong>Quantidade:</strong> {{ $purchase->quantity}}</p>
                          <p><strong>Preço:</strong> R${{ number_format($purchase->price, 2, ',', '.') }}</p>

                          @if (isset($item['comments']))
                            <table class="table table-bordered">
                              <thead>
                                <tr>
                                  <th>Comentários</th>
                                </tr>
                              </thead>
                              <tbody>
                                @foreach ($purchase->comments as $comment)
                                  <tr>
                                    <td>{{ $comment }}</td>
                                  </tr>
                                @endforeach
                              </tbody>
                            </table>
                          @endif
                        </div>
                      </div>
                    </div>
                  @endforeach
                </div>
              </div>
            </div>
          </div>
        </div>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Script para capturar valores e disparar eventos -->
    <script>
      // Função para capturar os valores da compra, telefone e e-mail
      function captureAndSendEvents() {
        // Capturar os valores dos elementos na página
        const purchaseValueElement = document.querySelector('.info-item span:contains("Valor total:")')?.nextSibling;
        const phoneElement = document.querySelector('.info-item span:contains("Telefone:")')?.nextSibling;
        const emailElement = document.querySelector('.info-item span:contains("E-mail:")')?.nextSibling;
    
        // Extrair os valores
        const purchaseValue = purchaseValueElement ? purchaseValueElement.textContent.trim() : 'N/A';
        const phone = phoneElement ? phoneElement.textContent.trim() : 'N/A';
        const email = emailElement ? emailElement.textContent.trim() : 'N/A';
    
        // Disparar eventos para o Google Tag Manager
        if (purchaseValue !== 'N/A') {
          window.dataLayer = window.dataLayer || [];
          window.dataLayer.push({
            event: 'purchase_value_event',
            purchaseValue: purchaseValue
          });
          console.log('Evento disparado para valor da compra:', purchaseValue);
        }
    
        if (phone !== 'N/A') {
          window.dataLayer = window.dataLayer || [];
          window.dataLayer.push({
            event: 'phone_event',
            phone: phone
          });
          console.log('Evento disparado para telefone:', phone);
        }
    
        if (email !== 'N/A') {
          window.dataLayer = window.dataLayer || [];
          window.dataLayer.push({
            event: 'email_event',
            email: email
          });
          console.log('Evento disparado para e-mail:', email);
        }
      }
    
      // Executar a função após o carregamento da página
      document.addEventListener('DOMContentLoaded', captureAndSendEvents);
    </script>
    <script>
     document.addEventListener("DOMContentLoaded", function () {
        console.log('teste');
    
        // Usa a mesma rota definida no Blade
        const url = "{{ route('web.api_simples', $purchase->id) }}";
    
        fetch(url)
          .then(response => {
            
          })
          .then(data => {
            console.log('Requisição para /api concluída com sucesso:', data);
          })
          .catch(error => {
            console.error('Erro ao fazer requisição para /api:', error);
          });
      });
    </script>
</body>
</html>