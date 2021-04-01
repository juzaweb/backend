@extends('tadcms::backend.layout')

@section('content')

    <div class="row">
        <div class="col-md-6"></div>

        <div class="col-md-6">
            <div class="btn-group float-right">
                <a href="{{ route('admin.taxonomy.create', [$type, $taxonomy]) }}" class="btn btn-success"><i class="fa fa-plus-circle"></i> @lang('tadcms::app.add-new')</a>
            </div>
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-md-5">
            @include('tadcms::backend.category.form-input')


        </div>

        <div class="col-md-7">
            <div class="row mb-2">
                <div class="col-md-3">
                    <form method="post" class="form-inline">
                        <select name="bulk_actions" class="form-control w-60 mb-2 mr-1">
                            <option value="">@lang('tadcms::app.bulk-actions')</option>
                            <option value="delete">@lang('tadcms::app.delete')</option>
                        </select>

                        <button type="submit" class="btn btn-primary mb-2" id="apply-action">@lang('tadcms::app.apply')</button>
                    </form>
                </div>

                <div class="col-md-9">
                    <form method="get" class="form-inline" id="form-search">
                        <div class="form-group mb-2 mr-1">
                            <label for="search" class="sr-only">@lang('tadcms::app.search')</label>
                            <input name="search" type="text" id="search" class="form-control" placeholder="@lang('tadcms::app.search')" autocomplete="off">
                        </div>

                        <div class="form-group w-25 mb-2 mr-1">
                            <label for="status" class="sr-only">@lang('tadcms::app.status')</label>
                            <select name="status" id="status" class="form-control">
                                <option value="">@lang('tadcms::app.all-status')</option>
                                <option value="1">@lang('tadcms::app.enabled')</option>
                                <option value="0">@lang('tadcms::app.disabled')</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary mb-2">@lang('tadcms::app.search')</button>
                    </form>
                </div>
            </div>

            <div class="table-responsive mb-5">
                <table class="table tad-table">
                    <thead>
                    <tr>
                        <th data-width="3%" data-field="state" data-checkbox="true"></th>
                        <th data-field="name" data-formatter="name_formatter" data-sortable="true">@lang('tadcms::app.name')</th>
                        <th data-width="15%" data-field="created" data-sortable="true">@lang('tadcms::app.created-at')</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>



    <script type="text/javascript">
        function name_formatter(value, row, index) {
            return '<a href="'+ row.edit_url +'">'+ value +'</a>';
        }

        var table = new TadTable({
            url: '{{ route('admin.taxonomy.get-data', [$type, $taxonomy]) }}',
            action_url: '{{ route('admin.taxonomy.bulk-actions', [$type, $taxonomy]) }}',
        });
    </script>
@endsection
