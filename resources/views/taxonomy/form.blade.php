@extends('tadcms::layouts.admin')

@section('content')

    @component('tadcms::components.form', [
        'method' => $model->id ? 'put' : 'post',
        'action' => $model->id ?
            route('admin.'.$taxonomy.'.update', [$model->id]) :
            route('admin.'.$taxonomy.'.store')
    ])
        <div class="row">
            <div class="col-md-8">
                <input type="hidden" name="redirect" value="{{ path_url(route('admin.'.$taxonomy.'.index')) }}">

                @component('tadcms::components.form_input', [
                    'name' => $lang . '[name]',
                    'label' => trans('tadcms::app.name'),
                    'value' => $model->name
                ])
                @endcomponent

                @component('tadcms::components.form_textarea', [
                    'name' => $lang . '[description]',
                    'label' => trans('tadcms::app.description'),
                    'value' => $model->description
                ])
                @endcomponent

                @if(in_array('hierarchical', $supports))
                <div class="form-group">
                    <label class="col-form-label" for="parent_id">@lang('tadcms::app.parent')</label>
                    <select name="parent_id" id="parent_id" class="form-control load-taxonomies" data-taxonomy="{{ $taxonomy }}" data-placeholder="{{ trans('tadcms::app.parent') }}" data-explodes="{{ $model->id }}">
                        @if($model->parent)
                            <option value="{{ $model->parent->id }}">{{ $model->parent->name }}</option>
                        @endif
                    </select>
                </div>
                @endif
            </div>
            @if(in_array('thumbnail', $supports))
            <div class="col-md-4">
                @component('tadcms::components.form_image', [
                    'name' => $lang . '[thumbnail]',
                    'label' => trans('tadcms::app.thumbnail'),
                    'value' => $model->thumbnail
                ])@endcomponent
            </div>
            @endif
        </div>
    @endcomponent

@endsection