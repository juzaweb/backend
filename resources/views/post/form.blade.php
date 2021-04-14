@extends('tadcms::layouts.admin')

@section('content')
    
    @component('tadcms::components.form', [
        'method' => $model->id ? 'put' : 'post',
        'action' =>  $model->id ?
            route('admin.post-type.update', [$postType, $model->id]) :
            route('admin.post-type.store', [$postType])
    ])
        <div class="row">
            <div class="col-md-8">

                @component('tadcms::components.form_input', [
                    'name' => 'title',
                    'label' => trans('tadcms::app.title'),
                    'value' => $model->title,
                ])
                @endcomponent

                @component('tadcms::components.form_ckeditor', [
                    'name' => 'content',
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
                        '1' => trans('tadcms::app.enabled'),
                        '0' => trans('tadcms::app.disabled')
                    ],
                ])
                @endcomponent

                @component('tadcms::components.form_image', [
                    'label' => trans('tadcms::app.thumbnail'),
                    'name' => 'thumbnail',
                    'value' => $model->thumbnail,
                ])@endcomponent

                @foreach($taxonomies as $key => $item)
                    @component('tadcms::components.form_taxonomies', [
                        'config' => $item,
                        'name' => 'taxonomy['. $key .']',
                        //'value' => $model->thumbnail
                    ])@endcomponent
                @endforeach

                {{--@if($spTag = @$supports['tag'])
                @component('tadcms::components.form_tags', [
                    'config' => $spTag,
                    'name' => 'taxonomy[tags]',
                    //'value' => $model->thumbnail,
                ])@endcomponent
                @endif--}}

                @do_action('post_type.' . $postType . '.form.right')
            </div>
        </div>

    @endcomponent
@endsection
