@extends('tadcms::layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-6"></div>
        <div class="col-md-6">
            <div class="btn-group float-right">
                <a href="{{ route('admin.notification.create') }}" class="btn btn-success"><i class="fa fa-plus-circle"></i> @lang('tadcms::app.add-new')</a>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-4">
            <form method="post" class="form-inline">
                <select name="bulk_actions" class="form-control w-60 mb-2 mr-1">
                    <option value="">@lang('tadcms::app.bulk-actions')</option>
                    <option value="send">@lang('tadcms::app.send')</option>
                    <option value="delete">@lang('tadcms::app.delete')</option>
                </select>

                <button type="submit" class="btn btn-primary mb-2" id="apply-action">@lang('tadcms::app.apply')</button>
            </form>
        </div>

        <div class="col-md-8">
            <form method="get" class="form-inline" id="form-search">
                <div class="form-group mb-2 mr-1">
                    <label for="search" class="sr-only">@lang('tadcms::app.search')</label>
                    <input name="search" type="text" id="search" class="form-control" placeholder="@lang('tadcms::app.search')" autocomplete="off">
                </div>

                <div class="form-group mb-2 mr-1">
                    <label for="status" class="sr-only">@lang('tadcms::app.status')</label>
                    <select name="status" id="status" class="form-control">
                        <option value="">--- @lang('tadcms::app.status') ---</option>
                        <option value="1">@lang('tadcms::app.enabled')</option>
                        <option value="0">@lang('tadcms::app.disabled')</option>
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
                    <th data-field="subject" data-formatter="subject_formatter">@lang('tadcms::app.subject')</th>
                    <th data-field="method" data-width="20%" data-formatter="via_formatter">@lang('tadcms::app.via')</th>
                    <th data-field="created" data-width="15%">@lang('tadcms::app.created-at')</th>
                    <th data-field="error" data-width="15%">@lang('tadcms::app.error')</th>
                    <th data-field="status" data-width="15%" data-align="center" data-formatter="status_formatter">@lang('tadcms::app.status')</th>
                </tr>
            </thead>
        </table>
    </div>

    <script type="text/javascript">
        function via_formatter(value, row, index) {
            if (row.method) {
                return row.method;
            }

            return "{{ trans('tadcms::app.all') }}";
        }

        function subject_formatter(value, row, index) {
            return '<a href="'+ row.edit_url +'">'+ row.data.subject +'</a>';
        }

        function status_formatter(value, row, index) {
            let status = parseInt(value);

            switch (status) {
                case 0: return "{{ trans('tadcms::app.error') }}";
                case 1: return "{{ trans('tadcms::app.sended') }}";
                case 2: return "{{ trans('tadcms::app.pending') }}";
                case 3: return "{{ trans('tadcms::app.sending') }}";
                case 4: return "{{ trans('tadcms::app.unsent') }}";
            }
        }

        var table = new TadTable({
            url: '{{ route('admin.notification.get-data') }}',
            action_url: '{{ route('admin.notification.bulk-actions') }}',
        });
    </script>
@endsection