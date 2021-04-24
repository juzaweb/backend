<div class="form-group form-taxonomy" xmlns:wire="http://www.w3.org/1999/xhtml">
    <label class="col-form-label w-100">
        {{ $label ?? '' }}
        <span><a href="javascript:void(0)" class="float-right add-new"><i class="fa fa-plus"></i> @lang('tadcms::app.add-new')</a></span>
    </label>

    <div class="show-taxonomies taxonomy-{{ $taxonomy }}">
        <ul class="mt-2 p-0" wire:init="loadItems">
            @foreach($items as $item)
                <li class="m-1" id="item-category-{{ $item->id }}">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="taxonomies[]" class="custom-control-input" id="{{ $taxonomy }}-{{ $item->id }}" value="{{ $item->id }}" @if(in_array($item->id, $value ?? [])) checked @endif>
                        <label class="custom-control-label" for="{{ $taxonomy }}-{{ $item->id }}">{{ $item->name }}</label>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="form-add box-hidden">
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

        <button type="button" class="btn btn-primary"><i class="fa fa-plus-circle" wire:loading.class="fa fa-spinner fa-spin"></i> @lang('tadcms::app.add')</button>
    </div>
</div>