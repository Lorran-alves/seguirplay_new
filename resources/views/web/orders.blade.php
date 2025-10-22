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
        <div class="orders-focus-panel">

            <div class="section-header">
                <h2>Seu pedido mais recente</h2>
            </div>

            <div class="latest-order-card">
                <div class="latest-order-info">
                    <p class="service-title">{{ $ultimoPedido->plan->title}}</p>
                    <p class="order-meta">
                        <span>#{{ $ultimoPedido->id}}</span>
                        <span>{{ date('d/m/Y',strtotime($ultimoPedido->created_at)) }}</span>
                    </p>
                </div>
                <div class="latest-order-actions">
                    <button class="btn-theme btn-secondary-theme" data-bs-toggle="modal" data-bs-target="#orderModal-{{$ultimoPedido->id}}">
                        Ver Todos os Detalhes
                    </button>
                </div>
            </div>

            <div class="section-header" style="margin-top: 40px;">
                <h2>Histórico completo</h2>
            </div>
            
            <div class="history-list">
                @foreach($outrosPedidos as $pedido)
                <div class="list-item">
                    <div class="order-id">#{{$pedido->id}}</div>
                    <div class="order-service">{{ Str::limit($pedido->plan->title, 40) }}</div>
                    <div class="order-status">
                         @php
                            $statusText = $retornoApi[$pedido->id]['status'] ?? 'Erro no link';
                            $statusTextLower = strtolower($statusText);
                            $statusClass = 'default';

                            if (str_contains($statusTextLower, 'concluido a entregar')) {
                                $statusClass = 'in-delivery';
                            } elseif (str_contains($statusTextLower, 'concluído') || str_contains($statusTextLower, 'concluido')) {
                                $statusClass = 'completed';
                            } elseif (str_contains($statusTextLower, 'andamento')) {
                                $statusClass = 'in-progress';
                            } elseif (str_contains($statusTextLower, 'pendente')) {
                                $statusClass = 'pending';
                            } elseif (str_contains($statusTextLower, 'cancelado')) {
                                $statusClass = 'cancelled';
                            }
                         @endphp
                        <span class="status-badge {{ $statusClass }}">{{ $statusText }}</span>
                    </div>
                    <button class="btn-theme btn-secondary-theme" data-bs-toggle="modal" data-bs-target="#orderModal-{{$pedido->id}}">
                        Detalhes
                    </button>
                </div>
                @endforeach
            </div>

            <div id="pagination">
                {{ $outrosPedidos->onEachSide(0)->links() }}
            </div>
        </div>
    </section>

    <!-- Modal para Último Pedido -->
    <div class="modal fade" id="orderModal-{{$ultimoPedido->id}}" tabindex="-1" aria-labelledby="orderModalLabel-{{$ultimoPedido->id}}" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderModalLabel-{{$ultimoPedido->id}}">Detalhes do Pedido #{{$ultimoPedido->id}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="details-grid">
                        <div class="detail-item"><p>Serviço:</p> <span>{{ $ultimoPedido->plan->title}}</span></div>
                        <div class="detail-item"><p>Data:</p> <span>{{ date('d/m/Y H:i:s',strtotime($ultimoPedido->created_at)) }}</span></div>
                        <div class="detail-item"><p>Preço:</p> <span>R$ {{ $ultimoPedido->convert_price }}</span></div>
                        <div class="detail-item"><p>Link ou @:</p> <span>{{ $ultimoPedido->profile }}</span></div>
                        <div class="detail-item"><p>Quantidade Comprada:</p> <span>{{ $ultimoPedido->quantity }}</span></div>
                        <div class="detail-item"><p>Quantidade Inicial:</p> <span>{{ $retornoApi[$ultimoPedido->id]['inicial'] ?? '0'}}</span></div>
                        <div class="detail-item"><p>Quantidade Final:</p> <span>{{ (int)($retornoApi[$ultimoPedido->id]['inicial'] ?? 0) + (int)$ultimoPedido->quantity }}</span></div>
                    </div>

                    <div class="lembretes-info-box">
                        <h5>Prazos de Referência</h5>
                        <div class="lembrete-item">
                            <i class="fas fa-rocket"></i>
                            <div class="lembrete-item-text">
                                <strong>Serviços Gerais</strong>
                                <p>Até 24h (podendo estender-se a 72h).</p>
                            </div>
                        </div>
                        <div class="lembrete-item">
                            <i class="fas fa-broadcast-tower"></i>
                            <div class="lembrete-item-text">
                                <strong>LIVES</strong>
                                <p>Entre 10 a 20 minutos.</p>
                            </div>
                        </div>
                        <div class="lembrete-item">
                            <i class="fas fa-calendar-alt"></i>
                            <div class="lembrete-item-text">
                                <strong>Horas de Exibição</strong>
                                <p>De 7 a 30 dias (não acelerável).</p>
                            </div>
                        </div>
                    </div>

                     @if (isset($retornoApi[$ultimoPedido->id]) && $retornoApi[$ultimoPedido->id]['classe'] != 'status0' && $retornoApi[$ultimoPedido->id]['classe'] != 'status4')
                        <div class="progress-wrapper">
                            @php
                                $class = $retornoApi[$ultimoPedido->id]['classe'];
                                $statusText = strtolower($retornoApi[$ultimoPedido->id]['status'] ?? '');
                                if (str_contains($statusText, 'concluído') || str_contains($statusText, 'concluido a entregar')) {
                                    $class = 'status5';
                                }
                            @endphp
                            <div class="progress-steps-container">
                                <div class="progress-line {{$class}}"></div>
                                <ul class="progress-steps-list">
                                    <li class="step-item @if(in_array($class, ['status1', 'status2', 'status3', 'status5'])) completed @endif"> <div class="step-icon"><i class="fas fa-receipt"></i></div> <p class="step-label">Pedido Recebido</p> </li>
                                    <li class="step-item @if(in_array($class, ['status2', 'status3', 'status5'])) completed @endif"> <div class="step-icon"><i class="fas fa-hourglass-start"></i></div> <p class="step-label">Em Organização</p> </li>
                                    <li class="step-item @if(in_array($class, ['status3', 'status5'])) completed @endif"> <div class="step-icon"><i class="fas fa-sync-alt fa-spin"></i></div> <p class="step-label">Serviço em Execução</p> </li>
                                    <li class="step-item @if(in_array($class, ['status5'])) completed @endif"> <div class="step-icon"><i class="fas fa-check-circle"></i></div> <p class="step-label">Finalizado</p> </li>
                                </ul>
                            </div>
                        </div>
                    @elseif(isset($retornoApi[$ultimoPedido->id]) && $retornoApi[$ultimoPedido->id]['classe'] == 'status4')
                        <div class="alert alert-warning">Seu pedido está pendente de pagamento.</div>
                    @else
                        <div class="alert alert-danger">Ops! Algo deu errado, entre em contato com o suporte!</div>
                    @endif
                    <a href="https://wa.me/5511985868006?text=Ol%C3%A1%2C%20preciso%20de%20ajuda%20com%20o%20pedido%20n%C3%BAmero%3A%20{{$ultimoPedido->id}}" target="_blank" class="btn-theme btn-primary-theme"><i class="fab fa-whatsapp"></i> Suporte</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals para Histórico de Pedidos -->
     @foreach($outrosPedidos as $pedido)
        <div class="modal fade" id="orderModal-{{$pedido->id}}" tabindex="-1" aria-labelledby="orderModalLabel-{{$pedido->id}}" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="orderModalLabel-{{$pedido->id}}">Detalhes do Pedido #{{$pedido->id}}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                         <div class="details-grid">
                             <div class="detail-item"><p>Serviço:</p> <span>{{ $pedido->plan->title }}</span></div>
                             <div class="detail-item"><p>Data:</p> <span>{{ date('d/m/Y H:i:s',strtotime($pedido->created_at)) }}</span></div>
                             <div class="detail-item"><p>Preço:</p> <span>R$ {{ $pedido->convert_price }}</span></div>
                             <div class="detail-item"><p>Link ou @:</p> <span>{{ $pedido->profile }}</span></div>
                             <div class="detail-item"><p>Quantidade Comprada:</p> <span>{{ $pedido->quantity }}</span></div>
                             <div class="detail-item"><p>Quantidade Inicial:</p> <span>{{ $retornoApi[$pedido->id]['inicial'] ?? '0'}}</span></div>
                             <div class="detail-item"><p>Quantidade Final:</p> <span>{{ (int)($retornoApi[$pedido->id]['inicial'] ?? 0) + (int)$pedido->quantity }}</span></div>
                        </div>
                        
                        <div class="lembretes-info-box">
                            <h5>Prazos de Referência</h5>
                            <div class="lembrete-item">
                                <i class="fas fa-rocket"></i>
                                <div class="lembrete-item-text">
                                    <strong>Serviços Gerais</strong>
                                    <p>Até 24h (podendo estender-se a 72h).</p>
                                </div>
                            </div>
                            <div class="lembrete-item">
                                <i class="fas fa-broadcast-tower"></i>
                                <div class="lembrete-item-text">
                                    <strong>LIVES</strong>
                                    <p>Entre 10 a 20 minutos.</p>
                                </div>
                            </div>
                            <div class="lembrete-item">
                                <i class="fas fa-calendar-alt"></i>
                                <div class="lembrete-item-text">
                                    <strong>Horas de Exibição</strong>
                                    <p>De 7 a 30 dias (não acelerável).</p>
                                </div>
                            </div>
                        </div>

                         @if (isset($retornoApi[$pedido->id]) && $retornoApi[$pedido->id]['classe'] != 'status0' && $retornoApi[$pedido->id]['classe'] != 'status4')
                            <div class="progress-wrapper">
                                @php
                                    $class = $retornoApi[$pedido->id]['classe'];
                                    $statusText = strtolower($retornoApi[$pedido->id]['status'] ?? '');
                                    if (str_contains($statusText, 'concluído') || str_contains($statusText, 'concluido a entregar')) {
                                        $class = 'status5';
                                    }
                                @endphp
                                <div class="progress-steps-container">
                                    <div class="progress-line {{$class}}"></div>
                                    <ul class="progress-steps-list">
                                        <li class="step-item @if(in_array($class, ['status1', 'status2', 'status3', 'status5'])) completed @endif"> <div class="step-icon"><i class="fas fa-receipt"></i></div> <p class="step-label">Pedido Recebido</p> </li>
                                        <li class="step-item @if(in_array($class, ['status2', 'status3', 'status5'])) completed @endif"> <div class="step-icon"><i class="fas fa-hourglass-start"></i></div> <p class="step-label">Em Organização</p> </li>
                                        <li class="step-item @if(in_array($class, ['status3', 'status5'])) completed @endif"> <div class="step-icon"><i class="fas fa-sync-alt fa-spin"></i></div> <p class="step-label">Serviço em Execução</p> </li>
                                        <li class="step-item @if(in_array($class, ['status5'])) completed @endif"> <div class="step-icon"><i class="fas fa-check-circle"></i></div> <p class="step-label">Finalizado</p> </li>
                                    </ul>
                                </div>
                            </div>
                        @elseif(isset($retornoApi[$pedido->id]) && $retornoApi[$pedido->id]['classe'] == 'status4')
                            <div class="alert alert-warning">Seu pedido está pendente de pagamento.</div>
                        @else
                            <div class="alert alert-danger">Ops! Algo deu errado, entre em contato com o suporte!</div>
                        @endif
                         <a href="https://wa.me/5511985868006?text=Ol%C3%A1%2C%20preciso%20de%20ajuda%20com%20o%20pedido%20n%C3%BAmero%3A%20{{$pedido->id}}" target="_blank" class="btn-theme btn-primary-theme"><i class="fab fa-whatsapp"></i> Suporte</a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    
@endsection

