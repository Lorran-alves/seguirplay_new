@extends('web.templates.master')
@section('title', 'Pedidos')
@section('content')
    <header class="header">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h1>Históricos de pedidos</h1>
                    <p><a href="{{ route('web.home') }}" class="text-decoration-none text-white">Home</a> > Pedidos</p>
                </div>
            </div>
        </div>
    </header>
    <section class="pedidos">
        <div class="container-pedido">
            <div class="caixa-pedido">
                <div class="dentro-caixa">
                    <div class="row-pedidos between-pedidos">
                        <div class="column">
                            <p>Pedido: <span class="texto-roxo">{{ $ultimoPedido->id}}</span></p>
                            <p>Serviço: <span class="texto-roxo texto-pequeno">{{ $ultimoPedido->plan->title}}</span></p>
                            <p>Prazo de entrega: <span class="texto-roxo texto-pequeno">0 A 24 HORAS, EM ÚLTIMO CASO 72 HORAS.</span></p>
                            
                            
                        </div>
                        
                        <div class="info-pedido">
                            <p>Data do pedido: <span class="texto-roxo">{{ date('d/m/Y H:i:s',strtotime($ultimoPedido->created_at)) }}</span></p>
                            <p class="p-link">Link ou @: <span class="texto-roxo">{{ $ultimoPedido->profile }}</span></p>
                            <p>Preço: <span class="texto-roxo" >R$</span> <span class="texto-roxo">{{ $ultimoPedido->convert_price }}</span> </p>
                            <p>Quantidade Comprada: <span class="texto-roxo">{{ $ultimoPedido->quantity }}</span> </p>
                            <p>Quantidade Inicial: <span class="texto-roxo">{{ $retornoApi[$ultimoPedido->id]['inicial'] ?? '0'}}</span> </p>
                            <p>Quantidade final: <span class="texto-roxo">{{ ($retornoApi[$ultimoPedido->id]['inicial'] ?? 0) + $ultimoPedido->quantity}}</span></p>
                            <a href="https://wa.me/5511985868006"><button class="button-contato"><i class="fa-solid fa-phone"></i> Suporte</button></a>
                            <div class="hidden-desktop">
                                <p>Status: <span class="texto-roxo">{{ $retornoApi[$ultimoPedido->id]['status'] ?? 'Pendente'}}</span> </p>
                            </div>
                        </div>
                    </div>
                    @if ($retornoApi[$ultimoPedido->id]['classe'] !=  'status0' && $retornoApi[$ultimoPedido->id]['classe'] !=  'status4')
                        <div  class="barra-progresso {{$retornoApi[$ultimoPedido->id]['classe']}}">
                            <div class="progresso-1"><i class="fa-solid fa-check"></i></div>
                            <div class="progresso-1"><i class="fa-solid fa-check"></i></div>
                            <div class="progresso-1"><i class="fa-solid fa-check"></i></div>
                            <div class="progresso-1"><i class="fa-solid fa-check"></i></div>
                        </div>   
                        <div class="row-pedidos rodape-progresso">
                            <div class="row-pedidos center-pedidos ">
                               <!-- License: CC Attribution. Made by Jordan Hughes: https://www.figma.com/@designer -->
                                <svg width="800px" height="800px" class="icon-pedidos" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4 7.8C4 6.11984 4 5.27976 4.32698 4.63803C4.6146 4.07354 5.07354 3.6146 5.63803 3.32698C6.27976 3 7.11984 3 8.8 3H15.2C16.8802 3 17.7202 3 18.362 3.32698C18.9265 3.6146 19.3854 4.07354 19.673 4.63803C20 5.27976 20 6.11984 20 7.8V21L17.25 19L14.75 21L12 19L9.25 21L6.75 19L4 21V7.8Z" stroke="#ff6e04" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                
                                <div class="texto-rodape hidden-mobile">
                                    <p>Recebemos Seu <br> Pedido</p>
                                </div>
                            </div>
                            <div class="row-pedidos center-pedidos">
                            <svg version="1.0" xmlns="http://www.w3.org/2000/svg"
                             width="800px" height="800px" class="icon-pedidos" viewBox="0 0 512.000000 512.000000"
                             preserveAspectRatio="xMidYMid meet">
                            
                            <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                            fill="#ff6e04" stroke="none">
                            <path d="M715 4873 c-241 -33 -460 -229 -520 -468 -13 -51 -15 -258 -15 -1590
                            0 -1697 -5 -1579 67 -1725 27 -56 57 -95 117 -155 91 -90 168 -134 294 -166
                            72 -18 120 -19 1024 -19 784 0 954 2 982 14 98 41 114 178 29 243 l-36 28
                            -971 5 -971 5 -55 26 c-102 48 -169 137 -190 251 -7 36 -10 556 -8 1529 l3
                            1474 29 62 c33 73 103 144 174 176 45 21 61 22 424 25 l377 3 3 -479 3 -479
                            30 -49 c19 -30 49 -60 79 -79 l49 -30 607 0 607 0 49 30 c30 19 60 49 79 79
                            l30 49 3 479 3 479 377 -3 c363 -3 379 -4 424 -25 71 -32 141 -103 174 -176
                            l29 -62 5 -870 c5 -818 6 -872 23 -897 53 -78 187 -75 237 7 20 32 20 48 20
                            907 0 746 -2 883 -15 933 -53 208 -217 378 -435 452 -52 17 -126 18 -1580 19
                            -839 1 -1538 -1 -1555 -3z m2005 -698 l0 -415 -480 0 -480 0 0 415 0 415 480
                            0 480 0 0 -415z"/>
                            <path d="M4486 2330 c-88 -27 -125 -142 -71 -222 l25 -36 -448 -5 c-385 -3
                            -455 -7 -507 -21 -170 -50 -329 -182 -403 -336 -48 -100 -66 -183 -60 -274 3
                            -56 8 -70 33 -96 53 -55 133 -63 189 -19 36 28 52 64 61 133 14 118 63 205
                            148 261 94 62 123 65 586 65 l414 0 -20 -22 c-32 -36 -43 -63 -43 -110 0 -118
                            130 -181 226 -109 45 33 283 274 308 311 20 30 21 102 2 138 -8 15 -83 95
                            -168 178 -121 120 -161 154 -193 163 -45 12 -40 12 -79 1z"/>
                            <path d="M929 1697 c-90 -60 -88 -181 4 -237 30 -19 53 -20 372 -20 320 0 342
                            1 372 20 85 51 85 189 0 240 -30 19 -52 20 -373 20 -338 0 -341 0 -375 -23z"/>
                            <path d="M4756 1280 c-60 -19 -90 -64 -101 -155 -16 -137 -86 -239 -200 -292
                            l-60 -28 -445 -3 -444 -3 21 23 c32 36 43 63 43 109 0 107 -110 171 -208 120
                            -35 -19 -275 -254 -320 -315 -26 -34 -29 -103 -8 -144 8 -15 86 -97 173 -184
                            130 -129 165 -158 195 -163 48 -9 97 8 133 45 23 24 29 41 33 87 3 50 0 63
                            -23 93 l-26 35 453 5 453 5 80 28 c181 64 308 180 385 350 53 118 67 264 30
                            324 -34 56 -102 82 -164 63z"/>
                            </g>
                            </svg>
                                <div class="texto-rodape hidden-mobile">
                                    <p>Estamos <br> Organizando <br> para entregar</p>
                                </div>
                            </div>
                            <div class="row-pedidos center-pedidos">
                            <!-- License: PD. Made by Ananthanath A X Kalaiism: https://www.figma.com/community/file/1071678557813409125 -->
                            <svg width="800px" height="800px" class="icon-pedidos" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7 20H6C4.89543 20 4 19.1046 4 18V8H20V18C20 19.1046 19.1046 20 18 20H17" stroke="#ff6e04" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M6 4H18L20 8H4L6 4Z" stroke="#ff6e04" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M12 14L12 20M12 20L14.5 17.5M12 20L9.5 17.5" stroke="#ff6e04" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                                <div class="texto-rodape hidden-mobile">
                                    <p>O pedido já está <br> sendo entregue</p>
                                </div>
                            </div>
                            <div class="row-pedidos center-pedidos">
                                
                                <svg fill="#ff6e04" class="icon-pedidos" version="1.1" id="Icons" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
                            	 viewBox="0 0 32 32" xml:space="preserve">
                                <path d="M25,3H11C9.9,3,9,3.9,9,5v10.6c1.2-0.4,2.5-0.6,3.9-0.6H19c1.6,0,3,1.3,3,2.9l0,0.2c0,0.1,0,0.1,0,0.2
                                	c1.3-1.6,3.1-2.7,5-3.1V5C27,3.9,26.1,3,25,3z M23.7,9.8c-0.2,0.2-0.4,0.3-0.7,0.3c-0.3,0-0.5-0.1-0.7-0.3L22,9.5V12
                                	c0,0.6-0.4,1-1,1s-1-0.4-1-1V9.5l-0.3,0.3c-0.4,0.4-1,0.4-1.4,0c-0.4-0.4-0.4-1,0-1.4l2-2.1c0.4-0.4,1.1-0.4,1.5,0l2,2.1
                                	C24.1,8.8,24.1,9.5,23.7,9.8z"/><g>
                                <path d="M29.9,17.5C29.7,17.2,29.4,17,29,17c-2.2,0-4.3,1-5.6,2.8L22.5,21c-1.1,1.3-2.8,2-4.5,2h-3c-0.6,0-1-0.4-1-1s0.4-1,1-1h1.9
                                		c1.6,0,3.1-1.3,3.1-2.9c0,0,0-0.1,0-0.1c0-0.5-0.5-1-1-1l-6.1,0c-3.6,0-6.5,1.6-8.1,4.2l-2.7,4.2c-0.2,0.3-0.2,0.7,0,1l3,5
                                		c0.1,0.2,0.4,0.4,0.6,0.5c0.1,0,0.1,0,0.2,0c0.2,0,0.4-0.1,0.6-0.2c3.8-2.5,8.2-3.8,12.7-3.8c3.3,0,6.3-1.8,7.9-4.7l2.7-4.8
                                		C30,18.2,30,17.8,29.9,17.5z"/></g>
                                </svg>
                                <div class="texto-rodape hidden-mobile">
                                    <p>Finalizamos a entrega<br> do seu pedido</p>
                                </div>
                            </div>
                        </div> 
                    @elseif($retornoApi[$ultimoPedido->id]['classe'] ==  'status4')   
                        <div class="cancelado">
                            <h4>Seu pedido está pendente de pagamento. Por favor, verifique e confirme o pagamento para continuar!</h4>
                        </div>    
                    @else
                        <div class="cancelado">
                            <h4>Ops! Parece que algo deu errado ao enviar seu pedido, entre em contato com o suporte!</h4>
                        </div>   
                    @endif
                        
                </div>
            </div> 
        </div>

        <div class="caixa-pedido-table">
            <table class='table table-striped' id="table1">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Data</th>
                        <th>Categoria</th>
                        <th>Serviço (ID)</th>
                        <th>Quantidade inicial</th>
                        <th>Quantidade final</th>
                        <th>Rede Social</th>
                        <th>Quantidade (Comprada)</th>
                        <th>Status</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($outrosPedidos as $pedido)
                    <tr>
                        <td>{{$pedido->id}}</td>
                        <td>{{ date('d/m/Y H:i:s',strtotime($pedido->created_at)) }}</td>
                        <td>{{ $pedido->plan->category->title }}</td>
                        <td>{{ $pedido->plan->title }} </td>
                        <td>{{ $retornoApi[$pedido->id]['inicial'] ?? '0'}}</td>
                        <td>{{($retornoApi[$pedido->id]['inicial'] ?? '0') + $pedido->quantity}}</td>
                        <td>{{ $pedido->profile }}</td>
                        <td>{{$pedido->quantity }}</td>
                        <td>{{ $retornoApi[$pedido->id]['status'] ?? 'Erro no link' }}</td>
                        <td>R$ {{ $pedido->convert_price }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div id="pagination">
             {{ $outrosPedidos->onEachSide(0)->links() }}
        </div>
    </section>
    
<style>
    #pagination{
        justify-content: center;
        margin-bottom: 100px;
        justify-content: center;
        display: flex;
    }
    #pagination a{
        color: black !important;
    }
    .page-item.active .page-link {
        background: #7C205D;
        color: white;
        border-color: #7C205D;
        font-family:'Poppins' !important;
    }
    .page-item{
        font-family:'Poppins' !important;
    }
    .pagination {
        flex-wrap: wrap;
    }
</style>
@endsection
