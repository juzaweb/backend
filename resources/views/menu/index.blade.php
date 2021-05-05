@extends('tadcms::layouts.admin')

@section('content')
    <div class="row alert alert-light p-3 no-radius">
        <div class="col-md-6 form-select-menu">
            <div class="alert-default">
                @lang('tadcms::app.select-menu-to-edit'):
                <select name="id" class="w-25 form-control load-menus">
                    @if(isset($menu->id))
                        <option value="{{ $menu->id }}" selected>{{ $menu->name }}</option>
                    @endif
                </select>

                @lang('tadcms::app.or') <a href="javascript:void(0)" class="ml-1 btn-add-menu"><i class="fa fa-plus"></i> {{ trans('tadcms::app.create-new-menu') }}</a>
            </div>
        </div>

        <div class="col-md-6 form-add-menu box-hidden">
            <form action="{{ route('admin.menu.save') }}" method="post" class="form-ajax form-inline">
                <div class="form-group">
                    <input type="text" name="name" class="form-control" autocomplete="off" required placeholder="{{ trans('tadcms::app.menu-name') }}">
                </div>

                <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> {{ trans('tadcms::app.add-menu') }}</button>
            </form>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-4">
            <h5 class="mb-2 font-weight-bold">@lang('tadcms::app.add-menu-items')</h5>
            @php
            $index = 1;
            @endphp
            @foreach($menuBlocks as $key => $menuBlock)
                @component('tadcms::items.menu_block', [
                    'menuBlock' => $menuBlock,
                    'key' => $key,
                    'hidden' => ($index == 1 ? false : true)
                ])
                @endcomponent

                @php
                    $index += 1;
                @endphp
            @endforeach

        </div>

        <div class="col-md-8">
            <h5 class="mb-2 font-weight-bold">@lang('tadcms::app.menu-structure')</h5>

            <form action="{{ route('admin.menu.save') }}" method="post" class="form-ajax form-menu-structure">
                <input type="hidden" name="id" value="{{ $menu->id ?? '' }}">
                <textarea name="content" id="items-output" class="form-control"></textarea>

                <div class="card">
                    <div class="card-header bg-light pb-1">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group row">
                                    <label for="name" class="col-sm-3">{{ trans('tadcms::app.menu-name') }}</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="name" id="name" class="form-control" value="{{ $menu->name ?? '' }}" autocomplete="off">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="btn-group float-right">
                                    <button type="submit" class="btn btn-primary" @if(empty($menu)) disabled @endif><i class="fa fa-save"></i> {{ trans('tadcms::app.save') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" id="form-menu">

                        <div class="dd" id="nestable">
                            <ol class="dd-list">

                            </ol>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="btn-group">
                            <a href="javascript:void(0)" class="text-danger">{{ trans('tadcms::app.delete-menu') }}</a>
                        </div>

                        <div class="btn-group float-right">
                            <button type="submit" class="btn btn-primary" @if(empty($menu)) disabled @endif><i class="fa fa-save"></i> {{ trans('tadcms::app.save') }}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {

            var updateOutput = function(e)
            {
                var list   = e.length ? e : $(e.target);
                if (window.JSON) {
                    $('#items-output').val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
                } else {
                    alert('JSON browser support required for this application.');
                }
            };

            $('#nestable').nestable({
                noDragClass: 'dd-nodrag'
            }).on('change', updateOutput);

            $('body').on('submit', '.form-menu-block', function(event) {
                if (event.isDefaultPrevented()) {
                    return false;
                }

                event.preventDefault();
                var form = $(this);
                var formData = new FormData(form[0]);
                var btnsubmit = form.find("button[type=submit]");
                var currentIcon = btnsubmit.find('i').attr('class');

                btnsubmit.find('i').attr('class', 'fa fa-spinner fa-spin');
                btnsubmit.prop("disabled", true);

                $.ajax({
                    type: form.attr('method'),
                    url: form.attr('action'),
                    dataType: 'json',
                    data: formData,
                    cache:false,
                    contentType: false,
                    processData: false
                }).done(function(response) {

                    btnsubmit.find('i').attr('class', currentIcon);
                    btnsubmit.prop("disabled", false);

                    if (response.status === false) {
                        return false;
                    }

                    let items = response.data.items;
                    $.each(items, function (index, item) {
                        $('#nestable .dd-list').append(item);
                    });

                    updateOutput($('#nestable'));
                    form.find('.reset-after-add').val('');

                    return false;
                }).fail(function(response) {
                    btnsubmit.find('i').attr('class', currentIcon);
                    btnsubmit.prop("disabled", false);

                    show_message(response);
                    return false;
                });
            });

        });
    </script>

@endsection