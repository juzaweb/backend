<div class="card">
    <a @if($item->is_file) href="javascript:void(0)" @else href="{{ route('admin.media.folder', [$item->type, $item->id]) }}" @endif>
        <div class="height-200 d-flex flex-column kit__g13__head">
            <img src="{{ $item->thumb }}" alt="{{ $item->name }}">
        </div>
        <div class="card card-borderless mb-0">
            <div class="card-header border-bottom-0">
                <div class="d-flex">
                    <div class="text-dark text-uppercase font-weight-bold mr-auto">
                        {{ $item->name }}
                    </div>
                    {{--<div class="text-gray-6">
                        <button class="btn btn-primary">Activate</button>
                    </div>--}}
                </div>
            </div>
        </div>
    </a>
</div>