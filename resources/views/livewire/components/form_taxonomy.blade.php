<div class="form-group" xmlns:wire="http://www.w3.org/1999/xhtml">

    <label class="col-form-label w-100">{{ trans(@$taxonomy['label']) }}
        <span><a href="javascript:void(0)" class="float-right" wire:click="showAddNewForm"><i class="fa fa-plus"></i> @lang('tadcms::app.add-new')</a></span>
    </label>

    <div class="show-taxonomies taxonomy-{{ $taxonomy['taxonomy'] }}">
        <ul class="mt-2 p-0" wire:init="loadItems">
            @foreach($items as $item)
                <li class="m-1" id="item-category-{{ $item->id }}">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="taxonomies[]" class="custom-control-input" id="{{ $taxonomy['taxonomy'] }}-{{ $item->id }}" value="{{ $item->id }}" @if(in_array($item->id, $value ?? [])) checked @endif>
                        <label class="custom-control-label" for="{{ $taxonomy['taxonomy'] }}-{{ $item->id }}">{{ $item->name }}</label>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>

    @if($addNewForm)
    <div class="add-new-form">
        <div class="form-group">
            <label class="col-form-label">@lang('tadcms::app.name') <abbr>*</abbr></label>
            <input type="text" wire:model="name" class="form-control" autocomplete="off">
            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        {{--<div class="form-group">--}}
            {{--<label class="col-form-label">@lang('tadcms::app.parent')</label>--}}
            {{--<select type="text" wire:model="parent" class="form-control load-taxonomy" autocomplete="off" data-taxonomy="{{ $taxonomy['taxonomy'] }}"></select>--}}
            {{--@error('parent') <span class="text-danger">{{ $message }}</span> @enderror--}}
        {{--</div>--}}

        <button type="button" class="btn btn-primary" wire:click="add" wire:loading.attr="disabled"><i class="fa fa-plus-circle" wire:loading.class="fa fa-spinner fa-spin"></i> @lang('tadcms::app.add')</button>
    </div>
    @endif
</div>