@extends('tadcms::layouts.admin')

@section('content')

    @component('tadcms::components.form', [
        'action' => '',
        'method' => 'post'
    ])
        <div class="row">
            <div class="col-md-8">
                @component('tadcms::components.form_input', [
                    'name' => 'name',
                    'label' => trans('tadcms::app.name'),
                    'value' => $model->name
                ])
                @endcomponent

                @component('tadcms::components.form_textarea', [
                    'name' => 'description',
                    'label' => trans('tadcms::app.description'),
                    'value' => $model->description
                ])
                @endcomponent

                <div class="form-group">
                    <label class="col-form-label" for="parent_id">@lang('tadcms::app.parent')</label>
                    <select name="parent_id" id="parent_id" class="form-control load-taxonomy" data-taxonomy="" data-placeholder="{{ trans('tadcms::app.parent') }}">

                    </select>
                </div>
            </div>

            <div class="col-md-4">
                @component('tadcms::components.form_image', [
                    'name' => 'thumbnail',
                    'label' => trans('tadcms::app.thumbnail'),
                    'value' => $model->thumbnail
                ])@endcomponent
            </div>

            <input type="hidden" name="id" value="{{ $model->id }}">
        </div>
    @endcomponent

@endsection