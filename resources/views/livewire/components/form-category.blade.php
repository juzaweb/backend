<div class="form-group form-taxonomy" xmlns:wire="http://www.w3.org/1999/xhtml">
    <label class="col-form-label w-100">
        {{ $label }}
        <span><a href="javascript:void(0)" class="float-right" wire:click="showFormAdd"><i class="fa fa-plus"></i> @lang('tadcms::app.add-new')</a></span>
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

    @if($showFormAdd)
    <div class="form-add">
        <div class="form-group">
            <label class="col-form-label">@lang('tadcms::app.name') <abbr>*</abbr></label>
            <input type="text" wire:model="name" class="form-control" autocomplete="off">
            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label class="col-form-label">@lang('tadcms::app.parent')</label>
            <select type="text" wire:model="parent" class="form-control select-parent" autocomplete="off" data-type="{{ $type }}" data-taxonomy="{{ $taxonomy }}">
                @if($parent)
                @php
                    $select = \Tadcms\System\Models\Taxonomy::find($parent);
                @endphp

                    @if($select)
                        <option value="{{ $select->id }}">{{ $select->name }}</option>
                    @endif

                @endif
            </select>
            @error('parent') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <button type="button" class="btn btn-primary" wire:click="add" wire:loading.attr="disabled" wire:target="add"><i class="fa fa-plus-circle" wire:loading.class="fa fa-spinner fa-spin" wire:target="add"></i> @lang('tadcms::app.add')</button>
    </div>
    @endif
</div>

<script>
    document.addEventListener('livewire:load', function (event) {
        window.livewire.hook('afterDomUpdate', () => {
            $('.select-parent').select2({
                allowClear: true,
                dropdownAutoWidth : true,
                width: '100%',
                placeholder: function(params) {
                    return {
                        id: null,
                        text: params.placeholder,
                    }
                },
                ajax: {
                    method: 'GET',
                    url: tadcms.adminUrl +'/load-data/loadTaxonomies',
                    dataType: 'json',
                    data: function (params) {
                        let type = $(this).data('type');
                        let taxonomy = $(this).data('taxonomy');
                        let explodes = $(this).data('explodes');
                        if (explodes) {
                            explodes = $("." + explodes).map(function () {
                                return $(this).val();
                            }).get();
                        }

                        var query = {
                            search: $.trim(params.term),
                            page: params.page,
                            explodes: explodes,
                            type: type,
                            taxonomy: taxonomy
                        };
                        return query;
                    }
                }
            });

            $('.select-parent').on('change', function (e) {
                var data = $(this).select2("val");
                @this.set('parent', data);
            });
        });
    });
</script>