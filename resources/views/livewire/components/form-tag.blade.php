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
            data-explodes="{{ $taxonomy->get('singular') }}-explode"></select>

    <div class="show-tags mt-2">
        @foreach($items as $item)
            @component('tadcms::components.tag-item', [
                'item' => $item
            ])
            @endcomponent
        @endforeach
    </div>

    <div class="form-add mt-2 form-add-taxonomy box-hidden">
        <div class="form-group mb-1">
            <label class="col-form-label">@lang('tadcms::app.name')</label>
            <input type="text" class="form-control taxonomy-name" autocomplete="off">
        </div>

        @if(in_array('hierarchical', $taxonomy->get('supports', [])))
        <div class="form-group mb-1">
            <label class="col-form-label">@lang('tadcms::app.parent')</label>
            <select type="text" class="form-control taxonomy-parent load-taxonomies" autocomplete="off" data-type="{{ $taxonomy->get('type') }}" data-taxonomy="{{ $taxonomy->get('singular') }}">
            </select>
        </div>
        @endif

        <button
                type="button"
                class="btn btn-primary mt-2"
                data-type="{{ $taxonomy->get('type') }}"
                data-taxonomy="{{ $taxonomy->get('taxonomy') }}"
        ><i class="fa fa-plus-circle"></i> @lang('tadcms::app.add')</button>
    </div>
</div>