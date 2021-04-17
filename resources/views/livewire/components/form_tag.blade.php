<div class="form-group form-taxonomy">
    <label class="col-form-label w-100">
        @lang('tadcms::app.tags')
        <span>
            <a href="javascript:void(0)" class="add-new float-right"><i class="fa fa-plus"></i> @lang('tadcms::app.add-new')</a>
        </span>
    </label>

    <select class="form-control load-taxonomy select-tags" data-placeholder="--- @lang('tadcms::app.tags') ---" data-explodes="tag-explode"></select>

    <div class="show-tags mt-2">
        {{--@foreach($tags as $item)
        <span class="tag m-1">{{ $item->name }} <a href="javascript:void(0)" class="text-danger ml-1 remove-tag-item"><i class="fa fa-times-circle"></i></a>
<input type="hidden" name="tags[]" class="tag-explode" value="{{ $item->id }}">
</span>
        @endforeach--}}
    </div>

    <div class="form-add @if(!$showFormAdd) box-hidden @endif">
        <div class="form-group">
            <label class="col-form-label" for="tagsName">@lang('tadcms::app.tags')</label>
            <input type="text" class="form-control" id="tagsName" autocomplete="off">
        </div>

        <button type="button" class="btn btn-primary add-tags"><i class="fa fa-plus-circle"></i> @lang('tadcms::app.add-tags')</button>
    </div>

</div>