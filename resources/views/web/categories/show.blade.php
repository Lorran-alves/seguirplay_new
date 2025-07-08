@extends('web.templates.master')


@php
    $title = 'Impulsione Seu Perfil '.$category->title.' - Aumente Seu Engajamento';
    $description = 'Potencialize o engajamento nas suas redes sociais com a Seguir Play. Alcance curtidas, seguidores e interações autênticas em todas as plataformas. Amplie sua visibilidade e crescimento!';
    $keywords = 'engajamento redes sociais, engajamento nas redes sociais, aumentar visibilidade redes sociais, marketing digital';
    
    if ($category->title === 'Instagram') {
        $title = 'Impulsione Seu Instagram | Alcance Engajamento Autêntico';
        $description = 'Aumente seu alcance no Instagram com seguidores engajados e curtidas. Com a Seguir Play, você pode impulsionar seu Instagram e ver seu perfil crescer com mais engajamento e credibilidade. Experimente agora!';
        $keywords = 'impulsionar seguidores Instagram, seguidores engajados Instagram, aumentar engajamento Instagram, marketing Instagram';
    }
    
    if ($category->title === 'TikTok') {
        $title = 'Impulsione Seu TikTok | Alcance Engajamento Autêntico';
        $description = 'Alcance seguidores e amplie seu perfil no TikTok! A Seguir Play oferece estratégias para fortalecer seu engajamento. Impulsionar seguidores no TikTok nunca foi tão seguro e eficiente.';
        $keywords = 'impulsionar seguidores TikTok, seguidores engajados TikTok, aumentar engajamento TikTok, marketing TikTok';
    }
    
    if ($category->title === 'Youtube') {
        $title = 'Monetização YouTube: Como Potencializar seu Canal com a Seguir Play';
        $description = 'Quer saber como monetizar o YouTube? Na Seguir Play, ajudamos você a alcançar a monetização e aumentar sua receita. Potencialize seu canal e ganhe inscritos no YouTube com segurança!';
        $keywords = 'monetização YouTube, como monetizar o YouTube, ganhar inscritos YouTube, crescimento de canal YouTube';
    }
    
    if ($category->title === 'Facebook') {
        $title = 'Aumente Curtidas no Facebook | Impulsione seu Engajamento';
        $description = 'Aumentar curtidas no Facebook é fácil e seguro com a Seguir Play. Amplie a visibilidade e engajamento da sua página. Veja nossos planos e escolha o ideal para você!';
        $keywords = 'aumentar curtidas Facebook, impulsionar seguidores no Facebook, engajamento Facebook, marketing Facebook';
    }
    
    if ($category->title === 'Twitch') {
        $title = 'Aumente Espectadores em Live na Twitch | Impulsione seu Engajamento e Visibilidade';
        $description = 'Aumente espectadores em live na Twitch com a Seguir Play. Impulsione suas transmissões agora mesmo com nossos serviços 100% seguros e entrega eficiente. Veja nossos planos e escolha o ideal para você!';
        $keywords = 'aumentar visualizações Twitch, impulsionar lives Twitch, aumentar seguidores Twitch, marketing Twitch';
    }
    
    if ($category->title === 'kick') {
        $title = 'Aumente Espectadores ao Vivo na Kick | Amplie a Visibilidade das Suas Transmissões';
        $description = 'Aumente espectadores em live na Kick com a Seguir Play. Na Seguir Play, ajudamos você a ampliar sua visibilidade na Kick com visualizadores ao vivo. Veja nossos planos e escolha o ideal para você!';
        $keywords = 'aumentar visualizações live Kick, impulsionar lives Kick, aumentar seguidores Kick, marketing Kick';
    }
    
    if ($category->title === 'Kwai') {
        $title = 'Impulsione Seguidores Brasileiros no Kwai | Amplie seu Perfil no Kwai';
        $description = 'Impulsionar seguidores no Kwai irá potencializar o seu perfil. Com a Seguir Play, você eleva o nível do seu perfil no Kwai. Potencialize seu perfil e obtenha novos seguidores!';
        $keywords = 'impulsionar seguidores Kwai, aumentar visualizações Kwai, aumentar curtidas Kwai, marketing Kwai';
    }
    
    if ($category->title === 'WhatsApp') {
        $title = 'Aumente Seguidores no WhatsApp | Aumente a Credibilidade do seu Canal';
        $description = 'Aumentar seguidores no WhatsApp com a Seguir Play irá elevar a credibilidade. Aumente a autoridade do seu canal com um número significativo de membros. Faça seu canal do WhatsApp crescer!';
        $keywords = 'aumentar membros canal WhatsApp, aumentar seguidores canal WhatsApp, reações em post de canal WhatsApp';
    }
    
    if ($category->title === 'Telegram') {
        $title = 'Aumente Membros para o Telegram | Potencialize Sua Presença no Telegram';
        $description = 'Aumentar membros no Telegram é uma estratégia eficaz para impulsionar o crescimento do canal. Potencialize seu canal Telegram. Experimente agora!';
        $keywords = 'aumentar membros canal Telegram, aumentar reações Telegram, aumentar visualizações Telegram, marketing Telegram';
    }
    
    if ($category->title === 'LinkedIn') {
        $title = 'Impulsione Curtidas no LinkedIn | Aumente Sua Presença com a Seguir Play';
        $description = 'Impulsionar seguidores e curtidas no LinkedIn com a Seguir Play é completamente seguro e aumentará sua visibilidade. Experimente agora!';
        $keywords = 'impulsionar seguidores LinkedIn, aumentar curtidas LinkedIn, reações LinkedIn, marketing LinkedIn';
    }
    
    if ($category->title === 'Loco') {
        $title = 'Aumente Visualizações ao Vivo na Loco | Potencialize Seus Espectadores com a Seguir Play';
        $description = 'Aumente espectadores em live na Loco com a Seguir Play. É completamente seguro e aumentará sua visibilidade. Experimente agora!';
        $keywords = 'aumentar visualizações ao vivo Loco, aumentar espectadores ao vivo na Loco, visualizações para live Loco, marketing Loco';
    }
@endphp

@section('title', $title)
@section('description', $description)
@section('keywords', $keywords)

@section('content')
    <header class="header">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h1>{{ $category->title }}</h1>
                    <p><a href="{{ route('web.home') }}" class="text-decoration-none text-white">Home</a>
                        > {{ $category->title }}</p>
                </div>

            </div>
        </div>
    </header>

    <section class="value">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>{{ $category->title }}</h2>
                </div>

                @include('web.includes.post')
            </div>
        </div>
    </section>
@endsection
