@extends('dashboard.templates.master')
@section('title', 'Editar Cupons')
@section('content')
    <div class="main-content container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>@yield('title')</h3>
                    <p class="text-subtitle text-muted">@yield('title')</p>
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

        <section class="section">
            <div class="card">
                <div class="card-body">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    {{ $error }}
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success">{{session('success')}}</div>
                    @endif
                    
                    <form class="form form-vertical" method="post" enctype="multipart/form-data"
                          action="{{ route('dashboard.cupons.update', ['id' => $cupom->id]) }}">
                        @method('PUT')
                        @csrf
                        <div class="form-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="nome">Nome</label>
                                        <input type="text" id="nome" value="{{ old('nome') ?? $cupom->nome }}" class="form-control" name="nome" placeholder="Nome do cupom" required  style="text-transform: uppercase;">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="desconto">Desconto</label>
                                        <input type="text" id="desconto" value="{{ old('desconto') ?? $cupom->desconto }}" class="form-control" name="desconto" placeholder="Desconto" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select name="status" id="status" class="form-control" required>
                                            <option value="1" @if($cupom->status == 1) selected @endif>Ativo</option>
                                            <option value="0" @if($cupom->status == 0) selected @endif>Inativo</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="apartir_de">Válido a partir de</label>
                                        <input type="datetime-local" id="apartir_de" value="{{ old('apartir_de') ?? $cupom->apartir_de }}" class="form-control" name="apartir_de" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="validade">Data de Validade</label>
                                        <input type="datetime-local" id="validade" value="{{ old('validade') ?? $cupom->validade }}" class="form-control" name="validade">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="categorias">Categorias válidas:</label>
                                        <select name="categorias_id[]" id="categorias" class="select-customizado" multiple onchange="getServices(this)">
                                            <option value="all">Todos</option> <!-- Adicionando a opção "Todos" -->   
                                            @foreach($categories as $categoria)
                                            <option value="{{ $categoria->id }}" 
                                                {{ in_array($categoria->id, $selectedCategories) ? 'selected' : '' }}>
                                                {{ $categoria->title }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12" id="services"
                                    @if(count($plans) > 0)
                                        style="display: block"
                                    @else
                                        style="display: none"
                                    @endif
                                >
                                    <div class="form-group">
                                        <label for="plan_id">Plans válidos:</label>
                                        <select name="plans_id[]" id="plan_id" class="select-customizado" multiple >
                                            <option value="all">Todos</option> <!-- Adicionando a opção "Todos" -->                                        
                                            @foreach($plans as $plan)
                                            <option value="{{ $plan->id }}" 
                                                {{ in_array($plan->id, $selectedPlans) ? 'selected' : '' }}>
                                                {{ $plan->title }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="only_by_email">Cupom unico</label>
                                        <select name="only_by_email" id="only_by_email" class="form-control" required>
                                            <option value="1" @if($cupom->only_by_email == 1) selected @endif>Sim</option>
                                            <option value="0" @if($cupom->only_by_email == 0) selected @endif>Não</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="limited_email">Limitado ao email</label>
                                        <input type="text" id="limited_email" value="{{ old('limited_email') ?? $cupom->limited_email }}" class="form-control" name="limited_email" placeholder="Limitado ao email">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn icon icon-left btn-success mt-1">
                            <i data-feather="check-circle"></i>
                            Editar
                        </button>
                    </form>
                </div>
            </div>
        </section>
    </div>

    <script>
        function getServices(element)
        {

            var selectedCategories = $('#categorias').val(); // Pega todos os valores selecionados no select com o id "categorias"

            $.ajax({
                url: "{{ route('dashboard.categories.getServicesMultiple') }}",
                type: 'POST',
                data: {
                    categorias_id: selectedCategories,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    response = JSON.parse(response);
                    $("#services").show();
                    $('#plan_id').empty(); // Limpa as opções existentes
                    $('#plan_id').append('<option value="all">Todos</option>');
                    response.plans.forEach(function(plan) {
                        $('#plan_id').append('<option value="' + plan.id + '">' + plan.title + '</option>');
                    });
                        // Reativar Select2 após preencher as opções
                    $('#plan_id').select2({
                        placeholder: "Selecione um ou mais planos",
                        allowClear: true
                    });
                   
                }
            });
        }

    </script>

    <style>
        .select-customizado{
            width: 100%;
            padding: 5px
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#categorias').select2({
                placeholder: "Selecione uma ou mais categorias",
                allowClear: true
            });

            // Inicializa Select2 no campo de planos
            $('#plan_id').select2({
                placeholder: "Selecione um ou mais planos",
                allowClear: true
            });
    
            $('#categorias').on('select2:select', function(e) {
                if (e.params.data.id === "all") {
                    let allSelected = $('#categorias').val() || [];
                    let allOptions = $("#categorias option:not([value='all'])").map(function() {
                        return $(this).val();
                    }).get();
    
                    if (allSelected.includes("all")) {
                        $('#categorias').val(allOptions).trigger('change');
                    } else {
                        $('#categorias').val([]).trigger('change');
                    }
                }
            });

            $('#plan_id').on('select2:select', function(e) {
                if (e.params.data.id === "all") {
                    let allSelected = $('#plan_id').val() || [];
                    let allOptions = $("#plan_id option:not([value='all'])").map(function() {
                        return $(this).val();
                    }).get();
    
                    if (allSelected.includes("all")) {
                        $('#plan_id').val(allOptions).trigger('change');
                    } else {
                        $('#plan_id').val([]).trigger('change');
                    }
                }
            });

            $('#plan_id').on('select2:unselect', function(e) {
                if (e.params.data.id === "all") {
                    $('#plan_id').val([]).trigger('change');
                }
            });


        });
    </script>
@endsection
