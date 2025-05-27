<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - Blossom Boutique</title>
    <link href="{{ asset('admin/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>
<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
                <div class="sidebar-brand-text mx-3">Admin Panel</div>
            </a>
            
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.products.index') }}">
                    <i class="fas fa-fw fa-leaf"></i>
                    <span>Products</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.categories.index') }}">
                    <i class="fas fa-fw fa-tags"></i>
                    <span>Categories</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.orders.index') }}">
                    <i class="fas fa-fw fa-shopping-cart"></i>
                    <span>Orders</span>
                </a>
            </li>
        </ul>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ auth()->user()->name }}</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow">
                                <a class="dropdown-item" href="{{ route('home') }}">View Site</a>
                                <div class="dropdown-divider"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item" type="submit">Logout</button>
                                </form>
                            </div>
                        </li>
                    </ul>
                </nav>

                <!-- Page Content -->
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('admin/js/sb-admin-2.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    
    @stack('scripts')
</body>
</html>