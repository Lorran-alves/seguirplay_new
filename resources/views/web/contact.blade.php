@extends('web.templates.master')
@section('title', 'Contato')
@section('description', 'Leia e compreenda completamente os Termos de Uso antes de efetuar qualquer transação na Seguir Play')
@section('content')
    <header class="header">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h1>Ficou alguma dúvida? <br> fale conosco.</h1>
                    <p><a href="{{ route('web.home') }}" class="text-decoration-none text-white">Home</a> > Contato</p>
                </div>

            </div>
        </div>
    </header>

    <section class="contact">
        <div class="container">
            <div class="row">

                <div class="col-lg-6">
                    <h2 style="font-family: 'Poppins' !important;">VAMOS <b>AUMENTAR</b> OS SEUS <b>SEGUIDORES</b> E DECOLAR AS SUAS <b>REDES SOCIAIS?</b></h2>
                    <p>Preencha o formulário para solicitar o nosso contato ou fale com a gente por meio de nossos canais.</p>
                    <a href="https://www.facebook.com/seguirplaybr/" target="_blank"><img src="{{ asset('web_assets/img/facebook.png') }}"></a>
                    <a href="https://www.instagram.com/seguirplaybr/?igshid=YmMyMTA2M2Y%3D" target="_blank" class="space-footer"><img src="{{ asset('web_assets/img/instagram.png') }}"></a>
                    <a href="https://api.whatsapp.com/send?phone=5511985868006" target="_blank"><img src="{{ asset('web_assets/img/telefone.png') }}"></a>
                </div>
                
                <div class="col-lg-6 contact_form">
                    
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success">{{session('success')}}</div>
                    @endif
                    
                    <form method="post" action="{{ route('web.contactform') }}">
                        @csrf
                        <input type="text" placeholder="Nome" name="name">
                        <input type="text" placeholder="E-mail" name="email">
                        <input type="text" placeholder="WhatApp" name="number">
                        <input type="text" placeholder="Link da Rede Social" name="url">
                        <textarea placeholder="Mensagem" name="message"></textarea>
                        <button>Enviar</button>
                    </form>
                </div>

            </div>
        </div>
    </section>
@endsection
