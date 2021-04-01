@extends('tadcms::backend.layout')

@section('content')
    <form method="post" action="{{ route('admin.post-type.save', [$post_type]) }}" class="form-ajax">

        <div class="row">
            <div class="col-md-6"></div>

            <div class="col-md-6">
                <div class="btn-group float-right">
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> @lang('tadcms::app.save')</button>
                    <a href="{{ route('admin.post-type', [$post_type]) }}" class="btn btn-warning"><i class="fa fa-times-circle"></i> @lang('tadcms::app.cancel')</a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">

                <div class="form-group">
                    <label class="col-form-label" for="baseTitle">@lang('tadcms::app.title')</label>

                    <input type="text" name="title" class="form-control" id="baseTitle" value="{{ $model->title }}" autocomplete="off" required>
                </div>

                <div class="form-group">
                    <label class="col-form-label" for="content">@lang('tadcms::app.content')</label>
                    <textarea class="form-control" name="content" id="content" rows="6">{{ $model->content }}</textarea>
                </div>

                <div class="form-group">
                    <label class="col-form-label" for="status">@lang('tadcms::app.status')</label>
                    <select name="status" id="status" class="form-control">
                        <option value="1" @if($model->status == 1) selected @endif>@lang('tadcms::app.enabled')</option>
                        <option value="0" @if($model->status == 0 && !is_null($model->status)) selected @endif>@lang('tadcms::app.disabled')</option>
                    </select>
                </div>

            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label class="col-form-label" for="baseStatus">@lang('tadcms::app.thumbnail')</label>
                    <div class="form-thumbnail text-center">
                        <input id="thumbnail" type="hidden" name="thumbnail">
                        <div id="holder">
                            {{--<img src="{{ $model->getThumbnail() }}" class="w-100">--}}
                        </div>

                        <a href="javascript:void(0)" data-input="thumbnail" data-preview="holder" class="btn btn-primary text-capitalize file-manager">
                            <i class="fa fa-picture-o"></i> @lang('tadcms::app.choose_image')
                        </a>
                    </div>
                </div>
                <hr>
                <div class="form-group">
                    <label class="col-form-label" for="categories">@lang('tadcms::app.categories') <span><a href="javascript:void(0)" class="add-new-category float-right"><i class="fa fa-plus-circle"></i> @lang('tadcms::app.add_category')</a></span></label>

                    <div class="show-categories">
                        {{--@php
                        $selected = explode(',', $model->category);
                        @endphp--}}
                        <ul class="mt-2 p-0">
                            {{--@foreach($categories as $item)
                                <li class="m-1" id="item-category-{{ $item->id }}">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="categories[]" class="custom-control-input" id="category-{{ $item->id }}" value="{{ $item->id }}" @if(in_array($item->id, $selected)) checked @endif>
                                        <label class="custom-control-label" for="category-{{ $item->id }}">{{ $item->name }}</label>
                                    </div>
                                </li>
                            @endforeach--}}
                        </ul>
                    </div>

                    <div class="form-add-category box-hidden">
                        <div class="form-group">
                            <label class="col-form-label" for="categoryName">@lang('tadcms::app.name')</label>
                            <input type="text" class="form-control" id="categoryName" autocomplete="off">
                        </div>

                        <button type="button" class="btn btn-primary add-category"><i class="fa fa-plus-circle"></i> @lang('tadcms::app.add_category')</button>
                    </div>
                </div>
                <hr>
                <div class="form-group">
                    <label class="col-form-label" for="select-tags">@lang('tadcms::app.tags') <span><a href="javascript:void(0)" class="add-new-tags float-right"><i class="fa fa-plus-circle"></i> @lang('tadcms::app.add_tags')</a></span></label>

                    <select id="select-tags" class="form-control load-tags select-tags" data-placeholder="--- @lang('tadcms::app.tags') ---" data-explodes="tag-explode"></select>

                    <div class="show-tags mt-2">
                        {{--@foreach($tags as $item)
                        <span class="tag m-1">{{ $item->name }} <a href="javascript:void(0)" class="text-danger ml-1 remove-tag-item"><i class="fa fa-times-circle"></i></a>
<input type="hidden" name="tags[]" class="tag-explode" value="{{ $item->id }}">
</span>
                        @endforeach--}}
                    </div>

                    <div class="form-add-tags box-hidden">
                        <div class="form-group">
                            <label class="col-form-label" for="tagsName">@lang('tadcms::app.tags')</label>
                            <input type="text" class="form-control" id="tagsName" autocomplete="off">
                        </div>

                        <button type="button" class="btn btn-primary add-tags"><i class="fa fa-plus-circle"></i> @lang('tadcms::app.add_tags')</button>
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" name="id" value="{{ $model->id }}">

    </form>

    <script type="text/javascript">
        CKEDITOR.replace('content', {
            filebrowserImageBrowseUrl: '/admin-cp/file-manager?type=image',
            filebrowserBrowseUrl: '/admin-cp/file-manager?type=file'
        });
    </script>

@endsection
