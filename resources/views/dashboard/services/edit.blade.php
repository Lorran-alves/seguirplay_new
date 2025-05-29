@extends('dashboard.templates.master')
@section('title', 'Editar serviço')
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
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success">{{session('success')}}</div>
                    @endif
                    <form class="form form-vertical" method="post" enctype="multipart/form-data"
                          action="{{ route('dashboard.services.update', ['plan' => $service->id]) }}">
                        @method('PUT')
                        @csrf
                        <div class="form-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="price">Tipo</label>
                                        <select name="" id="quantityOption" class="form-control">
                                            <option value="1">Quantidade alterada</option>
                                            <option value="2">Quantidade fixa</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="title">Titulo</label>
                                        <input type="text" id="title" value="{{ old('title') ?? $service->title }}"
                                               class="form-control" name="title" placeholder="Título">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="type">Tipo</label>
                                        <select name="type" class="form-control">
                                            <option value="1" @if($service->type == 1) selected @endif>Curtidas</option>
                                            <option value="2" @if($service->type == 2) selected @endif>Visualização</option>
                                            <option value="3" @if($service->type == 3) selected @endif >Seguidores</option>
                                            <option value="4" @if($service->type == 4) selected @endif>Comentario</option>
                                            <option value="5" @if($service->type == 5) selected @endif>Métricas</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="provedor">Provedor</label>
                                        <select name="provedor" id="provedor" class="form-control">
                                            @foreach($provedores as $provedor)
                                            <option value="{{ $provedor->valor }}"
                                                {{ ($provedor->valor == $service->provedor ? 'selected' : '') }}>
                                                {{ $provedor->name }}
                                            </option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="id_provedor">ID Plano Provedor</label>
                                        <input type="text" id="id_provedor" value="{{ $service->id_provedor }}"
                                               class="form-control" name="id_provedor" placeholder="ID Provedor">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="price">Preço</label>
                                        <input type="text" id="price" value="{{ old('price') ?? $service->price }}"
                                               class="form-control" name="price" placeholder="Preço">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="quantity_min">Quantidade minima</label>
                                        <input type="number" id="quantity_min" placeholder="Quantidade minima"
                                               value="{{ $service->quantity_min }}" class="form-control"
                                               name="quantity_min">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="quantity">Quantidade fixa</label>
                                        <input type="number" id="quantity" placeholder="Quantidade fixa"
                                               value="{{ $service->quantity }}" class="form-control"
                                               name="quantity" disabled>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="category">Categoria</label>
                                        <select name="category_id" id="category" class="form-control">
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ ($category->id == $service->category_id ? 'selected' : '') }}>
                                                    {{ $category->title }}
                                                </option>
                                            @endforeach
                                        </select>
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
@endsection
@push('scripts')
    <script>
        $('#price').mask('00.000.000,0000', {reverse: true});
        
        $('#quantityOption').change(function (){
            changeOption();
        })

        function changeOption(){
            if($('#quantityOption').val() == 2){
                $('#quantity').attr('disabled', false);
                $('#quantity_min').attr('disabled', true);
            }else{
                $('#quantity_min').attr('disabled', false);
                $('#quantity').attr('disabled', true);
            }
        }
        changeOption();
    </script>
@endpush
