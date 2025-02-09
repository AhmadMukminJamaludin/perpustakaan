<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/dashboard') }}" class="brand-link">
        <i class="fas fa-book brand-image img-circle"></i>
        <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                
                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ url('/dashboard') }}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/') }}" class="nav-link">
                        <i class="nav-icon fas fa-cart-shopping"></i>
                        <p>Koleksi Buku</p>
                    </a>
                </li>

                @php
                    $masterActive = request()->is('master/users*') ||
                                    request()->is('master/kategori*') ||
                                    request()->is('master/penerbit*') ||
                                    request()->is('master/penulis*') ||
                                    request()->is('master/buku*');
                @endphp
                <li class="nav-item has-treeview menu-open">
                    <a href="#" class="nav-link {{ $masterActive ? 'active' : '' }}">
                        <i class="nav-icon fas fa-database"></i>
                        <p>
                            Master Data
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('users.index') }}" class="nav-link {{ request()->is('master/users*') ? 'active' : '' }}">
                                <i class="fas fa-users nav-icon"></i>
                                <p>Anggota</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('kategori.index') }}" class="nav-link {{ request()->is('master/kategori*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-book"></i>
                                <p>Master Kategori</p>
                            </a>
                        </li>                        
                        <li class="nav-item">
                            <a href="{{ route('penerbit.index') }}" class="nav-link {{ request()->is('master/penerbit*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-book"></i>
                                <p>Master Penerbit</p>
                            </a>
                        </li>                        
                        <li class="nav-item">
                            <a href="{{ route('penulis.index') }}" class="nav-link {{ request()->is('master/penulis*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-book"></i>
                                <p>Master Penulis</p>
                            </a>
                        </li>                        
                        <li class="nav-item">
                            <a href="{{ route('buku.index') }}" class="nav-link {{ request()->is('master/buku*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-book"></i>
                                <p>Master Buku</p>
                            </a>
                        </li>                        
                    </ul>
                </li>
                @php
                    $transaksiActive = request()->is('transaksi/booking*') ||
                                    request()->is('transaksi/peminjaman*')
                @endphp
                <li class="nav-item has-treeview menu-open">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-exchange-alt"></i>
                        <p>
                            Transaksi
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('booking.index') }}" class="nav-link {{ request()->is('transaksi/booking*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-bookmark"></i>
                                <p>Booking</p>
                            </a>
                        </li> 
                        <li class="nav-item">
                            <a href="{{ route('peminjaman.index') }}" class="nav-link {{ request()->is('transaksi/peminjaman*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-handshake"></i>
                                <p>Peminjaman</p>
                            </a>
                        </li> 
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
