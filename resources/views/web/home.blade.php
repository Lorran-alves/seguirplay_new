@extends('web.templates.master')
@section('title', 'Conquiste  Seguidores Instagram e TikTok | Seguir Play - Aumente Seu Engajamento')
@section('description', 'Quer aumentar a visibilidade no Instagram e TikTok? A Seguir Play oferece planos para você Conquiste  seguidores reais e aumentar seu engajamento nas redes sociais. Impulsione seu perfil de forma segura e rápida!')
@section('keywords', 'Conquiste  seguidores Instagram, Conquiste  seguidores no Instagram, comprar seguidores TikTok, engajamento redes sociais, seguidores reais TikTok, aumentar curtidas')
@section('content')
    <header>
        <div class="container">
            <div class="row">
                <div class="col-lg-5">
                    <h1>GANHE NOVOS SEGUIDORES E AUMENTE AS SUAS CURTIDAS NAS REDES SOCIAIS!</h1>
                    <p>Se você quer potencializar as suas redes sociais e vê-las decolar, clique no botão abaixo.</p>
                    <a href="#planos">
                        <button>Conheça os planos <i class="fas fa-arrow-right"></i></button>
                    </a>
                </div>

                <div class="col-lg-7">
                    <img src="{{ asset('web_assets/img/header.png') }}" style="max-width: 109%;">
                </div>
            </div>
        </div>
    </header>

    <!-- QUEM SOMOS -->
