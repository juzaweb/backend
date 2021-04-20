<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        @if(!request()->is(config('tadcms.admin-prefix') . '/dashboard'))
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">@lang('tadcms::app.dashboard')</a></li>
        @endif

        @foreach($items as $item)
            @if(isset($item['url']))
                <li class="breadcrumb-item"><a href="{{ $item['url'] }}">{{ $item['title'] }}</a></li>
            @else
                <li class="breadcrumb-item active" aria-current="page">{{ $item['title'] }}</li>
            @endif
        @endforeach

    </ol>
</nav>