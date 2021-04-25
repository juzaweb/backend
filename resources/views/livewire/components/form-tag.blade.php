<div class="form-group form-taxonomy" xmlns:wire="http://www.w3.org/1999/xhtml">
    <label class="col-form-label w-100">
        @lang('tadcms::app.tags')
        <span>
            <a href="javascript:void(0)" class="float-right" wire:click="showFormAdd"><i class="fa fa-plus"></i> @lang('tadcms::app.add-new')</a>
        </span>
    </label>

    <select class="form-control load-taxonomies select-tags"
            data-placeholder="--- @lang('tadcms::app.tags') ---"
            data-type="{{ $type }}"
            data-taxonomy="{{ $taxonomy }}"
            data-explodes="tag-explode"></select>

    <div class="show-tags mt-2">
        @if($value ?? null)
            @foreach($value as $item)
            <span class="tag m-1">{{ $item->name }} <a href="javascript:void(0)" class="text-danger ml-1 remove-tag-item"><i class="fa fa-times-circle"></i></a>
    <input type="hidden" name="taxonomies[]" class="tag-explode" value="{{ $item->id }}">
    </span>
            @endforeach
        @endif
    </div>

    @if($showFormAdd)
    <div class="form-add">
        <div class="form-group">
            <label class="col-form-label">@lang('tadcms::app.name')</label>
            <input type="text" wire:model="name" class="form-control" autocomplete="off">
            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <button type="button" class="btn btn-primary" wire:click="add"><i class="fa fa-plus-circle"></i> @lang('tadcms::app.add-tag')</button>
    </div>
    @endif
</div>