<?php print_r($order);?>
<?php print_r($user);?>
<?php print_r($status);?>
    <section class="who-we-are">
        <div class="container">
            <div class="row">

                <div class="col-lg-6">
                    <img src="{{ asset('web_assets/img/banner01.png') }}">
                </div>

                <div class="col-lg-6 mauto">
                    <h2>TURBINAR SEGUIDORES PELA SEGUIR PLAY É SEGURO?</h2>
                    <p>Sim! Essa é uma estratégia recomendada por muitos especialistas de marketing, pois irá te ajudar a aumentar o seu alcance de maneira objetiva, rápida e eficiente.</p>
                    <p>A Seguir Play prioriza a sua segurança e qualidade dos nossos serviços. Chegou a hora de você atingir um novo patamar nas suas redes sociais.</p>

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
                    <img src="{{{ asset('web_assets/img/social02.png') }}}">
                    <h3>Instagram</h3>
                    <p>Turbine o seu Instagram e conquiste a credibilidade do seu público.</p>
                </div>

                <div class="col-lg-3 text-center">
                    <img src="{{ asset('web_assets/img/social03.png') }}">
                    <h3>TikTok</h3>
                    <p>Ganhe novos seguidores reais no seu perfil.</p>
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
                    <p>Essa é uma ótima estratégia para você que deseja aumentar o seu engajamento, mostrar a sua marca para um maior número de pessoas, aumentar a sua visibilidade e credibilidade dentro do mercado digital. Esse é o primeiro passo para decolar a sua carreira ou negócio.</p>

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
          <h2>Outros serviços para rede sociais</h2>
        </div>

        <div class="col-12 col-lg-3 box">
          <div class="row">
            <div class="col-lg-12 box_01">
               <img class="icons" src="web_assets/img/insta.png">
              <h3>Instagram</h3>
              <button class="purchase-button"><a href="{{ route('web.categories.show', ['slug' => 'comprar-seguidores-instagram']) }}">Comprar Agora</a> <i class="fas fa-arrow-right"></i></button>
            </div>
          </div>
        </div>
        
        <div class="col-12 col-lg-3 box">
          <div class="row">
            <div class="col-lg-12 box_01">
               <img class="icons" src="web_assets/img/icons/youtube.png">
              <h3>Youtube</h3>
              <button class="purchase-button"><a href="{{ route('web.categories.show', ['slug' => 'comprar-seguidores-youtube']) }}">Comprar Agora</a> <i class="fas fa-arrow-right"></i></button>
            </div>
          </div>
        </div>

        <div class="col-12 col-lg-3 box">
          <div class="row">
            <div class="col-lg-12 box_01">
              <img class="icons" src="web_assets/img/icons/tiktok.png">
              <h3>Tik Tok</h3>
              <button class="purchase-button"><a href="{{ route('web.categories.show', ['slug' => 'comprar-seguidores-tik-tok']) }}">Comprar Agora</a> <i class="fas fa-arrow-right"></i></button>
            </div>
          </div>
        </div>

        <div class="col-12 col-lg-3 box">
          <div class="row">
            <div class="col-lg-12 box_01">
              <img class="icons" src="web_assets/img/icons/facebook.png">
              <h3>Facebook</h3>
              <button class="purchase-button"><a href="{{ route('web.categories.show', ['slug' => 'comprar-seguidores-facebook']) }}">Comprar Agora</a> <i class="fas fa-arrow-right"></i></button>
            </div>
          </div>
        </div>

        <div class="col-12 col-lg-3 box">
          <div class="row">
            <div class="col-lg-12 box_01">
              <img class="icons" src="web_assets/img/icons/kwai.png">
              <h3>Kwai</h3>
              <button class="purchase-button"><a href="{{ route('web.categories.show', ['slug' => 'comprar-seguidores-kwai']) }}">Comprar Agora</a> <i class="fas fa-arrow-right"></i></button>
            </div>
          </div>
        </div>
        
        <!-- Aplicar, mas precisa do formato certo da icone --->
        
        <div class="col-12 col-lg-3 box">
          <div class="row">
            <div class="col-lg-12 box_01">
              <img class="icons" src="web_assets/img/icons/x1.png">
              <h3>X Twitter</h3>
              <button class="purchase-button"><a href="{{ route('web.categories.show', ['slug' => 'comprar-seguidores-x-twitter']) }}">Comprar Agora</a> <i class="fas fa-arrow-right"></i></button>
            </div>
          </div>
        </div>
        
       <div class="col-12 col-lg-3 box">
          <div class="row">
            <div class="col-lg-12 box_01">
              <img class="icons" src="web_assets/img/icons/1twitch.png">
              <h3>Twitch</h3>
              <button class="purchase-button"><a href="{{ route('web.categories.show', ['slug' => 'comprar-seguidores-twitch']) }}">Comprar Agora</a> <i class="fas fa-arrow-right"></i></button>
            </div>
          </div>
        </div>
        
        
       <div class="col-12 col-lg-3 box">
          <div class="row">
            <div class="col-lg-12 box_01">
              <img class="icons" src="web_assets/img/icons/Rumble.png">
              <h3>Rumble</h3>
              <button class="purchase-button"><a href="{{ route('web.categories.show', ['slug' => 'comprar-seguidores-rumble']) }}">Comprar Agora</a> <i class="fas fa-arrow-right"></i></button>
            </div>
          </div>
        </div>
        
        <div class="col-12 col-lg-3 box">
          <div class="row">
            <div class="col-lg-12 box_01">
              <img class="icons" src="web_assets/img/icons/Kick.png">
              <h3>Kick</h3>
              <button class="purchase-button"><a href="{{ route('web.categories.show', ['slug' => 'comprar-seguidores-kick']) }}">Comprar Agora</a> <i class="fas fa-arrow-right"></i></button>
            </div>
          </div>
        </div>
        
        <div class="col-12 col-lg-3 box">
          <div class="row">
            <div class="col-lg-12 box_01">
              <img class="icons" src="web_assets/img/icons/loco.png">
              <h3>Loco</h3>
              <button class="purchase-button"><a href="{{ route('web.categories.show', ['slug' => 'comprar-seguidores-loco']) }}">Comprar Agora</a> <i class="fas fa-arrow-right"></i></button>
            </div>
          </div>
        </div>
        
        <div class="col-12 col-lg-3 box">
          <div class="row">
            <div class="col-lg-12 box_01">
              <img class="icons" src="web_assets/img/icons/Telegram.png">
              <h3>Telegram</h3>
              <button class="purchase-button"><a href="{{ route('web.categories.show', ['slug' => 'comprar-seguidores-telegram']) }}">Comprar Agora</a> <i class="fas fa-arrow-right"></i></button>
            </div>
          </div>
        </div>
        
        <div class="col-12 col-lg-3 box">
          <div class="row">
            <div class="col-lg-12 box_01">
              <img class="icons" src="web_assets/img/icons/Linkedin.png">
              <h3>Linkedin</h3>
              <button class="purchase-button"><a href="{{ route('web.categories.show', ['slug' => 'comprar-seguidores-linkedin']) }}">Comprar Agora</a> <i class="fas fa-arrow-right"></i></button>
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
                <h2>Dicas, Estratégias e Tendências para <br> Turbinar suas Redes Sociais</h2>
                    <p>Aprenda como crescer nas principais plataformas com insights exclusivos sobre engajamento, monetização e seguidores reais.</p>
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
                    <h2>Como funciona</h2>
                    <p>Aqui, você irá conhecer como funciona o método da Seguir Play para turbinar as suas redes sociais. Temos uma comunidade de perfis que ganham dinheiro para seguir, curtir, comentar e promover outras interaçõs de acordo com os seus próprios interesses. Com isso, a interaçõe torna-se real e auténtica.</p>
                    <p>Também utilizamos a inteligência artificial para direcionar o seu perfil ou conteúdo para a audiencia desejada. Isso tudo é feito por meio de pesquisas, rede de display interna, links externos e anúncios nativos. </p>
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
