@extends('tadcms::layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-6"></div>

        <div class="col-md-6">
            <div class="btn-group float-right">
                <a href="{{ route("admin.{$postType}.create") }}" class="btn btn-success"><i class="fa fa-plus-circle"></i> @lang('tadcms::app.add-new')</a>
            </div>
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-md-3">
            <form method="post" class="form-inline">
                <select name="bulk_actions" class="form-control w-50 mb-2 mr-1">
                    <option value="">@lang('tadcms::app.bulk-actions')</option>
                    <option value="public">@lang('tadcms::app.public')</option>
                    <option value="private">@lang('tadcms::app.private')</option>
                    <option value="draft">@lang('tadcms::app.draft')</option>
                    <option value="delete">@lang('tadcms::app.delete')</option>
                </select>

                <button type="submit" class="btn btn-primary mb-2" id="apply-action">@lang('tadcms::app.apply')</button>
            </form>
        </div>

        <div class="col-md-9">
            <form method="get" id="form-search">

                <div class="row search-filter">
                    @foreach($taxonomies as $key => $taxonomy)
                        <div class="col-md-3">
                            <select name="taxonomies" id="taxonomy-{{ $key }}" class="form-control w-100 load-taxonomies" data-type="{{ $taxonomy->get('type') }}" data-taxonomy="{{ $taxonomy->get('singular') }}" data-placeholder="{{ $taxonomy->get('label') }}">
                            </select>
                        </div>
                    @endforeach

                    <div class="col-md-3">
                        <div class="form-group w-100">
                            <label for="status" class="sr-only">@lang('tadcms::app.status')</label>
                            <select name="status" id="status" class="form-control">
                                <option value="">@lang('tadcms::app.all-status')</option>
                                <option value="public">@lang('tadcms::app.public')</option>
                                <option value="private">@lang('tadcms::app.private')</option>
                                <option value="draft">@lang('tadcms::app.draft')</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-12 form-inline">
                        <div class="form-group w-25 mr-1">
                            <label for="search" class="sr-only">@lang('tadcms::app.search')</label>
                            <input name="search" type="text" id="search" class="form-control" placeholder="@lang('tadcms::app.search')" autocomplete="off">
                        </div>

                        <button type="submit" class="btn btn-primary">@lang('tadcms::app.search')</button>

                    </div>
                </div>

            </form>
        </div>
    </div>

    <div class="table-responsive mb-5">
        <table class="table tad-table">
            <thead>
                <tr>
                    <th data-width="3%" data-field="state" data-checkbox="true"></th>
                    <th data-width="10%" data-field="thumbnail" data-formatter="thumbnail_formatter">@lang('tadcms::app.thumbnail')</th>
                    <th data-field="title" data-formatter="name_formatter">@lang('tadcms::app.name')</th>

                    <th data-width="15%" data-field="created">@lang('tadcms::app.created-at')</th>
                    <th data-width="15%" data-field="status" data-align="center" data-formatter="status_formatter">@lang('tadcms::app.status')</th>
                </tr>
            </thead>
        </table>
    </div>

    <script type="text/javascript">
        function thumbnail_formatter(value, row, index) {
            return '<img src="'+ row.thumb_url +'" class="w-100">';
        }

        function name_formatter(value, row, index) {
            return '<a href="'+ row.edit_url +'">'+ value +'</a>';
        }

        function status_formatter(value, row, index) {
            switch (value) {
                case 'public':
                    return `<span class="text-success">${tadcms.lang.public}</span>`;
                case 'private':
                    return `<span class="text-warning">${tadcms.lang.private}</span>`;
                case 'draft':
                    return `<span class="text-secondary">${tadcms.lang.draft}</span>`;
            }
        }

        var table = new TadTable({
            url: '{{ route("admin.{$postType}.get-data") }}',
            action_url: '{{ route("admin.{$postType}.bulk-actions") }}',
        });
    </script>
@endsection