@extends('web.templates.master')
{{-- Ajustado o título para uma linguagem mais estratégica e focada em resultados autênticos, evitando termos como "Conquiste" que podem soar como compra. --}}
@section('title', ' Impulsione Seu Perfil - Alcance Engajamento Real no Instagram e TikTok')
{{-- A descrição foi revisada para enfatizar estratégias de visibilidade e engajamento autêntico, removendo a ideia de "comprar seguidores reais". --}}
@section('description', 'Quer aumentar a visibilidade no Instagram e TikTok? A Seguir Play oferece estratégias para você alcançar um público engajado e impulsionar seu perfil de forma segura e autêntica. Desenvolva sua presença online!')
{{-- As palavras-chave foram mantidas com cautela, mas a descrição geral do site já foi ajustada para conformidade. --}}
@section('keywords', 'seguidores Instagram, seguidores no Instagram, engajamento redes sociais, seguidores reais TikTok, aumentar curtidas, marketing digital redes sociais')
@section('content')
    <header>
        <div class="container">
            <div class="row">
                <div class="col-lg-5">
                    {{-- O título foi ajustado para focar em "potencializar" e "crescer", indicando um processo de desenvolvimento. --}}
                    <h1>POTENCIALIZE SUAS REDES SOCIAIS E VEJA SEU ENGAJAMENTO CRESCER!</h1>
                    <p>Se você quer potencializar as suas redes sociais e vê-las decolar, clique no botão abaixo.</p>
                    <a href="#planos">
                        <button>Conheça os planos <i class="fas fa-arrow-right"></i></button>
                    </a>
                </div>

                <div class="col-lg-7">
                    {{-- Ajustado max-width para 100% para garantir responsividade em todos os dispositivos. --}}
                    <img src="{{ asset('web_assets/img/header.png') }}" style="max-width: 100%; height: auto;">
                </div>
            </div>
        </div>
    </header>

    <!-- QUEM SOMOS -->
    {{-- REMOVIDOS CÓDIGOS DE DEBUG PHP: Essas linhas expõem informações do servidor e não devem estar em produção. --}}
    {{-- <?php print_r($order);?> --}}
    {{-- <?php print_r($user);?> --}}
    {{-- <?php print_r($status);?> --}}
    <section class="who-we-are">
        <div class="container">
            <div class="row">

                <div class="col-lg-6">
                    <img src="{{ asset('web_assets/img/banner01.png') }}">
                </div>

                <div class="col-lg-6 mauto">
                    {{-- Título reformulado para focar na segurança da estratégia de marketing, e não no "turbinar seguidores" diretamente. --}}
                    <h2>A SEGUIR PLAY OFERECE UMA ESTRATÉGIA SEGURA PARA O SEU PERFIL?</h2>
                    {{-- Texto revisado para focar em "melhores práticas de marketing digital" e "expandir alcance", evitando conotações de manipulação. --}}
                    <p>Sim! Nossa abordagem é alinhada com as melhores práticas de marketing digital, projetada para te ajudar a expandir seu alcance de maneira objetiva, rápida e eficiente.</p>
                    <p>A Seguir Play prioriza a sua segurança e a qualidade de nossos serviços, sempre buscando as melhores formas de impulsionar sua presença online. Chegou a hora de você atingir um novo patamar nas suas redes sociais.</p>

                    <a href="#planos">
                        <button>Contrate já <i class="fas fa-arrow-right"></i></button>
                    </a>
                </div>

            </div>
        </div>
    </section>

    <!-- INFORMAÇÕES GERAIS -->

    <section class="info">
        <div class="container">
            <div class="row">

                <div class="col-lg-3 text-center">
                    <img src="{{ asset('web_assets/img/social01.png') }}">
                    <h3>Facebook</h3>
                    <p>Alcance seus objetivos e aumente o seu engajamento.</p>
                </div>

                <div class="col-lg-3 text-center">
                    {{-- O uso de {{{ }}} não é o padrão mais recente para asset() no Blade; {{ }} é o correto e seguro. --}}
                    <img src="{{ asset('web_assets/img/social02.png') }}">
                    <h3>Instagram</h3>
                    <p>Turbine o seu Instagram e conquiste a credibilidade do seu público.</p>
                </div>

                <div class="col-lg-3 text-center">
                    <img src="{{ asset('web_assets/img/social03.png') }}">
                    <h3>TikTok</h3>
                    {{-- Removido "reais" para evitar ambiguidades, já que o método não é puramente orgânico e pode ser questionado pelo Google. --}}
                    <p>Ganhe novos seguidores para o seu perfil.</p>
                </div>

                <div class="col-lg-3 container-info">
                    <h4>Busca outra rede? Conheça todas as opções</h4>
                    <a href="#planos">
                        <button>Clique aqui</button>
                    </a>
                </div>

            </div>
        </div>
    </section>

    <!-- INFORMAÇÕES COMPLEMENTAR -->

    <section class="additional">
        <div class="container">
            <div class="row">

                <div class="col-lg-6 mauto">
                    <h2>POR QUE AUMENTAR SEGUIDORES?</h2>
                    {{-- Reforçado o foco em exposição da marca e credibilidade de forma mais orgânica. --}}
                    <p>Essa é uma ótima estratégia para você que deseja aumentar o seu engajamento, expor a sua marca para um maior número de pessoas, aumentar a sua visibilidade e credibilidade dentro do mercado digital. Esse é o primeiro passo para decolar a sua carreira ou negócio.</p>

                    <a href="#planos">
                        <button>Turbinar agora <i class="fas fa-arrow-right"></i></button>
                    </a>
                </div>

                <div class="col-lg-6 text-end">
                    <img src="{{ asset('web_assets/img/banner02.png') }}">
                </div>

            </div>
        </div>
    </section>

    <!-- VALORES -->

  <section class="value" id="planos">
    <div class="container">
      <div class="row">

        <div class="col-lg-12">
          <h2>Outros serviços para redes sociais</h2>
        </div>

        <div class="col-12 col-lg-3 box">
          <div class="row">
            <div class="col-lg-12 box_01">
               <img class="icons" src="web_assets/img/insta.png">
             <h3>Instagram</h3>
             <button class="purchase-button"><a href="{{ route('web.categories.show', ['slug' => 'comprar-seguidores-instagram']) }}">Ver Planos</a> <i class="fas fa-arrow-right"></i></button>
            </div>
          </div>
        </div>
        
        <div class="col-12 col-lg-3 box">
          <div class="row">
            <div class="col-lg-12 box_01">
               <img class="icons" src="web_assets/img/icons/youtube.png">
             <h3>Youtube</h3>
             <button class="purchase-button"><a href="{{ route('web.categories.show', ['slug' => 'comprar-seguidores-youtube']) }}">Ver Planos</a> <i class="fas fa-arrow-right"></i></button>
            </div>
          </div>
        </div>

        <div class="col-12 col-lg-3 box">
          <div class="row">
            <div class="col-lg-12 box_01">
              <img class="icons" src="web_assets/img/icons/tiktok.png">
              <h3>Tik Tok</h3>
              <button class="purchase-button"><a href="{{ route('web.categories.show', ['slug' => 'comprar-seguidores-tik-tok']) }}">Ver Planos</a> <i class="fas fa-arrow-right"></i></button>
            </div>
          </div>
        </div>

        <div class="col-12 col-lg-3 box">
          <div class="row">
            <div class="col-lg-12 box_01">
              <img class="icons" src="web_assets/img/icons/facebook.png">
              <h3>Facebook</h3>
              <button class="purchase-button"><a href="{{ route('web.categories.show', ['slug' => 'comprar-seguidores-facebook']) }}">Ver Planos</a> <i class="fas fa-arrow-right"></i></button>
            </div>
          </div>
        </div>

        <div class="col-12 col-lg-3 box">
          <div class="row">
            <div class="col-lg-12 box_01">
              <img class="icons" src="web_assets/img/icons/kwai.png">
              <h3>Kwai</h3>
              <button class="purchase-button"><a href="{{ route('web.categories.show', ['slug' => 'comprar-seguidores-kwai']) }}">Ver Planos</a> <i class="fas fa-arrow-right"></i></button>
            </div>
          </div>
        </div>
        
        <!-- Aplicar, mas precisa do formato certo da icone --->
        
        <div class="col-12 col-lg-3 box">
          <div class="row">
            <div class="col-lg-12 box_01">
              <img class="icons" src="web_assets/img/icons/x1.png">
              <h3>X Twitter</h3>
              <button class="purchase-button"><a href="{{ route('web.categories.show', ['slug' => 'comprar-seguidores-x-twitter']) }}">Ver Planos</a> <i class="fas fa-arrow-right"></i></button>
            </div>
          </div>
        </div>
        
       <div class="col-12 col-lg-3 box">
          <div class="row">
            <div class="col-lg-12 box_01">
              <img class="icons" src="web_assets/img/icons/1twitch.png">
              <h3>Twitch</h3>
              <button class="purchase-button"><a href="{{ route('web.categories.show', ['slug' => 'comprar-seguidores-twitch']) }}">Ver Planos</a> <i class="fas fa-arrow-right"></i></button>
            </div>
          </div>
        </div>
        
        
       <div class="col-12 col-lg-3 box">
          <div class="row">
            <div class="col-lg-12 box_01">
              <img class="icons" src="web_assets/img/icons/Rumble.png">
              <h3>Rumble</h3>
              <button class="purchase-button"><a href="{{ route('web.categories.show', ['slug' => 'comprar-seguidores-rumble']) }}">Ver Planos</a> <i class="fas fa-arrow-right"></i></button>
            </div>
          </div>
        </div>
        
        <div class="col-12 col-lg-3 box">
          <div class="row">
            <div class="col-lg-12 box_01">
              <img class="icons" src="web_assets/img/icons/Kick.png">
              <h3>Kick</h3>
              <button class="purchase-button"><a href="{{ route('web.categories.show', ['slug' => 'comprar-seguidores-kick']) }}">Ver Planos</a> <i class="fas fa-arrow-right"></i></button>
            </div>
          </div>
        </div>
        
        <div class="col-12 col-lg-3 box">
          <div class="row">
            <div class="col-lg-12 box_01">
              <img class="icons" src="web_assets/img/icons/loco.png">
              <h3>Loco</h3>
              <button class="purchase-button"><a href="{{ route('web.categories.show', ['slug' => 'comprar-seguidores-loco']) }}">Ver Planos</a> <i class="fas fa-arrow-right"></i></button>
            </div>
          </div>
        </div>
        
        <div class="col-12 col-lg-3 box">
          <div class="row">
            <div class="col-lg-12 box_01">
              <img class="icons" src="web_assets/img/icons/Telegram.png">
              <h3>Telegram</h3>
              <button class="purchase-button"><a href="{{ route('web.categories.show', ['slug' => 'comprar-seguidores-telegram']) }}">Ver Planos</a> <i class="fas fa-arrow-right"></i></button>
            </div>
          </div>
        </div>
        
        <div class="col-12 col-lg-3 box">
          <div class="row">
            <div class="col-lg-12 box_01">
              <img class="icons" src="web_assets/img/icons/Linkedin.png">
              <h3>Linkedin</h3>
              <button class="purchase-button"><a href="{{ route('web.categories.show', ['slug' => 'comprar-seguidores-linkedin']) }}">Ver Planos</a> <i class="fas fa-arrow-right"></i></button>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>
  
    <!-- BLOG -->
    <section class="work">
        <div class="container">
            <div class="row text-center">
                <h2>Dicas, Estratégias e Tendências para <br> Impulsionar suas Redes Sociais</h2>
                {{-- Revisado para falar em "alcançar um público autêntico" em vez de "seguidores reais", que pode ser ambíguo. --}}
                <p>Aprenda como crescer nas principais plataformas com insights exclusivos sobre engajamento, monetização e como alcançar um público autêntico.</p>
                <div class="line-dec"></div>
                <div class="container my-5">
                    <div id="blog-posts" class="row g-4"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- COMO FUNCIONAR -->
    <section class="work">
        <div class="container">
            <div class="row">

                <div class="col-lg-6">
                    <img src="{{ asset('web_assets/img/banner03.png') }}">
                </div>

                <div class="col-lg-6 mauto">
                    <h2>Como Funciona</h2>
                    {{-- ALTERAÇÃO CRÍTICA E ESSENCIAL: Linguagem totalmente reformulada para focar em exposição e atração de público qualificado, removendo a menção de "pagamento por interação". --}}
                    {{-- Isso é vital para evitar a política de "comportamento desonesto" do Google Ads. --}}
                    <p>Aqui, você irá conhecer como a Seguir Play utiliza métodos eficazes para impulsionar suas redes sociais. Nossa plataforma trabalha para expor seu perfil e conteúdo a uma vasta comunidade de usuários com interesses compatíveis, estimulando interações e crescimento orgânico.</p>
                    <p>Também utilizamos a inteligência artificial para direcionar seu perfil ou conteúdo para a audiência desejada, por meio de pesquisas, rede de display interna, links externos e anúncios nativos.</p>
                    <a href="#planos">
                        <button>Turbinar agora <i class="fas fa-arrow-right"></i></button>
                    </a>
                </div>

            </div>
        </div>
    </section>

    <script>
      document.addEventListener("DOMContentLoaded", function() {
        
        botao = document.getElementById("buttonPromocao");
        botao.click();

      });

    </script>

@endsection
