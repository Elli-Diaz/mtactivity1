<li @isset($item['id']) id="{{ $item['id'] }}" @endisset class="nav-item">

    <a class="nav-link {{ $item['class'] }} @isset($item['shift']) {{ $item['shift'] }} @endisset"
       href="{{ $item['href'] }}" @isset($item['target']) target="{{ $item['target'] }}" @endisset
       {!! $item['data-compiled'] ?? '' !!}>

        <i class="{{ $item['icon'] ?? 'far fa-fw fa-circle' }} {{
            isset($item['icon_color']) ? 'text-'.$item['icon_color'] : ''
        }}"></i>

        <p>
            {{ $item['text'] }}

            @isset($item['label'])
                <span class="badge badge-{{ $item['label_color'] ?? 'primary' }} right">
                    {{ $item['label'] }}
                </span>
            @endisset
        </p>

    </a>

</li>
<style>
    
    .nav-treeview .nav-link{
        color: #28a745 !important;
    }

    .nav-treeview .nav-link:hover{
        color: #fff !important;
        background-color: #28a745 !important;
    }

    .nav-treeview .nav-link.active{
        color: #fff !important;
        background-color: #28a745 !important;
    }

    .nav-link{
        color: #28a745 !important;
    }

    .nav-link:hover{
        color: #fff !important;
        background-color: #28a745 !important;
    }

     .nav-link.active{
        color: #fff !important;
        background-color: #28a745 !important;
    }

    hr{
        width: 90%;
        height: auto;
    }
</style>
