<div class="form-group form-taxonomy" xmlns:wire="http://www.w3.org/1999/xhtml">
    <label class="col-form-label w-100">
        {{ $taxonomy->get('label') }}
        <span>
            <a href="javascript:void(0)" class="float-right add-new"><i class="fa fa-plus"></i> @lang('tadcms::app.add-new')</a>
        </span>
    </label>

    <select class="form-control load-taxonomies select-tags"
            data-placeholder="--- {{ $taxonomy->get('label') }} ---"
            data-type="{{ $taxonomy->get('type') }}"
            data-taxonomy="{{ $taxonomy->get('singular') }}"
            data-explodes="tag-explode"></select>

    <div class="show-tags mt-2">
        @if($value ?? null)
            @foreach($value as $item)
                @component('tadcms::components.tag-item', [
                    'item' => $item
                ])
                @endcomponent
            @endforeach
        @endif
    </div>

    <div class="form-add box-hidden">
        <div class="form-group">
            <label class="col-form-label">@lang('tadcms::app.name')</label>
            <input type="text" class="form-control" autocomplete="off">
        </div>

        <button type="button" class="btn btn-primary"><i class="fa fa-plus-circle"></i> @lang('tadcms::app.add-tag')</button>
    </div>
</div>