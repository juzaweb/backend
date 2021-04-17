@extends('tadcms::layouts.admin')

@section('content')
    @component('tadcms::components.form')
        <input type="hidden" name="redirect" value="/{{ request()->path() }}">

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

                @component('tadcms::setting.forms.input', [
                    'title' => trans('tadcms::validation.attributes.site-url'),
                    'name' => 'siteurl',
                    'default' => config('app.url')
                ])@endcomponent

                @component('tadcms::setting.forms.select', [
                    'title' => trans('tadcms::validation.attributes.language'),
                    'name' => 'language',
                    'options' => $languages,
                ])@endcomponent

                <hr>

                @do_action('setting.form_general.left')

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
    @endcomponent
@endsection