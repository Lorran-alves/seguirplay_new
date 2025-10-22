<?php
    $total = 0;
    $display_purchase = null; // Variável para a compra principal que será exibida

    // Se a lista de compras ($purchases) existir e não estiver vazia...
    if (isset($purchases) && count($purchases) > 0) {
        $display_purchase = $purchases[0]; // Usamos o primeiro item para os detalhes principais
        foreach($purchases as $p) {
            $total += $p->price; // Somamos o preço de todos os itens
        }
    } 
    // Senão, se apenas uma compra individual ($purchase) existir...
    elseif (isset($purchase)) {
        $display_purchase = $purchase; // Usamos essa compra para os detalhes
        $total = $purchase->price;
    }
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Seguir Play - Compra Realizada Com Sucesso</title>
    <!-- Fontes e Ícones -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Estilos Globais - TEMA LINHA DO TEMPO */
        :root {
            --primary-color: #5a1b45;
            --background-color: #f7f8fc;
            --card-background: #ffffff;
            --text-color-dark: #343a40;
            --text-color-light: #6c757d;
            --border-color: #e9ecef;
            --success-color: #28a745;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: var(--background-color);
            color: var(--text-color-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
        }
        
        /* Estrutura principal do layout */
        .page-wrapper {
            display: flex;
            max-width: 800px;
            width: 100%;
            background: var(--card-background);
            border-radius: 12px;
            box-shadow: 0 6px 30px rgba(0, 0, 0, 0.07);
            overflow: hidden;
        }

        .timeline-section {
            background-color: #f9fafb;
            padding: 40px 30px;
            width: 250px;
            border-right: 1px solid var(--border-color);
        }

        .timeline-item {
            position: relative;
            padding-left: 30px;
            padding-bottom: 30px;
            border-left: 2px solid var(--border-color);
        }
        .timeline-item:last-child {
            border-left: 2px solid transparent;
            padding-bottom: 0;
        }

        .timeline-item .icon {
            position: absolute;
            left: -9px;
            top: 0;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background-color: var(--border-color);
            border: 3px solid #f9fafb;
        }
        
        .timeline-item.completed .icon {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        .timeline-item.completed .icon::after {
            content: '\f00c';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            color: white;
            font-size: 8px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        
        .timeline-item h3 {
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 4px;
        }
         .timeline-item.completed h3 {
            color: var(--primary-color);
        }

        .timeline-item p {
            font-size: 13px;
            color: var(--text-color-light);
            line-height: 1.5;
        }

        .details-section {
            padding: 40px;
            flex-grow: 1;
        }
        
        .logo img {
            max-width: 100px;
            margin-bottom: 25px;
        }

        .details-section h1 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 25px;
        }
        
        /* NOVO ESTILO PARA A SEÇÃO INFO */
        .info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px 25px;
            margin-bottom: 30px;
        }
        .info-item { font-size: 14px; }
        .info-item .label {
            display: block;
            color: var(--text-color-light);
            font-size: 13px;
            margin-bottom: 4px;
        }
        .info-item .value {
             color: var(--text-color-dark);
             font-weight: 600;
             word-break: break-all;
        }

        .buttons {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-bottom: 20px;
        }

        .button {
            background-color: var(--primary-color);
            color: #fff;
            padding: 12px;
            border: 1px solid var(--primary-color);
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            text-align: center;
            text-decoration: none;
            transition: all 0.2s ease-in-out;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .button i { margin-right: 8px; }
        
        .button:hover {
            background-color: #481537;
            border-color: #481537;
        }
        .button.secondary-action {
            background-color: #f1eef0;
            color: var(--primary-color);
            border-color: #f1eef0;
        }
        .button.secondary-action:hover {
            background-color: #e8e1e5;
        }

        .button.back-home {
            background-color: transparent;
            color: var(--text-color-light);
            border: none;
            padding-top: 5px;
            font-weight: 500;
            text-decoration: none;
        }
        .button.back-home:hover {
            color: var(--primary-color);
        }

        footer {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid var(--border-color);
        }
        
        .footer-notes h4 {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-color-dark);
            margin-bottom: 15px;
        }
        .footer-notes p {
            font-size: 12px;
            color: var(--text-color-light);
            margin-bottom: 12px;
            display: flex;
            align-items: flex-start;
            line-height: 1.5;
        }
        .footer-notes p i {
            font-size: 12px;
            margin-right: 12px;
            margin-top: 2px;
            color: var(--primary-color);
            width: 16px;
            text-align: center;
            flex-shrink: 0;
        }
        .footer-notes p strong {
            font-weight: 600;
            color: var(--text-color-dark);
            flex-basis: 140px;
            flex-shrink: 0;
            margin-right: 5px;
        }
        
        .footer-links {
            text-align: center;
            color: var(--text-color-light);
        }
        .footer-links a {
            color: var(--text-color-light);
            text-decoration: none;
            font-size: 13px;
            margin: 0 8px;
            transition: color 0.2s ease-in-out;
        }
        .footer-links a:hover {
            color: var(--primary-color);
        }
        
        /* === OTIMIZAÇÃO PARA TELAS PEQUENAS === */
        @media (max-width: 768px) {
           .page-wrapper {
               flex-direction: column;
           }
           .timeline-section {
               width: 100%;
               border-right: none;
               border-bottom: 1px solid var(--border-color);
               padding: 30px 25px; /* Padding ajustado */
           }
           .details-section {
                padding: 30px 25px; /* Padding ajustado */
           }
           .details-section h1 {
                font-size: 22px; /* Fonte ajustada */
           }
           .info {
               grid-template-columns: 1fr;
               gap: 15px; /* Espaçamento ajustado */
           }
           .footer-notes p strong {
                flex-basis: auto; /* Permite quebra de linha natural */
           }
        }
        
        /* Estilos do Modal (Mantidos) */
        .modal-content { border-radius: 8px; border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        .modal-header { background-color: var(--primary-color); color: white; border-bottom: none; padding: 1rem 1.5rem; }
        .modal-header .btn-close { filter: invert(1) grayscale(100%) brightness(200%); }
        .modal-body { padding: 1.5rem; background-color: #f9f9f9; }
        .cart-item { background-color: #fff; border: 1px solid #eee; border-radius: 8px; padding: 1rem; transition: box-shadow 0.3s ease; }
        .cart-item:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
        .button-carrinho-customizado { background-color: transparent; border: 1px solid #ddd; border-radius: 50%; width: 38px; height: 38px; color: var(--primary-color); transition: all 0.3s ease; }
        .button-carrinho-customizado i { color: var(--primary-color); }
        .button-carrinho-customizado:hover { background-color: var(--primary-color); border-color: var(--primary-color); }
        .button-carrinho-customizado:hover i { color: #fff; }
        .card-body.paragrafos-customizado { background-color: #f7f7f7; margin-top: 1rem; border-radius: 6px; border-top: 2px solid var(--primary-color); padding: 1rem; }

    </style>

  <!-- TikTok Pixel Code Start -->
    <script>
    !function (w, d, t) {
    w.TiktokAnalyticsObject=t;var ttq=w[t]=w[t]||[];ttq.methods=["page","track","identify","instances","debug","on","off","once","ready","alias","group","enableCookie","disableCookie","holdConsent","revokeConsent","grantConsent"],ttq.setAndDefer=function(t,e){t[e]=function(){t.push([e].concat(Array.prototype.slice.call(arguments,0)))}};for(var i=0;i<ttq.methods.length;i++)ttq.setAndDefer(ttq,ttq.methods[i]);ttq.instance=function(t){for(
    var e=ttq._i[t]||[],n=0;n<ttq.methods.length;n++)ttq.setAndDefer(e,ttq.methods[n]);return e},ttq.load=function(e,n){var r="https://analytics.tiktok.com/i18n/pixel/events.js",o=n&&n.partner;ttq._i=ttq._i||{},ttq._i[e]=[],ttq._i[e]._u=r,ttq._t=ttq._t||{},ttq._t[e]=+new Date,ttq._o=ttq._o||{},ttq._o[e]=n||{};n=document.createElement("script")
    ;n.type="text/javascript",n.async=!0,n.src=r+"?sdkid="+e+"&lib="+t;e=document.getElementsByTagName("script")[0];e.parentNode.insertBefore(n,e)};


    ttq.load('D19JOJ3C77U5358112VG');
    ttq.page();
   }(window, document, 'ttq');
   </script>
  <!-- TikTok Pixel Code End -->
  
  <!-- TikTok Pixel Code Start -->
    <script>
    !function (w, d, t) {
      w.TiktokAnalyticsObject=t;var ttq=w[t]=w[t]||[];ttq.methods=["page","track","identify","instances","debug","on","off","once","ready","alias","group","enableCookie","disableCookie","holdConsent","revokeConsent","grantConsent"],ttq.setAndDefer=function(t,e){t[e]=function(){t.push([e].concat(Array.prototype.slice.call(arguments,0)))}};for(var i=0;i<ttq.methods.length;i++)ttq.setAndDefer(ttq,ttq.methods[i]);ttq.instance=function(t){for(
    var e=ttq._i[t]||[],n=0;n<ttq.methods.length;n++)ttq.setAndDefer(e,ttq.methods[n]);return e},ttq.load=function(e,n){var r="https://analytics.tiktok.com/i18n/pixel/events.js",o=n&&n.partner;ttq._i=ttq._i||{},ttq._i[e]=[],ttq._i[e]._u=r,ttq._t=ttq._t||{},ttq._t[e]=+new Date,ttq._o=ttq._o||{},ttq._o[e]=n||{};n=document.createElement("script")
    ;n.type="text/javascript",n.async=!0,n.src=r+"?sdkid="+e+"&lib="+t;e=document.getElementsByTagName("script")[0];e.parentNode.insertBefore(n,e)};
    
    
      ttq.load('D19JOJ3C77U5358112VG');
      ttq.page();
    }(window, document, 'ttq');
    </script>
  <!-- TikTok Pixel Code End -->
  
  <!-- Meta Pixel Code -->
    <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '298253899296628');
    fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id=298253899296628&ev=PageView&noscript=1"
    /></noscript>
    <!-- End Meta Pixel Code -->
  
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

    <div class="page-wrapper">
        <div class="timeline-section">
            <div class="timeline-item completed">
                <div class="icon"></div>
                <h3>Pagamento Aprovado</h3>
                <p>Sua compra foi confirmada com sucesso!</p>
            </div>
            <div class="timeline-item">
                <div class="icon"></div>
                <h3>Em Processamento</h3>
                <p>Clique em "Acompanhar Pedido" para ver as atualizações.</p>
            </div>
            <div class="timeline-item">
                <div class="icon"></div>
                <h3>Pedido Entregue</h3>
                <p>Seu pedido foi finalizado.</p>
            </div>
        </div>

        <div class="details-section">
            <div class="logo">
                <img src="https://seguirplay.com/web_assets/img/logo_footer.png" alt="Logo da Empresa">
            </div>

            <h1>Obrigado pela sua compra!</h1>
            
            @if ($display_purchase)
            <div class="info">
                <div class="info-item">
                    <span class="label">Número do pedido</span>
                    <strong class="value">{{ $display_purchase->id }}</strong>
                </div>
                <div class="info-item">
                    <span class="label">Data e hora</span>
                    <strong class="value">{{ date('d/m/Y H:i',strtotime($display_purchase->created_at)) }}</strong>
                </div>
                <div class="info-item">
                    <span class="label">E-mail</span>
                    <strong class="value">{{ $display_purchase->email }}</strong>
                </div>
                <div class="info-item">
                    <span class="label">Telefone</span>
                    <strong class="value">{{ $display_purchase->telefone }}</strong>
                </div>
                <div class="info-item">
                    <span class="label">Valor total</span>
                    <strong class="value">R$ {{ number_format($total, 2, ',', '.') }}</strong>
                </div>
            </div>

            <div class="buttons">
                <a href="{{ route('web.pedidos', ['email' => $display_purchase->email])}}" class="button">Acompanhar Pedido</a>
                <button class="button secondary-action" data-bs-toggle="modal" data-bs-target="#pedidoModal">Ver Detalhes do Pedido</button>
                <a href="https://api.whatsapp.com/send?phone=5511985868006&text=Ol%C3%A1%2C%20preciso%20de%20suporte%20para%20o%20pedido%20de%20n%C3%BAmero%3A%20{{$display_purchase->id}}.%20Poderiam%20me%20ajudar%2C%20por%20favor%3F" target="_blank" class="button secondary-action"><i class="fab fa-whatsapp"></i> Falar com Suporte</a>
                <a href="#" class="button back-home">Voltar para Página Inicial</a>
            </div>
            @endif
            
            <footer>
                <div class="footer-notes">
                    <h4>Lembretes Importantes:</h4>
                    <p><i class="fas fa-clock"></i><strong>Serviços Gerais:</strong> Prazo de entrega de até 24 horas, podendo estender-se a 72 horas.</p>
                    <p><i class="fas fa-video"></i><strong>Serviços em LIVES:</strong> Prazo de entrega de 10 a 20 minutos.</p>
                    <p><i class="fas fa-hourglass-half"></i><strong>Horas de Exibição:</strong> Prazo de entrega de 7 a 30 dias (não pode ser acelerado).</p>
                </div>
                <div class="footer-links" style="margin-top: 20px;">
                    <a href="https://seguirplay.com/politicas-de-privacidade">Política de Privacidade</a> | 
                    <a href="https://seguirplay.com/termos-e-condicoes">Termos de Uso</a> | 
                    <a href="https://seguirplay.bio.link/"><i class="fab fa-instagram"></i></a> 
                    <a href="https://seguirplay.bio.link/"><i class="fab fa-facebook"></i></a>
                </div>
            </footer>
        </div>
    </div>
    
    <!-- Modal (Estrutura interna inalterada) -->
    <div class="modal fade" id="pedidoModal" tabindex="-1" aria-labelledby="pedidoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pedidoModalLabel">Detalhes do Pedido</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div style="overflow: auto;" id="cartItems">
                        @if (isset($purchases) && count($purchases) > 0)
                        @foreach ($purchases as $purchase_item)
                        <div class="cart-item mb-3" id="item{{ $purchase_item->id }}">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ Str::limit($purchase_item->plan->title, 30, '...') }}</strong>
                                </div>
                                <div>
                                    <button class="button-carrinho-customizado" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#itemDetails{{ $purchase_item->id }}" aria-expanded="false"
                                        aria-controls="itemDetails{{ $purchase_item->id }}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="collapse" id="itemDetails{{ $purchase_item->id }}">
                                <div class="card card-body mt-2 paragrafos-customizado">
                                    <p><strong>Serviço:</strong> {{ $purchase_item->plan->title }}</p>
                                    <p><strong>Rede Social:</strong> {{ $purchase_item->plan->category->title }}</p>
                                    <p><strong>Link:</strong> <a href="{{ $purchase_item->profile }}"
                                            target="_blank">{{ $purchase_item->profile }}</a></p>
                                    <p><strong>Quantidade:</strong> {{ $purchase_item->quantity}}</p>
                                    <p><strong>Preço:</strong> R${{ number_format($purchase_item->price, 2, ',', '.') }}</p>
                        
                                    @if (!empty($purchase_item->comments))
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Comentários</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($purchase_item->comments as $comment)
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
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KK8CVLZ" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

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
  </body>
</html>

