<aside class="main-sidebar {{ config('adminlte.classes_sidebar') }}">

    {{-- Sidebar brand logo --}}
    @if(config('adminlte.logo_img_xl'))
    @include('adminlte::partials.common.brand-logo-xl')
    @else
    @include('adminlte::partials.common.brand-logo-xs')
    @endif

    {{-- Sidebar menu --}}
    <div class="sidebar">
        <nav class="pt-2">
            <ul class="nav nav-pills nav-sidebar flex-column {{ config('adminlte.classes_sidebar_nav', '') }}"
                data-widget="treeview" role="menu"
                @if(config('adminlte.sidebar_nav_animation_speed') !=300)
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
<style>
    /* Change sidebar background color */
    .main-sidebar {
        background-color: #28a745;
        /* Green background */
    }

    /* Make sidebar links white */
    .main-sidebar ul.nav-sidebar>li>.nav-link {
        color: #ffffff;
        /* White text for links */
    }

    /* Change the hover color for links */
    .main-sidebar ul.nav-sidebar>li>.nav-link:hover {
        color: #f8f9fa;
        /* Slightly lighter white on hover */
    }

    /* Ensure active link text is also white */
    .main-sidebar ul.nav-sidebar>li>.nav-link.active {
        color: #ffffff;
    }
</style>