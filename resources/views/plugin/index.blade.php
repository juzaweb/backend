@extends('tadcms::layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-6"></div>

        <div class="col-md-6">
            {{--<div class="btn-group float-right">
                <a href="{{ route('admin.plugins.install') }}" class="btn btn-success"><i class="fa fa-plus-circle"></i> @lang('tadcms::app.add-new-plugin')</a>
            </div>--}}
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-md-3">
            <form method="post" class="form-inline">
                <select name="bulk_actions" class="form-control w-60 mb-2 mr-1">
                    <option value="">@lang('tadcms::app.bulk-actions')</option>
                    <option value="delete">@lang('tadcms::app.delete')</option>
                    <option value="activate">@lang('tadcms::app.activate')</option>
                    <option value="deactivate">@lang('tadcms::app.deactivate')</option>
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
                    <th data-field="name" data-formatter="nameFormatter">@lang('tadcms::app.name')</th>
                    <th data-field="description" data-width="25%">@lang('tadcms::app.description')</th>
                    <th data-width="15%" data-field="status" data-formatter="statusFormatter">@lang('tadcms::app.status')</th>
                </tr>
            </thead>
        </table>
    </div>

    <script type="text/javascript">
        function nameFormatter(value, row, index) {
            return value;
        }
        
        function statusFormatter(value, row, index) {
            switch (value) {
                case 'inactive': return "<span class='text-success'>{{ trans('tadcms::app.inactive') }}</span>";
            }

            return "<span class='text-success'>{{ trans('tadcms::app.active') }}</span>";
        }

        var table = new TadTable({
            url: '{{ route('admin.plugins.get-data') }}',
            action_url: '{{ route('admin.plugins.bulk-actions') }}',
        });
    </script>
@endsection