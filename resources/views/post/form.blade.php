@extends('tadcms::layouts.admin')

@section('content')
    
    @component('tadcms::components.form', [
        'method' => $model->id ? 'put' : 'post',
        'action' =>  $model->id ?
            route('admin.'. $postType .'.update', [$model->id]) :
            route('admin.'. $postType .'.store')
    ])
        <div class="row">
            <div class="col-md-8">
                <input type="hidden" name="redirect" value="{{ path_url(route('admin.'.$postType.'.index')) }}">

                @component('tadcms::components.form_input', [
                    'name' => $lang . "[title]",
                    'label' => trans('tadcms::app.title'),
                    'value' => $model->title,
                ])
                @endcomponent

                @component('tadcms::components.form_ckeditor', [
                    'name' => $lang . '[content]',
                    'label' => trans('tadcms::app.content'),
                    'value' => $model->content,
                ])
                @endcomponent

                @do_action('post_type.' . $postType . '.form.left')
            </div>

            <div class="col-md-4">

                @component('tadcms::components.form_select', [
                    'label' => trans('tadcms::app.status'),
                    'name' => 'status',
                    'value' => $model->status,
                    'options' => [
                        'public' => trans('tadcms::app.public'),
                        'private' => trans('tadcms::app.private'),
                        'draft' => trans('tadcms::app.draft'),
                    ],
                ])
                @endcomponent

                @component('tadcms::components.form_image', [
                    'label' => trans('tadcms::app.thumbnail'),
                    'name' => $lang . '[thumbnail]',
                    'value' => $model->thumbnail,
                ])@endcomponent

                @foreach($taxonomies as $taxonomy)
                    @component('tadcms::components.form_taxonomies', [
                        'taxonomy' => $taxonomy,
                        'value' => $model
                    ])@endcomponent
                @endforeach

                @do_action('post_type.' . $postType . '.form.right')
            </div>
        </div>

    @endcomponent
@endsection
