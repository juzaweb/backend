<div class="form-group form-taxonomy" xmlns:wire="http://www.w3.org/1999/xhtml">
    <label class="col-form-label w-100">
        @lang('tadcms::app.tags')
        <span>
            <a href="javascript:void(0)" class="float-right" wire:click="showFormAdd"><i class="fa fa-plus"></i> @lang('tadcms::app.add-new')</a>
        </span>
    </label>

    <select class="form-control select-tags"
            data-placeholder="--- @lang('tadcms::app.tags') ---"
            data-type="{{ $type }}"
            data-taxonomy="{{ $taxonomy }}"
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

<script>
    document.addEventListener('livewire:load', function (event) {
        window.livewire.hook('afterDomUpdate', () => {
            $('.select-tags').select2({
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
        });
    });
</script>