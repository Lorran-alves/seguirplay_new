@extends('dashboard.templates.master')
@section('title', 'Pedido Manual')
@section('content')
<div class="main-content container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>@yield('title')</h3>
                <p class="text-subtitle text-muted">Uma area de @yield('title')</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class='breadcrumb-header'>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@yield('title')</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<section class="section">
    <div class="card">
        <div class="card-body">
            <div class="col-12">
                <div class="form-group">
                    <label for="category">Categoria</label>
                    <select name="category" id="category" class="select-customizado" onchange="getServices(this)">
                        <option value="0">Selecione uma categoria</option>
                        @foreach($categories as $categoria)
                            <option value="{{ $categoria->id }}">
                                {{ $categoria->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-12" style="display: none" id="services">
                <div class="form-group">
                    <label for="plan_id">Escolha o serviço</label>
                    <select name="plan_id[]" id="plan_id" class="select-customizado" onchange="getDetalhePano()"></select>
                </div>
            </div>

            <div class="col-12">
                <div class="form-group">
                    <label for="quantity">Quantidade</label>
                    <input 
                    type="number" 
                    name="quantity" 
                    placeholder="Quantidade" 
                    class="form-control"
                    min="50"
                    id="quantity"
                    >
                </div>
            </div>

            <div class="col-12">
                <div class="form-group">
                    <label for="profile">Digite o link</label>
                    <input type="text" id="profile" placeholder="Link" class="form-control">
                </div>
            </div>

            <div class="col-12" style="display: none" id="divPaiComments">
                <div class="form-group">
                    <label for="comments">Digite os comentários</label>
                    <div id="commentsContainer">

                    </div>
                </div>
            </div>
            <br>
            <div class="col-12">
                <div class="form-group">
                    <label for="valor_total">Valor total </label>
                    <span id="valor_total">0,00</span>
                    <input type="hidden" id="preco_unitario">
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <button class="button" onclick="mostrarCarrinho()" id="buttonVerCarrinho">Ver Carrinho</button>
                    <button class="button" onclick="adicionarCarrinho()">Adicionar ao Carrinho</button>
                    <button class="button" onclick="finalizarCompra()" id="buttonFinalizarCompra">Finalizar Compra</button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="modalFinalizaCompra" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
     aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="btn-header" onclick="voltarAoModal('#modalFinalizaCompra', '#passoCupom')">
                   <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#7f7f7f" d="M257.5 445.1l-22.2 22.2c-9.4 9.4-24.6 9.4-33.9 0L7 273c-9.4-9.4-9.4-24.6 0-33.9L201.4 44.7c9.4-9.4 24.6-9.4 33.9 0l22.2 22.2c9.5 9.5 9.3 25-.4 34.3L136.6 216H424c13.3 0 24 10.7 24 24v32c0 13.3-10.7 24-24 24H136.6l120.5 114.8c9.8 9.3 10 24.8 .4 34.3z"/></svg>
                </button>
                <button type="button" class="btn-header" data-bs-dismiss="modal" aria-label="Close" onclick="closeModal('#modalFinalizaCompra')">X</button>
            </div>
            <div class="modal-body text-center">
                <form method="post" id="formPurchase" action="{{ route('dashboard.gestaoPedidoManual.gerarPix') }}">
                    @csrf
                    <input type="email" placeholder="E-mail" name="email" required id="inputEmail">
                    <input type="tel" name="telefone" id="phone" placeholder="Número de telefone" required>
                    <input type="hidden" name="profile">
                    <input type="hidden" name="cupom" value="" id='cupomForm'>
                    <input type="hidden" name="quantity" cmnt="q">
                    <input type="hidden" name="plano_id" value="">
                    <input type="hidden" name="categoria_id" value="">
                    <input type="hidden" name="cmnt_q" id="cmnt_q" value="">
                    
                    <button class="button">Continuar <i class="fas fa-arrow-right"></i></button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalDadosCarrinho" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
     aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="btn-header" onclick="voltarAoModal('#modalDadosCarrinho', '#passoCupom')">
                   <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#7f7f7f" d="M257.5 445.1l-22.2 22.2c-9.4 9.4-24.6 9.4-33.9 0L7 273c-9.4-9.4-9.4-24.6 0-33.9L201.4 44.7c9.4-9.4 24.6-9.4 33.9 0l22.2 22.2c9.5 9.5 9.3 25-.4 34.3L136.6 216H424c13.3 0 24 10.7 24 24v32c0 13.3-10.7 24-24 24H136.6l120.5 114.8c9.8 9.3 10 24.8 .4 34.3z"/></svg>
                </button>
                <button type="button" class="btn-header" data-bs-dismiss="modal" aria-label="Close" onclick="closeModal('#modalDadosCarrinho')">X</button>
            </div>
            <div class="modal-body text-center">
                <input type="email" placeholder="E-mail" name="email" required id="inputEmailCarrinho">
                <input type="tel" name="telefone" id="phoneCarrinho" placeholder="Número de telefone" required>
                <button class="button" onclick="salvarCarrinho()">Adicionar Carrinho <i class="fas fa-arrow-right"></i></button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="passoCupom" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
     aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="btn-header" onclick="voltarAoModal('#passoCupom', '#modalFinalizaCompra')">
                   <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#7f7f7f" d="M257.5 445.1l-22.2 22.2c-9.4 9.4-24.6 9.4-33.9 0L7 273c-9.4-9.4-9.4-24.6 0-33.9L201.4 44.7c9.4-9.4 24.6-9.4 33.9 0l22.2 22.2c9.5 9.5 9.3 25-.4 34.3L136.6 216H424c13.3 0 24 10.7 24 24v32c0 13.3-10.7 24-24 24H136.6l120.5 114.8c9.8 9.3 10 24.8 .4 34.3z"/></svg>
                </button>
                <button type="button" class="btn-header" data-bs-dismiss="modal" aria-label="Close" onclick="closeModal('#passoCupom')">X</button>
            </div>
            <div class="modal-body text-center">
                
                <div class="div-buttom">
                    <input type="text" id="cupomInputEntrada" placeholder="Digite o cupom (opcional)"  style="text-transform: uppercase;">
                </div>
                <p id="feedbackCupom" style="color:red;"></p>
                <h2 id="totalDesconto" style="margin-bottom: 0"></h2>
                <h2 id="totalPrice" style="margin-bottom: 0"></h2>
                <button class="button" onclick="gerarPix(this)">
                    Continuar
                    <i class="fas fa-arrow-right"></i>
                </button>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalCart" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
     aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-header" onclick="closeModal('#modalCart')">X</button>
               
            </div>
            <div class="modal-body text-center">
                <h2>Serviços adicionados</h2>
                <div id="corpo_carrinho">

                </div>
               <button class="button" data-bs-toggle="modal" onclick="abrirModalCupomCart()" id="continuarCompraCarrinhoButton">
                    Continuar
                    <i class="fas fa-arrow-right"></i>
                </button>
                <button class="button" onclick="limparCarrinho()" id="limparCarrinho">Limpar Cookies</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="pix" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
     aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-header"  onclick="closeModal('#pix')"></button>
            </div>
            <div class="modal-body text-center">
                <img class="icons img-category" src="{{ asset('web_assets/img/value-icon01.png') }}">
                <h2> Realize seu pagamento via PIX</h2>
                <img id="load" src="https://upload.wikimedia.org/wikipedia/commons/b/b1/Loading_icon.gif?20151024034921" alt="">

                <div class="row" id="dix-pix" style="display:none;" >
                    <div class="col-md-12">
                        <img src="" id="img-pix" width="100%" alt="">
                    </div>
                    <div class="col-md-12">
                    <input type="text" id="code-pix" name="code-pix" class="form-control mt-3 m-auto" readonly value="testeValorPix">
                    <button class="btn btn-secondary mt-3" onclick="copyPixCode()">Copiar o QR PIX</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    

@endsection

<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://kit.fontawesome.com/0b08c8a640.js" crossorigin="anonymous"></script>

{{-- CSS CUSTOMIZADO --}}
<link rel="stylesheet" href="{{ asset('dashboard_assets/css/pedido_manual.css') }}">

<script>

    let existeCarrinho = false;
    let comentario = false;
    
    // Função para pegar um cookie pelo nome
    function getCookie(name) {
        let cookies = document.cookie.split('; ');
        for (let i = 0; i < cookies.length; i++) {
            let cookie = cookies[i].split('=');
            if (cookie[0] === name) {
                return decodeURIComponent(cookie[1]);
            }
        }
        return null;
    }

    function adicionarCarrinho()
    {
        //verificar se os dados estão preenchidos
        let resultado = verificaDadosPreenchidos();

        if(resultado){
            alert('Por favor, preencha todos os campos obrigatórios.');
            return;
        }

        if(existeCarrinho){
            salvarCarrinho();
            return;
        }

        $('#modalDadosCarrinho').modal('show');
    }

    function salvarCarrinho()
    {
        existeCarrinho = true;

        let telefone = $('#phoneCarrinho').val();
        let email = $('#inputEmailCarrinho').val()
        let profile = $('#profile').val();
        let quantity = $('#quantity').val();
        let plan_id = $('#plan_id').val(); 

        let cmnt_q = $('#cmnt_q').val();
        
        let comments = [];
        for (let i = 1; i <= cmnt_q; i++) {
            comments.push($('#cmnt_' + i).val());
        }

        $.ajax({
            url: "{{ route('dashboard.gestaoPedidoManual.addToCart') }}",
            type: 'POST',
            data: {
                telefone: telefone,
                email: email,
                plan_id: plan_id,
                profile: profile,
                quantity: quantity,
                cmnt_q: cmnt_q,
                comments: comments,
                _token: $('meta[name="csrf-token"]').attr('content') // Token CSRF para Laravel
            },
            success: function(response) {
                Swal.fire(
                    'Sucesso!',
                    'Produto adicionado com sucesso.',
                    'success'
                );
                $('#modalDadosCarrinho').modal('hide');
                $('#buttonVerCarrinho').show();
                $('#buttonFinalizarCompra').hide();
               
                mostrarCarrinho();
            },
            error: function(xhr) {
                console.log(xhr.responseText);
                alert('Erro ao adicionar ao carrinho.');
            }
        });
    }

    function mostrarCarrinho()
    {
        $.get("{{ route('dashboard.gestaoPedidoManual.getCart') }}", function(response){
            $('#corpo_carrinho').html(response);
            $('#modalCart').modal('show');
        });
    }

    function limparCarrinho(){
        Swal.fire({
            title: 'Tem certeza que deseja limpar os Cookies?',
            text: "Esta ação não poderá ser desfeita!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, limpar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ route('dashboard.gestaoPedidoManual.cartClear') }}";
            }
        });
    }

    function abrirModalCupomCart() {
        
        total = $("#totalCarrinhoSpan").text();
        $("#totalDesconto").text("Total: R$ " + total);
        $('#passoCupom').modal('show');
        $("#modalCart").modal('hide');
        
        $("#totalPrice").addClass('none');
        $("#totalDesconto").addClass('block');
        $("#totalDesconto").removeClass('none');

        $('#contentCupomCart').show();
    }

    // //Logica do cupom
    function aplicarDesconto() {
        let cupomInputEntrada = $('#cupomInputEntrada');
        let campoPrecoOld = $("#totalDesconto");
        let campoPreco = $("#totalPrice");
        let feedbackCupom = $("#feedbackCupom");

        campoPrecoOld.removeClass();
        campoPreco.removeClass();

        var cupomDigitado = cupomInputEntrada.val().toUpperCase();
        var categoria = $('input[name="categoria_id"]').val();
        var plano = $('input[name="plano_id"]').val();
        var email = $('input[name="email"]').val();

        //atualiza o nome do cupom que o usuario digitou
        $("#cupomForm").val(cupomDigitado);

        if (cupomInputEntrada.val() == '') {
            feedbackCupom.html("");
            return;
        }

        let url = "{{ route('web.verificarCupom') }}";

        $.post(url,{ 
            _token: "{{ csrf_token() }}",
            cupom: cupomDigitado,
            categoria:categoria,
            plano: plano,
            email: email,
        }, function(response) {
            
            if (response.status === "success") {
                var preco = parseFloat(campoPrecoOld.text().includes(',')
                    ? campoPrecoOld.text().split('R$')[1].replace(',', '.')
                    : campoPrecoOld.text().split(':')[1]
                );
                console.log(preco);
                
                var descontoDecimal = 1 - (response.desconto / 100);
                var totalComDesconto = arredondarParaDuasCasasDecimais(preco * descontoDecimal);

                campoPrecoOld.addClass('none');
                campoPreco.addClass('block');

                campoPreco.text('Total com desconto: R$' + totalComDesconto.toFixed(2));
                feedbackCupom.text("");

            } else {
                campoPreco.addClass('none');
                campoPrecoOld.addClass('block');

                feedbackCupom.html(response.message);
            }
        }, "json")
        .fail(function() {
            feedbackCupom.html("Erro ao validar o cupom, tente novamente.");
        }); 
    }

    function arredondarParaDuasCasasDecimais(numero) {
        var multiplicador = 100; // 10 elevado à potência do número de casas decimais desejado
        return Math.ceil(numero * multiplicador) / multiplicador;
    }

    function getServices(element)
    {
        var categories = $('#category').val(); 

        let category = Array.isArray(categories) ? categories : (categories ? [categories] : []);
        if(category == 0){
            $("#services").hide();
            return;
        }

        $.ajax({
            url: "{{ route('dashboard.categories.getServicesMultiple') }}",
            type: 'POST',
            data: {
                categorias_id: category,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                response = JSON.parse(response);
                $("#services").show();
                $('#plan_id').empty();
                $('#plan_id').append('<option value="0" selected>Escolha o serviço</option>');
                response.plans.forEach(function(service) {
                    $('#plan_id').append('<option value="' + service.id + '">' + service.title + '</option>');
                });

                // Reativar Select2
                $('#plan_id').select2({
                    placeholder: "Selecione um serviço",
                    allowClear: true
                });
            }
        })
    }

    function getDetalhePano()
    {
        
        plan_id = $("#plan_id").val();
        if(plan_id == 0){
            return;
        }
        $.ajax({
            url: "{{ route('dashboard.services.getDetalhePano') }}",
            type: 'POST',
            data: {
                plan_id: plan_id,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                response = JSON.parse(response);
                let plan = response.plan;

                let preco = atualizaPrecoServico(plan);
                atualizarCampoPreco(preco);

                // type = 4 é comentário
                if(plan.type == 4){
                    comentario = true;
                   
                    $("#divPaiComments").show();
                    $("#cmnt_q").val(plan.quantity_min);
                   
                    let html = '';
                    for (let i = 1; i <= plan.quantity_min; i++) {
                        html += '<input type="text" name="cmnt_' + i + '" id="cmnt_' + i + '" placeholder="Digite o comentário ' + i + '" class="form-control">';
                    }
                    
                    $('#commentsContainer').html(html);
                }
            }
        })
    }

    function atualizarCampoPreco(preco){
        let totalConvert = preco.toLocaleString('pt-br', {style: 'currency', currency: 'BRL'});
        $('#valor_total').text(totalConvert);
    }

    function atualizaPrecoServico(plan){

        let input = $("#quantity");
        $("#preco_unitario").val(plan.price);
        if (plan.quantity === null) {
            input.val(plan.quantity_min);
            input.attr('min', plan.quantity_min);
            
        } else {
            input.val(plan.quantity);
            input.prop('disabled', true); 
        }

        let preco =  input.val() * plan.price;
       
        return preco;
    }

    $(document).ready(function() {
        $('#buttonVerCarrinho').hide();
        let userCookie = getCookie('userCartDashboard');
        
        if (userCookie) {
            $('#buttonFinalizarCompra').hide();
            $('#buttonVerCarrinho').show();
            existeCarrinho = true;
            try {
                let user = JSON.parse(userCookie); // Converte JSON para objeto
                // Atualiza os campos do formulário
                $('input[name="email"]').val(user.email);
                $('input[name="phone"]').val(user.telefone);

            } catch (e) {
                console.error("Erro ao processar o cookie 'user':", e);
            }
        }

        $("#cupomInputEntrada").blur(function() {
            aplicarDesconto();
        });
        
        $('#category').select2({
            placeholder: "Selecione uma categoria",
            allowClear: true
        });

        // Inicializa Select2 no campo de serviço
        $('#plan_id').select2({
            placeholder: "Selecione o serviço",
            allowClear: true
        });

        $(document).on('blur', '#quantity', function() {
            
            let min = parseInt($(this).attr('min'));
            let value = parseInt($(this).val());

            // Se o valor for menor que o mínimo, define o mínimo
            if (value < min) {
                $(this).val(min);
            }

            let preco = $(this).val() * $("#preco_unitario").val();

            if(comentario){
                $("#cmnt_q").val($(this).val());
                let html = '';
                for (let i = 1; i <= $(this).val(); i++) {
                    html += '<input type="text" id="cmnt_' + i + '" placeholder="Digite o comentário ' + i + '" class="form-control">';
                }
                
                $('#commentsContainer').html(html);
            }
            
            atualizarCampoPreco(preco);
            
        });

        $("#formPurchase").submit(function(e){
        
            e.preventDefault()
            $('#modalFinalizaCompra').modal('hide');
            $('#passoCupom').modal('show');

            total = $("#valor_total").text();
            $("#totalDesconto").text("Total:" + total);
            
            $("#totalPrice").addClass('none');
            $("#totalDesconto").addClass('block');
            $("#totalDesconto").removeClass('none');
        })

        

    });

    function gerarPix(e){
        
        //unifica o input de telefone

        $('#passoCupom').modal('hide')
        $('#pix').modal('show')
        
        let url = $('#formPurchase').attr('action');

        if(existeCarrinho){
            url = "{{ route('dashboard.gestaoPedidoManual.gerarPixCart') }}";
        }
    
        $.post(url, $('#formPurchase').serializeArray() , function(response){
        
            var obj = JSON.parse(response);
    
    
            var base64 = obj.transaction_data.qr_code_base64;
            var codePix = obj.transaction_data.qr_code;
    
            $("#load").hide();
    
            $("#img-pix").attr('src', 'data:image/jpeg;base64,'+base64);
            $("#code-pix").val(codePix);
    
            $("#dix-pix").show();
            limparCampos();

        });
    }

    function finalizarCompra(){
        

        //verificar se os dados estão preenchidos
        let resultado = verificaDadosPreenchidos();

        if(resultado){
            alert('Por favor, preencha todos os campos obrigatórios.');
            return; 
        }

        $('#modalFinalizaCompra').modal('show');

    }


    function verificaDadosPreenchidos()
    {
        let categoria_id = $("#category").val();
        let plan_id = $("#plan_id").val();
        let quantity = $("#quantity").val();
        let profile = $("#profile").val();
        let cmnt_q = $("#cmnt_q").val();

        $('input[name="profile"]').val(profile);
        $('input[name="categoria_id"]').val(categoria_id);
        $('input[name="quantity"]').val(quantity);
        $('input[name="plano_id"]').val(plan_id);

        if (!categoria_id || !plan_id || !quantity || !profile || plan_id == 0) {
            return true;
        }

        for (let i = 1; i <= cmnt_q; i++) {
            let comentario = $('#cmnt_' + i).val();
            if (!comentario) {
                return true;  // Se algum campo de comentário estiver vazio, retorna true
            }
        }

    }

    function voltarAoModal(ocutar, mostrar) {

        $(mostrar).modal('show');
        $(ocutar).modal('hide');

    }

    function closeModal(modalId){
        $(modalId).modal('hide');
    }

    function copyPixCode() {

        var copyText = document.getElementById("code-pix");
        copyText.select();
        copyText.setSelectionRange(0, 99999); /* For mobile devices */
        document.execCommand("copy");
        alert("Chave PIX copiado: " + copyText.value);
    }
    
    function limparCampos() {
        // Limpa os campos de texto
        $('#profile').val('');
        $('#quantity').val('');
        $('#cmnt_q').val('');
        $('#commentsContainer').html('');
        $('#category').val(null).trigger('change'); // Reseta o select2
        $('#plan_id').val(null).trigger('change'); // Reseta o select2

        // Limpa os campos ocultos
        $('input[name="profile"]').val('');
        $('input[name="categoria_id"]').val('');
        $('input[name="quantity"]').val('');
        $('input[name="plano_id"]').val('');

        // Reseta o valor total
        
        $('#preco_unitario').val('');

        // esperar 2 segundos
        setTimeout(function() {
            $('#valor_total').text('0,00');
        }, 1000);

    }
    
</script>