<nav class="navbar navbar-expand-lg navbar-light ">
    <div class="container">
        <a class="navbar-brand" href="{{ route('web.home') }}">
            <img src="{{ asset('web_assets/img/logo.png') }}" alt="{{ config('app.name') }}">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            {{-- <span class="navbar-toggler-icon">

            </span> --}}
            <span class="hidden">
                <img src="{{ asset('web_assets/img/icons8-cardápio.svg') }}" alt="{{ config('app.name') }}" style="max-width: 100%;">
            </span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="ms-auto my-2 order-0 order-md-1 position-relative">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    @php
                        $categories = \App\Models\Category::all();
                        $array = ['Instagram', 'Youtube', 'Kwai', 'Facebook', 'TikTok']
                    @endphp
                    @foreach($categories as $category)
                    @if(!$category->manual && in_array($category->title, $array))
                        <li class="nav-item mauto">
                            <a class="nav-link active" aria-current="page"
                               href="{{ route('web.categories.show', ['slug' => $category->slug]) }}">{{ $category->title }}</a>
                        </li>
                    @elseif(!$category->manual)
                        <?php $categoriesForDropdown[] = $category; ?>
                    @endif
                    @endforeach
            
                    <li class="nav-item mauto">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                + Serviços
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                @foreach($categoriesForDropdown as $category)
                                    <li>
                                        <a class="dropdown-item"
                                            href="{{ route('web.categories.show', ['slug' => $category->slug]) }}">
                                            {{$category->title}}
                                        </a>
                                    </li>
                                @endforeach     
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item mauto">
                        <button data-bs-toggle="modal" data-bs-target="#pedido"><i class="fa-solid fa-magnifying-glass icon-pedido"></i> Pedidos</button>
                        
                    </li>

                    

                     <li class="nav-item ps-0" id="link_cart" style="display: none;"onclick="mostrarCarrinho()">
                        <a class="nav-link" aria-current="page" >
                            <button class="h_btn"><i class="fa fa-shopping-cart"></i> Carrinho</button>
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </div>
</nav>
