@extends('tadcms::layouts.admin')

@section('content')

    @component('tadcms::components.form', [
        'action' => route('admin.post-type.save', [$post_type])
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

                @do_action('post_type.' . $post_type . '.form.left')
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

                @component('tadcms::components.form_taxonomies', [
                    'label' => trans('tadcms::app.categories'),
                    'name' => 'categories',
                    //'value' => $model->thumbnail,
                ])@endcomponent

                @component('tadcms::components.form_tags', [
                    'label' => trans('tadcms::app.tags'),
                    'name' => 'tags',
                    //'value' => $model->thumbnail,
                ])@endcomponent

                @do_action('post_type.' . $post_type . '.form.right')
            </div>
        </div>

        <input type="hidden" name="id" value="{{ $model->id }}">
    @endcomponent
@endsection
