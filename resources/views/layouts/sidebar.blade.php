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
                    <li class="nav-item {{ isset($menu->children) ? 'has-treeview menu-open' : '' }}">
                        <a href="{{ $menu->url }}" class="nav-link">
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
                                    <li class="nav-item">
                                        <a href="{{ $child->url }}" class="nav-link">
                                            <i class="{{ $child->icon }} nav-icon"></i>
                                            <p>{{ $child->name }}</p>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
