<div class="form-group form-taxonomy" xmlns:wire="http://www.w3.org/1999/xhtml">
    <label class="col-form-label w-100">
        {{ $taxonomy->get('label') }}
        <span><a href="javascript:void(0)" class="float-right"><i class="fa fa-plus"></i> @lang('tadcms::app.add-new')</a></span>
    </label>

    <div class="show-taxonomies taxonomy-{{ $taxonomy->get('singular') }}">
        <ul class="mt-2 p-0">
            @foreach($items as $item)
                @component('tadcms::components.category-item', [
                    'taxonomy' => $taxonomy,
                    'item' => $item
                ])
                @endcomponent
            @endforeach
        </ul>
    </div>

    <div class="form-add box-hidden">
        <div class="form-group">
            <label class="col-form-label">@lang('tadcms::app.name') <abbr>*</abbr></label>
            <input type="text" class="form-control" autocomplete="off">
        </div>

        <div class="form-group">
            <label class="col-form-label">@lang('tadcms::app.parent')</label>
            <select type="text" class="form-control load-taxonomy" autocomplete="off" data-type="{{ $taxonomy->get('type') }}" data-taxonomy="{{ $taxonomy->get('singular') }}">
            </select>
        </div>

        <button type="button" class="btn btn-primary"><i class="fa fa-plus-circle"></i> @lang('tadcms::app.add')</button>
    </div>

</div>