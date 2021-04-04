@extends('tadcms::layouts.admin')

@section('content')
    <div class="cui__utils__content">
        @component('tadcms::components.form')
            <div class="row">
                <div class="col-md-8">

                    @component('tadcms::setting.forms.input', [
                        'title' => trans('tadcms::validation.attributes.email_host'),
                        'name' => 'email_host',
                    ])@endcomponent

                    @component('tadcms::setting.forms.input', [
                        'title' => trans('tadcms::validation.attributes.email_port'),
                        'name' => 'email_port',
                    ])@endcomponent

                    @component('tadcms::setting.forms.select', [
                        'title' => trans('tadcms::validation.attributes.email_encryption'),
                        'name' => 'email_encryption',
                        'options' => [
                            'tls' => 'tls',
                            'ssl' => 'ssl'
                        ],
                    ])@endcomponent

                    @component('tadcms::setting.forms.input', [
                        'title' => trans('tadcms::validation.attributes.email_username'),
                        'name' => 'email_username',
                    ])@endcomponent

                    @component('tadcms::setting.forms.input', [
                        'title' => trans('tadcms::validation.attributes.email_password'),
                        'name' => 'email_password',
                    ])@endcomponent

                    <hr>

                    @component('tadcms::setting.forms.input', [
                        'title' => trans('tadcms::validation.attributes.email_from_address'),
                        'name' => 'email_from_address',
                    ])@endcomponent

                    @component('tadcms::setting.forms.input', [
                    'title' => trans('tadcms::validation.attributes.email_from_name'),
                    'name' => 'email_from_name',
                    ])@endcomponent

                </div>

            </div>
        @endcomponent
    </div>
@endsection