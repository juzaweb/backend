@extends('tadcms::layouts.admin')

@section('content')
    <div class="row mb-2">
        <div class="col-md-6"></div>
        <div class="col-md-6">
            <div class="btn-group float-right">
                @if(config('tadcms.themes.upload.enabled'))
                    <a href="{{ route('admin.themes.install') }}" class="btn btn-success"><i class="fa fa-plus-circle"></i> @lang('tadcms::app.add-new-theme')</a>
                @endif
            </div>
        </div>
    </div>

    @livewire('tadcms::theme.theme-list')

@endsection