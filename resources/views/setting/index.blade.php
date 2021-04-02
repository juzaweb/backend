@extends('tadcms::layouts.admin')

@section('title', $title)

@section('content')
    <div class="cui__utils__content">
        <div class="row mb-4">
            <div class="col-md-6">
                <h5 class="mb-0 card-title font-weight-bold">{{ $title }}</h5>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12" id="form-setting">
                <form action="{{ route('admin.setting.save') }}" method="post" class="form-ajax">
                    <div class="form-group">
                        <label for="sitename">@lang('tadcms::app.site-name')</label>
                        <input type="text" name="sitename" class="form-control" id="sitename" value="{{ get_config('sitename') }}">
                    </div>

                    <div class="form-group">
                        <label for="sitedescription">@lang('tadcms::app.site-description')</label>
                        <textarea type="text" name="sitedescription" class="form-control" id="sitedescription" rows="5">{{ get_config('sitedescription') }}</textarea>
                    </div>

                    @do_action('setting.form_general')

                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> @lang('tadcms::app.save')</button>
                </form>
            </div>
        </div>
    </div>
@endsection