<footer>
    <div class="container">
        <div class="row">

            <div class="col-lg-4">
                <img src="{{ asset('web_assets/img/logo_footer.png') }}">
                <p>Turbine as suas redes sociais conquistando mais seguidores e engajamentos com a Seguir Play. A maneira mais rápida e segura de alcançar os seus objetivos.</p>
            </div>

            <div class="col-lg">
                <h2>Categorias</h2>
                <a href="{{ route('web.categories.show', ['slug' => 'comprar-seguidores-instagram']) }}">Instagram</a>
                <br><a href="{{ route('web.categories.show', ['slug' => 'comprar-seguidores-youtube']) }}">Youtube</a>
                <br><a href="{{ route('web.categories.show', ['slug' => 'comprar-seguidores-tik-tok']) }}">TikTok</a>
                <br><a href="{{ route('web.categories.show', ['slug' => 'comprar-seguidores-facebook']) }}">Facebook</a>
                <br><a href="{{ route('web.categories.show', ['slug' => 'comprar-seguidores-kwai']) }}">kwai</a>
                <br><a href="{{ route('web.categories.show', ['slug' => 'comprar-seguidores-twitch']) }}">Twitch</a>
                <div class="dropdown"><button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false" style="color:#9E9E9E">+ Serviços</button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1" style="background-color: #ff455b">
                            <li>
                            <a class="dropdown-item" href="https://seguirplay.com/comprar-seguidores-twitch">Twitch</a>
                            </li>
                            <li>
                            <a class="dropdown-item" href="https://seguirplay.com/comprar-seguidores-rumble">Rumble</a>
                            </li>
                            <li>
                            <a class="dropdown-item" href="https://seguirplay.com/comprar-seguidores-x-twitter">X Twitter</a>
                            </li>
                            <li>
                            <a class="dropdown-item" href="https://seguirplay.com/comprar-seguidores-kick">Kick</a>
                            </li>
                            <li>
                            <a class="dropdown-item" href="https://seguirplay.com/comprar-seguidores-loco">Loco</a>
                            </li>
                            <li>
                            <a class="dropdown-item" href="https://seguirplay.com/comprar-seguidores-telegram">Telegram</a>
                            </li>
                            <li>
                            <a class="dropdown-item" href="https://seguirplay.com/comprar-seguidores-whatsApp">WhatsApp</a>
                            </li>
                            <li>
                            <a class="dropdown-item" href="https://seguirplay.com/comprar-seguidores-linkedin">Linkedin</a>
                            </li>
                            <li>
                            <a class="dropdown-item" href="https://seguirplay.com/comprar-seguidores-shopee">Shopee</a>
                            </li>
                            </ul>
                </div>
            </div>

            <div class="col-lg">
                <h2>Informações</h2>
                <a href="{{ route('web.faq') }}">Perguntas Frequentes</a>
                <br><a href="https://blog.seguirplay.com/o-que-e-seguir-play">O que é Seguir Play?</a>
                <br><a href="{{ route('web.policies') }}">Políticas de privacidade</a>
                <br><a href="{{ route('web.term') }}">Termos e Condições</a>
                <br><a href="https://www.blog.seguirplay.com/" target="_blank">Blog Seguir Play</a>
                <br><a href="https://www.monetizeseucanal.seguirplay.com">Monetize seu YouTube</a>
            </div>

            <div class="col-lg">
                <h2>Rede Social</h2>
                <a href="https://www.facebook.com/seguirplaybr/" target="_blank"><img src="{{ asset('web_assets/img/facebook.png') }}"></a>
                <a href="gruoposeguirplay.bio.link" class="space-footer" target="_blank"><img src="{{ asset('web_assets/img/instagram.png') }}"></a>
                <a href="{{route('web.contact')}}"><img src="{{ asset('web_assets/img/telefone.png') }}"></a>
            </div>

        </div>

        <div class="row footer">

            <div class="col-lg-4">
               <img src="{{ asset('web_assets/img/cards.png') }}">
            </div>

            <div class="col-lg-8 text-end mauto">
                <p>Copyright © {{ date('Y') }} {{ config('app.name') }}. Todos os direitos reservados. </p>
            </div>
        </div>
        <div style="text-align:center">
            
        <p>Não somos endossados ou certificados por nenhuma das plataformas de mídia social mencionadas neste site. Todos os logotipos e marcas registradas exibidos são de propriedade de seus respectivos proprietários. As imagens apresentadas são meramente ilustrativas e não indicam parcerias ou afiliações. O uso do nosso site constitui aceitação dos nossos termos de uso.</p>

        </div>

        <!-- Ricardo dia 07/09/2023
        
        <a href="https://wa.me/5511985868006" style="position:fixed;width:60px;height:60px;bottom:40px;right:40px;background-color:#781F60;color:#FFF;border-radius:50px;text-align:center;font-size:30px;" target="_blank">
            <i style="margin-top:15px; display: block" class="fa fa-whatsapp"></i> 
        
        -->
        
        
        <!-- Chat 
        Confuso? Podemos esclarecer tudo para você! -->
        
        <script type="module">
          import Typebot from 'https://cdn.jsdelivr.net/npm/@typebot.io/js@0.1/dist/web.js'
        
          Typebot.initBubble({
            typebot: "seguirplay",
            previewMessage: {
              avatarUrl:
                "https://s3.fr-par.scw.cloud/typebot/public/typebots/clm98rbfr000fl60fdm561veh/hostAvatar?v=1694112967241",
            },
            theme: {
              button: { backgroundColor: "#7D255D", size: "average" },
              chatWindow: { backgroundColor: "#ffffff" },
            },
          });
        </script>
    </div>
</footer>

