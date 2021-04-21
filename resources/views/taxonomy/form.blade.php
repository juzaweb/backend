@extends('tadcms::layouts.admin')

@section('content')

    @component('tadcms::components.form', [
        'method' => $model->id ? 'put' : 'post',
        'action' => $model->id ?
            route('admin.taxonomy.update', [$taxonomy, $model->id]) :
            route('admin.taxonomy.store', [$taxonomy])
    ])
        <div class="row">
            <div class="col-md-8">
                <input type="hidden" name="redirect" value="{{ path_url(route('admin.taxonomy.index', [$taxonomy])) }}">

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
                    <select name="parent_id" id="parent_id" class="form-control load-taxonomies" data-taxonomy="{{ $taxonomy }}" data-placeholder="{{ trans('tadcms::app.parent') }}" data-explodes="{{ $model->id }}">
                        @if($model->parent)
                            <option value="{{ $model->parent->id }}">{{ $model->parent->name }}</option>
                        @endif
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

            <input type="hidden" name="taxonomy" value="{{ $taxonomy }}">
        </div>
    @endcomponent

@endsection