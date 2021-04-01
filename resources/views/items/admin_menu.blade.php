@foreach($items as $item)
    @if(isset($item['children']))
        <li class="cui__menuLeft__item cui__menuLeft__submenu cui__menuLeft__item-{{ $item['url'] }}">
            <span class="cui__menuLeft__item__link">
                <i class="cui__menuLeft__item__icon {{ $item['icon'] }}"></i>

                <span class="cui__menuLeft__item__title">{{ trans($item['title']) }}</span>

            </span>

            <ul class="cui__menuLeft__navigation">
            @foreach($item['children'] as $child)
                <li class="cui__menuLeft__item cui__menuLeft__item-{{ $child['url'] }}">
                    <a class="cui__menuLeft__item__link" href="{{ url('admin-cp/' . str_replace('.', '/', $child['url'])) }}">
                        <span class="cui__menuLeft__item__title">{{ trans($child['title']) }}</span>
                        {{--<i class="cui__menuLeft__item__icon fe fe-film"></i>--}}
                    </a>
                </li>
            @endforeach
            </ul>
        </li>
    @else
        <li class="cui__menuLeft__item cui__menuLeft__item-{{ $item['url'] }}">
            <a class="cui__menuLeft__item__link" href="{{ url('admin-cp/' . str_replace('.', '/', $item['url'])) }}">
                <i class="cui__menuLeft__item__icon {{ $item['icon'] }}"></i>
                <span class="cui__menuLeft__item__title">{{ trans($item['title']) }}</span>

            </a>
        </li>
    @endif
@endforeach