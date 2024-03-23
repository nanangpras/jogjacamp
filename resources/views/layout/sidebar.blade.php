<nav class="sidebar">
    <div class="sidebar-header">
        <a href="#" class="sidebar-brand">
            JogjaCamp
        </a>
        <div class="sidebar-toggler not-active">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="sidebar-body">
        <ul class="nav">
            <li class="nav-item nav-category">Main</li>
            <li class="nav-item {{ active_class(['/']) }}">
                <a href="{{ url('/') }}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Dashboard</span>
                </a>
            </li>
            <li class="nav-item nav-category">Master Data</li>
            <li class="nav-item {{ active_class(['product.index']) }}">
                <a href="{{route('category.index')}}" class="nav-link">
                    <i class="link-icon" data-feather="inbox"></i>
                    <span class="link-title">Kategori</span>
                </a>
            </li>

        </ul>
    </div>
</nav>
