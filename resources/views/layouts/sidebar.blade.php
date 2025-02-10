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
                @foreach (getMenuTree() as $menu)
                    @can('view-' . $menu->slug)
                        @php
                            $isActive = Request::is(ltrim($menu->url, '/')) ? 'active' : '';
                            $isMenuOpen = isset($menu->children) && collect($menu->children)->contains(fn($child) => Request::is(ltrim($child->url, '/'))) ? 'menu-open' : '';
                        @endphp
                        <li class="nav-item {{ $isMenuOpen }}">
                            <a href="{{ $menu->url }}" class="nav-link {{ $isActive }}">
                                <i class="nav-icon {{ $menu->icon }}"></i>
                                <p>
                                    {{ $menu->name }}
                                    @if (isset($menu->children))
                                        <i class="right fas fa-angle-left"></i>
                                    @endif
                                </p>
                            </a>
                            @if (isset($menu->children))
                                <ul class="nav nav-treeview">
                                    @foreach ($menu->children as $child)
                                        @can('view-' . $child->slug)
                                            @php
                                                $isChildActive = Request::is(ltrim($child->url, '/')) ? 'active' : '';
                                            @endphp
                                            <li class="nav-item">
                                                <a href="{{ $child->url }}" class="nav-link {{ $isChildActive }}">
                                                    <i class="{{ $child->icon }} nav-icon"></i>
                                                    <p>{{ $child->name }}</p>
                                                </a>
                                            </li>
                                        @endcan
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endcan
                @endforeach
                @if (Auth::user()->hasRole('admin'))
                    <li class="nav-item">
                        <a href="{{ route('role-permission.index') }}" class="nav-link {{ Request::is('role-permission') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-shield"></i>
                            <p>Hak Akses</p>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
