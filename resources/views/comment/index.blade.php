@extends('tadcms::layouts.admin')

@section('content')

    <div class="row mb-2">
        <div class="col-md-12">
            <form method="get" class="form-inline" id="form-search">

                <div class="form-group mb-2 mr-1">
                    <label for="search" class="sr-only">@lang('tadcms::app.search')</label>
                    <input name="search" type="text" id="search" class="form-control" placeholder="@lang('tadcms::app.search')" autocomplete="off">
                </div>

                <div class="form-group mb-2 mr-1">
                    <label for="approve" class="sr-only">@lang('tadcms::app.approve')</label>
                    <select name="approve" id="approve" class="form-control">
                        <option value="">--- @lang('tadcms::app.approve') ---</option>
                        <option value="1">@lang('tadcms::app.approved')</option>
                        <option value="0">@lang('tadcms::app.deny')</option>
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
                <th data-field="author">@lang('tadcms::app.author')</th>
                <th data-width="30%" data-field="content">@lang('tadcms::app.content')</th>
                <th data-width="15%" data-field="post">@lang('tadcms::app.post')</th>
                <th data-width="15%" data-field="created">@lang('tadcms::app.created-at')</th>
                <th data-width="10%" data-field="approved" data-align="center" data-formatter="approve_formatter">@lang('tadcms::app.approve')</th>

            </tr>
            </thead>
        </table>
    </div>

    <script type="text/javascript">

        function approve_formatter(value, row, index) {
            if (value == 1) {
                return '<span class="text-success">@lang('tadcms::app.show')</span>';
            }
            return '<span class="text-danger">@lang('tadcms::app.hidden')</span>';
        }

        var table = new TadTable({
            url: '{{ route('admin.comments.get-data') }}',
            action_url: '{{ route('admin.comments.bulk-actions') }}',
        });
    </script>

@endsection