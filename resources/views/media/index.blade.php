@extends('tadcms::layouts.admin')

@section('content')
    <div class="row mb-2">
        <div class="col-md-6">
            <a href="{{ route('file-manager.index') }}?type={{ $fileType }}" target="_blank" class="btn btn-success">Open new tab</a>
        </div>
        <div class="col-md-6 text-right">
            @foreach($fileTypes as $key => $type)
                <a href="{{ route('admin.media.type', [$key]) }}" class="btn btn-primary w-25 @if($fileType == $key) disabled @endif">{{ strtoupper($key) }}</a>
            @endforeach
        </div>
    </div>

    <iframe src="{{ route('file-manager.index') }}?type={{ $fileType }}&embed=true" style="width: 100%; min-height: 500px; overflow: hidden; border: none;"></iframe>
@endsection