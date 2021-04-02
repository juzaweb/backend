@extends('tadcms::layouts.admin')

@section('content')

    <div class="row">
        <div class="col-md-6"></div>

        <div class="col-md-6">
            <div class="btn-group float-right">
                <a href="{{ route('admin.users.create') }}" class="btn btn-success"><i class="fa fa-plus-circle"></i> @lang('tadcms::app.add-new')</a>
            </div>
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-md-3">
            <form method="post" class="form-inline">
                <select name="bulk_actions" class="form-control w-60 mb-2 mr-1">
                    <option value="">@lang('tadcms::app.bulk-actions')</option>
                    <option value="delete">@lang('tadcms::app.delete')</option>
                    <option value="trash">@lang('tadcms::app.trash')</option>
                    <option value="active">@lang('tadcms::app.active')</option>
                    <option value="inactive">@lang('tadcms::app.inactive')</option>
                </select>

                <button type="submit" class="btn btn-primary mb-2" id="apply-action">@lang('tadcms::app.apply')</button>
            </form>
        </div>

        <div class="col-md-9">
            <form method="get" class="form-inline" id="form-search">
                <div class="form-group mb-2 mr-1">
                    <label for="inputName" class="sr-only">@lang('tadcms::app.search')</label>
                    <input name="search" type="text" id="inputName" class="form-control" placeholder="@lang('tadcms::app.search')" autocomplete="off">
                </div>

                <div class="form-group mb-2 mr-1 w-25">
                    <label for="status" class="sr-only">@lang('tadcms::app.status')</label>
                    <select name="status" id="status" class="form-control">
                        <option value="">@lang('tadcms::app.all-status')</option>
                        <option value="trash">@lang('tadcms::app.trash')</option>
                        <option value="active">@lang('tadcms::app.active')</option>
                        <option value="inactive">@lang('tadcms::app.inactive')</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary mb-2"><i class="fa fa-search"></i> @lang('tadcms::app.search')</button>
            </form>
        </div>

    </div>

    <div class="table-responsive mb-5">
        <table class="table tad-table">
            <thead>
                <tr>
                    <th data-width="3%" data-field="state" data-checkbox="true"></th>
                    <th data-field="name" data-sortable="true" data-formatter="name_formatter">@lang('tadcms::app.name')</th>
                    <th data-width="20%" data-field="email">@lang('tadcms::app.email')</th>
                    <th data-width="15%" data-sortable="true" data-field="created_at">@lang('tadcms::app.created-at')</th>
                    <th data-width="15%" data-field="status" data-sortable="true" data-align="center" data-formatter="status_formatter">@lang('tadcms::app.status')</th>
                </tr>
            </thead>
        </table>
    </div>

    <script type="text/javascript">
        function name_formatter(value, row, index) {
            return '<a href="'+ row.edit_url +'">'+ value +'</a>';
        }

        function status_formatter(value, row, index) {
            switch (value) {
                case 'active':
                    return '<span class="text-success">@lang('tadcms::app.active')</span>';
                case 'inactive':
                    return '<span class="text-danger">@lang('tadcms::app.inactive')</span>';
                case 'trash':
                    return '<span class="text-danger">@lang('tadcms::app.trash')</span>';
            }
        }

        var table = new TadTable({
            url: '{{ route('admin.users.get-data') }}',
            action_url: '{{ route('admin.users.bulk-actions') }}',
        });
    </script>
@endsection