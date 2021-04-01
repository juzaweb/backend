@extends('tadcms::backend.layout')

@section('title', $title)

@section('content')

    <div class="row mb-2">
        <div class="col-md-6">
            <h5 class="mb-0 font-weight-bold">{{ $title }}</h5>
        </div>

        <div class="col-md-6">
            {{--<div class="btn-group float-right">
                @if(config('tadcms.themes.upload.enabled'))
                    <a href="{{ route('admin.theme.install') }}" class="btn btn-success"><i class="fa fa-upload"></i> @lang('tadcms::app.upload_theme')</a>
                @endif
            </div>--}}
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="dropify-wrapper">
                <div class="dropify-message"><span class="file-icon"></span>
                    <p>Drag and drop a file here or click</p>
                    <p class="dropify-error">Ooops, something wrong appended.</p></div>
                <div class="dropify-loader"></div>
                <div class="dropify-errors-container">
                    <ul></ul>
                </div>
                <input type="file" class="dropify">
                <button type="button" class="dropify-clear">Remove</button>
                <div class="dropify-preview"><span class="dropify-render"></span>
                    <div class="dropify-infos">
                        <div class="dropify-infos-inner"><p class="dropify-filename"><span class="file-icon"></span>
                                <span class="dropify-filename-inner"></span></p>
                            <p class="dropify-infos-message">Drag and drop or click to replace</p></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection