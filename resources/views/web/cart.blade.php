<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div style="overflow: auto;" id="cartItems">
                @php $total = 0; @endphp
                @foreach($cart as $index => $item)
                @php $total += $item['price']; @endphp
                    <div class="cart-item mb-3" id="item{{ $item['id'] }}">
                        <!-- Título do item e botão de expandir/remover -->
                        <div class="d-flex justify-content-between align-items-center" style="background-color: #f1eeee; padding: 10px; border-radius:5px;">
                            <div>
                                <strong>{{ Str::limit($item['plan'], 30, '...') }}</strong>
                            </div>
                            <div>
                                <!-- Botão de expandir -->
                                <button class="button-carrinho-customizado" type="button" data-bs-toggle="collapse" data-bs-target="#itemDetails{{ $index }}" aria-expanded="false" aria-controls="itemDetails{{ $index }}">
                                    <i class="fas fa-eye"></i>
                                </button>

                                <!-- Formulário de remoção -->
                                <form action="{{ route('cartRemove', ':id') }}" method="POST" class="d-inline" id="formRemove{{ $item['id'] }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="button-carrinho-customizado" id="removeButton{{ $item['id'] }}" data-id="{{ $item['id'] }}">X</button>
                                </form>                                                         
                            </div>
                        </div>

                        <!-- Detalhes do item que será expandido -->
                        <div class="collapse" id="itemDetails{{ $index }}">
                            <div class="card card-body mt-2 paragrafos-customizado">
                                <p><strong>Serviço:</strong> {{ $item['plan'] }}</p>
                                <p><strong>Rede Social:</strong> {{ $item['category'] }}</p>
                                <p><strong>Link:</strong> <a href="{{ $item['profile'] }}" target="_blank">{{ $item['profile'] }}</a></p>
                                <p><strong>Quantidade:</strong> {{ $item['quantity'] }}</p>
                                <p><strong>Preço:</strong> R$ {{ number_format($item['price'], 2, ',', '.') }}</p>

                                {{-- se for comentário colocar aqui em tabela os comentario --}}
                                @if (isset($item['comments']))
                                
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Comentários</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($item['comments'] as $comment)
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
            </div>

            <div class="text-right mt-4">
                <h4 id="totalCarrinho">Total: R$ <span id="totalCarrinhoSpan"> {{ number_format($total, 2, ',', '.') }}</span></h4>
            </div>
        </div>
    </div>
</div>



<style>
    /* Adiciona a limitação de altura e a rolagem para os parágrafos */
    .paragrafos-customizado p {
        white-space: nowrap; /* Impede a quebra de linha */
        text-overflow: ellipsis; /* Adiciona "..." quando o texto for cortado */
        max-width: 100%; /* Garantir que o conteúdo não ultrapasse o limite */
    }

    .paragrafos-customizado {
        max-height: 250px; /* Define uma altura máxima para a área dos detalhes */
        overflow-y: auto; /* Permite rolar para baixo caso o conteúdo ultrapasse a altura */
    }

    /* Para navegadores baseados em WebKit (Chrome, Safari, Edge) */
    .paragrafos-customizado::-webkit-scrollbar {
        width: 3px; /* Largura da barra de rolagem vertical */
        height: 3px; /* Altura da barra de rolagem horizontal */
    }

    .paragrafos-customizado::-webkit-scrollbar-thumb {
        background-color: #888; /* Cor do "botão" da barra de rolagem */
        border-radius: 3px; /* Bordas arredondadas */
    }

    .paragrafos-customizado::-webkit-scrollbar-thumb:hover {
        background-color: #555; /* Cor ao passar o mouse */
    }

    /* Para Firefox */
    .paragrafos-customizado {
        scrollbar-width: thin; /* Define uma barra de rolagem fina */
        scrollbar-color: #888 transparent; /* Cor do thumb e do track */
    }

    .button-carrinho-customizado {
            width: 35px;
            height: 35px;
            border: none;
            border-radius: 0;
            color: black;
            background: transparent !important;
            margin-top: 0 !important;
        }

    .button-carrinho-customizado i{
        color: black;
    }

    .button-carrinho-customizado:hover{
        background-color: #f8f9fa !important;
    }

    #totalCarrinhoSpan{
        font-weight: bold !important;
        color: black !important;
        font-size: 20px !important;
    }
    div:where(.swal2-icon).swal2-success [class^=swal2-success-line] {
        /* background-color: orange; */
    }


</style>

<script>
    $(document).ready(function() {
        $("button[id^='removeButton']").click(function() {
            let itemId = $(this).data('id'); // Obtém o ID do item
            let form = $('#formRemove' + itemId);

            Swal.fire({
                title: 'Tem certeza que deseja remover este item?',
                text: "Esta ação não poderá ser desfeita!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, remover!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: form.attr('action').replace(':id', itemId), 
                        method: form.attr('method'),
                        data: form.serialize(),
                        success: function(response) {
                            $('#item' + itemId).remove();
                            $("#totalCarrinhoSpan").text(response.total);

                            if(response.total == 0){
                                $("#continuarCompraCarrinhoButton").hide();
                            }

                            Swal.fire(
                                'Removido!',
                                'O item foi removido do carrinho.',
                                'success'
                            );
                        },
                        error: function() {
                            Swal.fire(
                                'Erro!',
                                'Ocorreu um erro ao remover o item.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    });

</script>