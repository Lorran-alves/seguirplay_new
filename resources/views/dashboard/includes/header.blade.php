<div class="sidebar-wrapper ">
    <div class="sidebar-header">
    <img src="https://seguirplay.com/web_assets/img/logo_footer.png" alt="" srcset="">
    </div>
    <div class="sidebar-menu">
        <ul class="menu">
            <li class='sidebar-title'>Menu Seguir Play</li>
            <li class="sidebar-item {{ isActive('dashboard.index') }}">
                <a href="{{ route('dashboard.index') }}" class='sidebar-link'>
                    <i data-feather="bar-chart-2" width="20"></i>
                    <span>Analytics</span>
                </a>
            </li>
            <li class="sidebar-item {{ isActive('dashboard.comprasMensal') }}">
                <a href="{{ route('dashboard.comprasMensal') }}" class='sidebar-link'>
                    <i data-feather="activity" width="20"></i>
                    <span>Métricas Mensal</span>
                </a>
            </li>
             <li class="sidebar-item {{ isActive('dashboard.vendasCategorias') }}">
                <a href="{{ route('dashboard.vendasCategorias') }}" class='sidebar-link'>
                    <i data-feather="dollar-sign" width="20"></i>
                    <span>Métricas Compras</span>
                </a>
            </li>
            <li class="sidebar-item {{ isActive('dashboard.purchases.index') }}">
                <a href="{{ route('dashboard.purchases.index') }}" class='sidebar-link'>
                    <i data-feather="shopping-cart" width="20"></i>
                    <span>Pedidos</span>
                </a>
            </li>
            <li class="sidebar-item {{ isActive('dashboard.categories.index') }}">
                <a href="{{ route('dashboard.categories.index') }}" class='sidebar-link'>
                    <i data-feather="edit" width="20"></i>
                    <span>Serviços</span>
                </a>
                </li>
            <li class="sidebar-item {{ isActive('dashboard.cupons.index') }}">
                <a href="{{ route('dashboard.cupons.index') }}" class='sidebar-link'>
                    <i data-feather="tag" width="20"></i>
                    <span>Cupons</span>
                </a>
            </li>
            <li class="sidebar-item {{ isActive('dashboard.provedores.index') }}">
                <a href="{{ route('dashboard.provedores.index') }}" class='sidebar-link'>
                    <i data-feather="server" width="20"></i>
                    <span>Provedores</span>
                </a>
            </li>
            
            <li class="sidebar-item {{ isActive('dashboard.gestaoPedidoManual.index') }}">
                <a href="{{ route('dashboard.gestaoPedidoManual.index') }}" class='sidebar-link'>
                    <i data-feather="dollar-sign" width="20"></i>
                    <span>Pedido Manual</span>
                </a>
            </li>
            
            <li class="sidebar-item {{ isActive('dashboard.purchases.customersInactives') }}">
                <a href="{{ route('dashboard.purchases.customersInactives') }}" class='sidebar-link'>
                    <i data-feather="dollar-sign" width="20"></i>
                    <span>Clientes sem compras recente</span>
                </a>
            </li>
            
            <li class='sidebar-title'>Menu Monetiza</li>

            <li class="sidebar-item {{ isActive('dashboard.monetiza.index') }}">
                <a href="{{ route('dashboard.monetiza.index') }}" class='sidebar-link'>
                    <i data-feather="shopping-cart" width="20"></i>
                    <span>Pedidos</span>
                </a>
            </li>
            
            <li class="sidebar-item {{ isActive('dashboard.monetiza.gestaoMonetiza') }}">
                <a href="{{ route('dashboard.monetiza.gestaoMonetiza') }}" class='sidebar-link'>
                    <i data-feather="activity" width="20"></i>
                    <span>Gestão de monetização</span>
                </a>
            </li>

        </ul>
    </div>
    <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
</div>
