<aside class="main-sidebar {{ config('adminlte.classes_sidebar', 'sidebar-dark-primary elevation-4') }}">

    {{-- Sidebar brand logo --}}
    @if(config('adminlte.logo_img_xl'))
        @include('adminlte::partials.common.brand-logo-xl')
    @else
        @include('adminlte::partials.common.brand-logo-xs')
    @endif

    {{-- Sidebar menu --}}
    <div class="sidebar">
        <nav class="pt-2">
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="info">
                        <center>
                            <div class="image">
                                <img class="img-avatar" src="user.jpg" alt="User Image">
                            </div>
                        
                            <ul class="list-inline mt-10" style ="font-coloe:white;">
                                <li class="list-inline-item">
                                    <a class="link-effect text-dual-primary-dark font-size-lg font-w600 text-sentence">{{ Auth::user()->name }}</a> - 
                                    <a class="link-effect text-dual-primary-dark font-size-lg font-w600 text-sentence">{{ Auth::user()->jabatan }}</a>
                                </li>
                            </ul>
                        </center>
                    </div>
                </div>
            </div>
            <ul class="nav nav-pills nav-sidebar flex-column {{ config('adminlte.classes_sidebar_nav', '') }}"
                data-widget="treeview" role="menu"
                @if(config('adminlte.sidebar_nav_animation_speed') != 300)
                    data-animation-speed="{{ config('adminlte.sidebar_nav_animation_speed') }}"
                @endif
                @if(!config('adminlte.sidebar_nav_accordion'))
                    data-accordion="false"
                @endif>
                {{-- Configured sidebar links --}}
                @each('adminlte::partials.sidebar.menu-item', $adminlte->menu('sidebar'), 'item')
            </ul>
        </nav>
    </div>
</aside>
