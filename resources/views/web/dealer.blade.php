@extends('web.templates.master')
@section('title', 'Seja um revendedor')
@section('content')
    <header class="header">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h1>Seja um <br> Revendedor.</h1>
                    <p><a href="{{ route('web.home') }}" class="text-decoration-none text-white">Home</a> > Seja um
                        revendedor</p>
                </div>

            </div>
        </div>
    </header>

    <section class="policy">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mauto">
                    <h2>Termos de serviços e utilização da seguir play</h2>

                    <p>Caso o usuário não concorde com estes termos, ele não poderá contratar os serviços colocados à disposição pela plataforma de serviços sociais, SEGUIR PLAY. Ao cadastrar-se e concordar com os termos das presentes condições gerais, o usuário declara ter lido integralmente este contrato, tornando certo e perfeito o ato de contratação. A SEGUIR PLAY se mantém no direito de alterar termos e condições deste a qualquer momento. Os clientes que utilizam o site da PAINELSEGUIRPLAY.ONLINE OU SEGUIRPLAY.COM.BR concordam em seguir qualquer alteração ou modificação. Estes termos e condições constituem a documentação legal para garantir que um contrato juridicamente vinculativo esteja em vigor entre, SEGUIR PLAY e você</p>

                    <h3>REGRAS E LIMITAÇÕES</h3>

                    <p>1.1 Se você deseja encomendar nossos bens ou serviços imateriais "Serviços sociais", então você deve seguir as instruções/regras em nosso site para solicitar os serviços.</p>

                    <p>1.2 O administrador tem autoridade para cancelar ou rejeitar qualquer pedido e pagamento que não corresponda à nossa ética.</p>

                    <p>1.3 A conta que irá receber o pedido deverá estar em modo público.</p>

                    <p>1.4 Não deve ocorrer alteração no link ou colocar em privado, caso seja alterado não haverá reposição ou reembolso.</p>

                    <p>1.5 É de sua responsabilidade conferir se o perfil ou a postagem está em modo público antes de fazer o pedido, também certificar-se que o link url está correto. Se um pedido for realizado dessas maneiras ele será considerado concluído, descontado do saldo do cliente e não sendo possível o reembolso.</p>

                    <p>1.6 Se suspendermos sua conta, não será possível criar outra.</p>
                </div>
            </div>
        </div>
    </section>
@endsection
