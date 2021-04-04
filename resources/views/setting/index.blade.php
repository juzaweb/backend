@extends('tadcms::layouts.admin')

@section('content')
    <div class="cui__utils__content">
        <div class="row mb-4">
            <div class="col-md-6">
                <h5 class="mb-0 card-title font-weight-bold">{{ $title }}</h5>
            </div>
        </div>
        <form action="{{ route('admin.setting.save') }}" method="post" class="form-ajax" id="form-setting">
            <div class="row">
                <div class="col-md-8">
                    @component('tadcms::setting.forms.input', [
                        'title' => trans('tadcms::app.site-name'),
                        'name' => 'sitename',
                    ])@endcomponent

                    @component('tadcms::setting.forms.textarea', [
                        'title' => trans('tadcms::app.site-description'),
                        'name' => 'sitedescription',
                    ])@endcomponent

                    <hr>

                    @do_action('setting.form_general.left')

                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> @lang('tadcms::app.save')</button>

            </div>

                <div class="col-md-4">

                    @component('tadcms::setting.forms.select', [
                        'title' => trans('tadcms::validation.attributes.anyone-can-register'),
                        'name' => 'users_can_register',
                        'options' => [
                            1 => trans('tadcms::app.yes'),
                            0 => trans('tadcms::app.no'),
                        ],
                    ])@endcomponent

                    @component('tadcms::setting.forms.select', [
                        'title' => trans('tadcms::validation.attributes.user-confirmation'),
                        'name' => 'user_confirmation',
                        'options' => [
                            1 => trans('tadcms::app.yes'),
                            0 => trans('tadcms::app.no'),
                        ],
                    ])@endcomponent
                    
                </div>
            </div>
        </form>
    </div>
@endsection