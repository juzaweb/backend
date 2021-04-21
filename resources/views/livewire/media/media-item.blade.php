<li class="media-item">
    <a @if($item->is_file) href="javascript:void(0)" @else href="{{ route('admin.media.folder', [$item->type, $item->id]) }}" @endif>
        <div class="attachment-preview">
            <div class="thumbnail @if(empty($item->is_file)) media-folder @endif">
                <div class="centered">
                    <img src="{{ $item->thumb }}" alt="{{ $item->name }}">
                </div>
            </div>
        </div>
        {{--<div class="">
            <div class="text-dark text-uppercase font-weight-bold mr-auto">
                {{ $item->name }}
            </div>
            --}}{{--<div class="text-gray-6">
                <button class="btn btn-primary">Activate</button>
            </div>--}}{{--
        </div>--}}
    </a>
</li>