<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        @can('Dashboard')
            <li class="nav-item">
                <a class="nav-link py-2" href="{{ route('dashboard') }}">
                    <i class="mdi mdi-chart-line  pr-2 icon-large"></i>
                    <span class="menu-title">Dashboard</span>
                </a>
            </li>
        @endcan
        @canany(['Pemasukan Index', 'Pengeluaran Index'])
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#accounting" aria-expanded="false"
                    aria-controls="accounting">
                    <i class="mdi mdi-calculator pr-2 icon-large icon-accounting"></i>
                    <span class="menu-title">Accounting</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="accounting">
                    <ul class="nav flex-column sub-menu">
                        @can('Pemasukan Index')
                            <li class="nav-item"> <a class="nav-link" href="{{ route('pemasukan.index') }}">Pemasukan</a>
                            </li>
                        @endcan
                        @can('Pengeluaran Index')
                            <li class="nav-item"> <a class="nav-link" href="{{ route('pengeluaran.index') }}">Pengeluaran</a>
                            </li>
                        @endcan
                    </ul>
                </div>
            </li>
        @endcanany
        @canany(['Kategori Index', 'Produk Index', 'Penjualan Index'])
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                    <i class="mdi mdi-sale pr-2 icon-large icon-profit"></i>
                    <span class="menu-title">Seling</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="ui-basic">
                    <ul class="nav flex-column sub-menu">
                        @can('Kategori Index')
                            <li class="nav-item"> <a class="nav-link" href="{{ route('kategori.index') }}">Kategori Produk</a>
                            </li>
                        @endcan
                        @can('Produk Index')
                            <li class="nav-item"> <a class="nav-link" href="{{ route('produk.index') }}">Produk</a></li>
                        @endcan
                        @can('Penjualan Index')
                            <li class="nav-item"> <a class="nav-link" href="{{ route('penjualan.index') }}">Penjualan</a></li>
                        @endcan
                    </ul>
                </div>
            </li>
        @endcanany

        @canany(['Supplier Index', 'Produk Supplier Index'])
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#supplier" aria-expanded="false" aria-controls="supplier">
                    <i class="mdi mdi-truck-delivery pr-2 icon-large icon-supplier"></i>
                    <span class="menu-title">Supplier</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="supplier">
                    <ul class="nav flex-column sub-menu">
                        @can('Supplier Index')
                            <li class="nav-item"> <a class="nav-link" href="{{ route('supplier.index') }}">Supplier</a>
                            </li>
                        @endcan
                        @can('Produk Supplier Index')
                            <li class="nav-item"> <a class="nav-link" href="{{ route('produk-supplier.index') }}">Produk</a>
                            </li>
                        @endcan
                    </ul>
                </div>
            </li>
        @endcanany
        @canany(['Project Index'])
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#project" aria-expanded="false" aria-controls="project">
                    <i class="mdi mdi-briefcase-outline pr-2 icon-large icon-project"></i>

                    <span class="menu-title">Project</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="project">
                    <ul class="nav flex-column sub-menu">
                        @can('Project Index')
                            <li class="nav-item"> <a class="nav-link" href="{{ route('project.index') }}">Project</a>
                            </li>
                        @endcan
                    </ul>
                </div>
            </li>
        @endcanany
        @canany(['Role Index', 'Permission Index', 'User Index'])
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#user_management" aria-expanded="false"
                    aria-controls="user_management">
                    <i class="mdi mdi-shield-account-outline pr-2 icon-large icon-user-management"></i>
                    <span class="menu-title">User Management</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="user_management">
                    <ul class="nav flex-column sub-menu">
                        @can('Role Index')
                            <li class="nav-item"> <a class="nav-link" href="{{ route('roles.index') }}">Role</a>
                            </li>
                        @endcan
                        @can('Permission Index')
                            <li class="nav-item"> <a class="nav-link" href="{{ route('permissions.index') }}">Permission</a>
                            </li>
                        @endcan
                        @can('User Index')
                            <li class="nav-item"> <a class="nav-link" href="{{ route('users.index') }}">User</a>
                            </li>
                        @endcan
                    </ul>
                </div>
            </li>
        @endcanany
    </ul>
</nav>
