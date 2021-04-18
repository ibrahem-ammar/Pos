<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{ asset('admin_files/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <img src="{{ asset('admin_files/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
            <a href="#" class="d-block disabled text-capitalize">{{ auth()->user()->first_name . ' ' . auth()->user()->last_name }}</a>
        </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

            <li class="nav-item">
                <a href="{{ route('dashboard.index') }}" class="nav-link">
                    <i class="nav-icon fas fa-th"></i>
                    <p class="text-capitalize">@lang('site.dashboard')</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{auth()->user()->hasPermission('read_users') ? route('dashboard.users.index') : '#' }}" class="nav-link {{auth()->user()->hasPermission('read_users') ? '' : 'disabled' }}">
                    <i class="nav-icon fas fa-th"></i>
                    <p class="text-capitalize">@lang('site.users')</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{auth()->user()->hasPermission('read_categories') ? route('dashboard.categories.index') : '#' }}" class="nav-link {{auth()->user()->hasPermission('read_categories') ? '' : 'disabled' }}">
                    <i class="nav-icon fas fa-th"></i>
                    <p class="text-capitalize">@lang('site.categories')</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{auth()->user()->hasPermission('read_products') ? route('dashboard.products.index') : '#' }}" class="nav-link {{auth()->user()->hasPermission('read_products') ? '' : 'disabled' }}">
                    <i class="nav-icon fas fa-th"></i>
                    <p class="text-capitalize">@lang('site.products')</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{auth()->user()->hasPermission('read_clients') ? route('dashboard.clients.index') : '#' }}" class="nav-link {{auth()->user()->hasPermission('read_clients') ? '' : 'disabled' }}">
                    <i class="nav-icon fas fa-th"></i>
                    <p class="text-capitalize">@lang('site.clients')</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{auth()->user()->hasPermission('read_orders') ? route('dashboard.orders.index') : '#' }}" class="nav-link {{auth()->user()->hasPermission('read_orders') ? '' : 'disabled' }}">
                    <i class="nav-icon fas fa-th"></i>
                    <p class="text-capitalize">@lang('site.orders')</p>
                </a>
            </li>


        </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
    </aside>
