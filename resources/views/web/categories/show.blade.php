@extends('web.templates.master')


@php
    $title = 'Conquiste Seguidores '.$category->title.' | Aumente Seu Engajamento';
    $description = 'Turbine o engajamento nas redes sociais com a Seguir Play. Ganhe curtidas, seguidores e interações reais em todas as plataformas. Visibilidade e crescimento garantidos!';
    $keywords = 'engajamento redes sociais, engajamento nas redes sociais, aumentar visibilidade redes sociais';
    
    if ($category->title === 'Instagram') {
        $title = 'Conquiste Seguidores no Instagram - Ganhe Seguidores Reais e Aumente seu Engajamento';
        $description = 'Aumente seu alcance no Instagram com seguidores reais e curtidas. Com a Seguir Play, você pode Conquiste seguidores no Instagram e ver seu perfil crescer com mais engajamento e credibilidade. Experimente agora!';
        $keywords = 'Conquiste seguidores no Instagram, seguidores reais Instagram, ganhar seguidores Instagram, aumentar engajamento Instagram';
    }
    
    if ($category->title === 'TikTok') {
        $title = 'Conquiste Seguidores TikTok | Seguir Play - Ganhe Seguidores Reais no TikTok';
        $description = 'Ganhe seguidores reais e amplie seu perfil no TikTok! A Seguir Play oferece seguidores reais TikTok para fortalecer seu engajamento. Conquiste seguidores TikTok nunca foi tão seguro e eficiente.';
        $keywords = 'Conquiste seguidores TikTok, seguidores reais TikTok, Conquiste seguidor TikTok, ganhar seguidores TikTok';
    }
    
    if ($category->title === 'Youtube') {
        $title = 'Monetização YouTube: Como Monetizar seu Canal com a Seguir Play';
        $description = 'Quer saber como monetizar o YouTube? Na Seguir Play, ajudamos você a alcançar a monetização e aumentar sua receita. Potencialize seu canal e ganhe inscritos no YouTube com segurança!';
        $keywords = 'monetização YouTube, como monetizar o YouTube, ganhar inscritos YouTube';
    }
    
    if ($category->title === 'Facebook') {
        $title = 'Conquiste Curtidas no Facebook | Impulsione seu Engajamento';
        $description = 'Conquiste curtidas no Facebook é fácil e seguro com a Seguir Play. Aumente a visibilidade e engajamento da sua página. Veja nossos planos e escolha o ideal para você!';
        $keywords =  'Conquiste curtidas Facebook, Conquiste seguidores no Facebook, aumentar engajamento Facebook';
    
    }
    
    if ($category->title === 'Twitch') {
        $title = 'Conquiste Espectadores na live twitch | Aumente seu engajamento e visibilidade';
        $description = 'Conquiste Espectadores na live twitch com a Seguir Play, turbine suas lives no Twitch agora mesmo com nossos serviços 100% seguro e entrega imediata. Veja nossos planos e escolha o ideal para você!';
        $keywords =  'Conquiste visualizações twitch, bot de visualizações twitch, Conquiste seguidores twitch';
    
    } 
    
    if ($category->title === 'kick') {
        $title = 'Conquiste Espectadores ao Vivo na Kick | Aumente a visibilidade das suas transmissões ao vivo';
        $description = 'Conquiste Espectadores na live kick com a Seguir Play, Na Seguir Play ajudamos você aumente sua visibilidade na Kick com visualizadores ao vivo. Veja nossos planos e escolha o ideal para você!';
        $keywords =  'Conquiste visualizações live kick, bot de visualizações kick, Conquiste seguidores kick';
    
    }
        
    if ($category->title === 'Kwai') {
        $title = 'Conquiste Seguidores Brasileiros Kwai | Impulsione seu perfil no Kwai';
        $description = 'Conquiste Seguidores Kwai vai impulsionar o seu perfil? Com a Seguir Play você aumenta o nivél do seu perfil no Kwai. Turbine seu perfil e obtenha novos seguidores!';
        $keywords =  'Conquiste seguidores Kwai, Conquiste visualizações kwai, Conquiste curtidas kwai';
    
    }
            
    if ($category->title === 'WhatsApp') {
        $title = 'Conquiste Seguidores WhatsApp | Aumenta credibilidade do seu canal no WhatsApp';
        $description = 'Conquiste Seguidores WhatsApp na Seguir Play vai aumenta credibilidade? Aumente a autoridade do seu canal com um número significativo de membros. Faça seu canal do WhatsApp crescer!';
        $keywords =  'Conquiste membros canal whatsapp, Conquiste seguidores canal whatsapp, Conquiste Reações Postar Canal WhatsApp';
    
    }
                
    if ($category->title === 'Telegram') {
        $title = 'Conquiste membros para o Telegram | Aumenta Presença no Telegram com Seguir Play';
        $description = 'Conquiste Membros Telegram é uma estratégia eficaz para impulsionar o crescimento canal. Impulsione seu canal Telegram. Experimente agora!';
        $keywords =  'Conquiste membros canal Telegram, Conquiste reações telegram, Conquiste visualizações telegram';
    
    }
                    
    if ($category->title === 'LinkedIn') {
        $title = 'Conquiste Curtidas no LinkedIn | Aumenta Presença no LinkedIn com Seguir Play';
        $description = 'Compre Seguidores e Curtidas no LinkedIn com a Seguir Play é completamente seguro e aumentar sua visibilidade. Experimente agora!';
        $keywords =  'Conquiste seguidores linkedin, Conquiste curtidas linkedin, Conquiste Reações linkedin';
    
    }
                    
    if ($category->title === 'Loco') {
        $title = 'Conquiste Visualizações ao vivo na Loco | Aumente seus especetador com Seguir Play';
        $description = 'Conquiste Espectadores na live Loco com a Seguir Play é completamente seguro e aumentar sua visibilidade. Experimente agora!';
        $keywords =  'Conquiste visualizações ao vivo loco, Conquiste visualizações ao vivo na loco, Conquiste visualizações para ao vivo loco';
    
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
