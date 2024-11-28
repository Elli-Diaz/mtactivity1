<aside class="main-sidebar {{ config('adminlte.classes_sidebar') }}">

    {{-- Sidebar brand logo --}}
    <img class="sidebar_img container-fluid d-flex justify-content-center mb-3" src="Images/green_apple_logo.png">
    <hr class="d-flex justify-content-center mb-3">
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
        background-color: #ffffff;
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
        color: #28a745;
    }
    .sidebar_img{
        height: 50%;
        width: 100%;
    }
</style>