@extends('tadcms::backend.layout')

@section('content')

    <div class="row">
        <div class="col-md-6"></div>

        <div class="col-md-6">
            <div class="float-right">
                <div class="btn-group">
                    <button type="button" class="btn btn-success sync-language"><i class="fa fa-refresh"></i> @lang('tadcms::app.sync_language')</button>
                </div>

                <div class="btn-group">
                    <a href="javascript:void(0)" class="btn btn-success" data-toggle="modal" data-target="#addModal"><i class="fa fa-plus-circle"></i> @lang('tadcms::app.add-new')</a>
                </div>

            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-12">
            <form method="get" class="form-inline" id="form-search">

                <div class="form-group mb-2 mr-1">
                    <label for="inputName" class="sr-only">@lang('tadcms::app.search')</label>
                    <input name="search" type="text" id="inputName" class="form-control" placeholder="@lang('tadcms::app.search')" autocomplete="off">
                </div>

                <div class="form-group mb-2 mr-1">
                    <label for="status" class="sr-only">@lang('tadcms::app.status')</label>
                    <select name="status" id="status" class="form-control">
                        <option value="1">@lang('tadcms::app.enabled')</option>
                        <option value="0">@lang('tadcms::app.disabled')</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary mb-2">
                    <i class="fa fa-search"></i> @lang('tadcms::app.search')
                </button>
            </form>
        </div>

    </div>

    <div class="table-responsive mb-5">
        <table class="table tad-table">
            <thead>
                <tr>
                    <th data-width="3%" data-field="state" data-checkbox="true"></th>
                    <th data-width="10%" data-field="key">@lang('tadcms::app.code')</th>
                    <th data-field="name">@lang('tadcms::app.name')</th>
                    <th data-field="status" data-width="15%" data-align="center" data-formatter="status_formatter">@lang('tadcms::app.status')</th>
                    <th data-field="default" data-width="5%" data-formatter="default_formatter">@lang('tadcms::app.default')</th>
                    <th data-width="20%" data-field="options" data-formatter="options_formatter" data-align="center">@lang('tadcms::app.options')</th>
                </tr>
            </thead>
        </table>
    </div>

    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('admin.languages.save') }}" method="post" class="form-ajax">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">@lang('tadcms::app.add_language')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-form-label" for="name">@lang('tadcms::app.name')</label>

                            <input type="text" name="name" class="form-control" id="name" value="" autocomplete="off" required placeholder="Ex: English, French">
                        </div>

                        <div class="form-group">
                            <label class="col-form-label" for="key">@lang('tadcms::app.code')</label>

                            <input type="text" name="key" class="form-control" id="key" autocomplete="off" required placeholder="Ex: en, fe">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> @lang('tadcms::app.save')</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-close"></i> @lang('tadcms::app.close')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript">

        function status_formatter(value, row, index) {
            if (value == 1) {
                return '<span class="text-success">'+ langs.enabled +'</span>';
            }
            return '<span class="text-danger">'+ langs.disabled +'</span>';
        }

        function default_formatter(value, row, index) {
            let checked = value == 1 ? true : false;
            return '<input type="radio" name="default" value="'+ row.id +'" class="form-control set-default" '+ (checked ? 'checked' : '') +'>';
        }

        function options_formatter(value, row, index) {
            let result = '';
            result += '<a href="'+ row.tran_url +'" class="btn btn-success btn-sm"><i class="fa fa-edit"></i> '+ langs.translate +'</a>';
            return result;
        }

        var table = new TadTable({
            url: '{{ route('admin.languages.get-data') }}',
            action_url: '{{ route('admin.languages.bulk-actions') }}',
        });

        $('.sync-language').on('click', function () {
            let btn = $(this);
            let cIcon = btn.find('i').attr('class');
            btn.find('i').attr('class', 'fa fa-spinner fa-spin');
            btn.prop("disabled", true);

            $.ajax({
                type: 'POST',
                url: '{{ route('admin.languages.sync') }}',
                dataType: 'json',
                data: {}
            }).done(function(data) {

                show_message(data.message, data.status);
                btn.find('i').attr('class', cIcon);
                btn.prop("disabled", false);

                return false;
            }).fail(function(data) {
                show_message(langs.data_error, 'error');
                btn.find('i').attr('class', cIcon);
                btn.prop("disabled", false);
                return false;
            });
        });

        $('.table').on('change', '.set-default', function () {
            let id = $(this).val();
            $.ajax({
                type: 'POST',
                url: '{{ route('admin.languages.default') }}',
                dataType: 'json',
                data: {
                    'id': id,
                }
            }).done(function(data) {

                if (data.status === "error") {
                    show_message(data.message, 'error');
                    return false;
                }

                return false;
            }).fail(function(data) {
                show_message(langs.data_error, 'error');
                return false;
            });
        });

    </script>
@endsection