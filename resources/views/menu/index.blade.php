@extends('tadcms::layouts.admin')

@section('title', $title)

@section('header')
    <script src="{{ asset('vendor/tadcms/js/menu-builder.js') }}"></script>
@endsection

@section('content')

    <div class="cui__utils__content">

        <h4 class="mb-0 font-weight-bold">{{ $title }}</h4>

        <div class="row mt-3">
            <div class="col-md-6">

                <div class="alert-default">
                    Select a menu to edit:
                    <select name="id" class="w-25 load-menu" data-placeholder="{{ trans('tadcms::app.choose_menu') }}">
                        @if(isset($menu->id))
                            <option value="{{ $menu->id }}" selected>{{ $menu->name }}</option>
                        @endif
                    </select>

                    or <a href="javascript:void(0)" class="ml-1" id="add-menu"><i class="fa fa-plus"></i> {{ trans('tadcms::app.create_new_menu') }}</a>
                </div>

            </div>

            <div class="col-md-6 form-menu-add box-hidden">
                <form action="{{ route('admin.menu.add') }}" method="post" class="form-ajax form-inline">
                    <div class="form-group">
                        <input type="text" name="name" class="form-control" autocomplete="off" required placeholder="{{ trans('tadcms::app.menu_name') }}">
                    </div>

                    <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> {{ trans('tadcms::app.add_menu') }}</button>
                </form>
            </div>

        </div>

        <div class="row mt-3">
            <div class="col-md-5">
                <h5 class="mb-2 font-weight-bold">Add menu items</h5>

                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="card-title"> {{ trans('tadcms::app.categories') }}</h5>
                    </div>

                    <div class="card-body">

                    </div>
                </div>
            </div>

            <div class="col-md-7">

                <h5 class="mb-2 font-weight-bold">Menu structure</h5>

                <form action="{{ route('admin.menu.save') }}" method="post" class="form-ajax">
                    <input type="hidden" name="id" value="{{ @$menu->id }}">

                    <div class="card">
                        <div class="card-header bg-light">
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label for="name" class="col-sm-3">{{ trans('tadcms::app.menu_name') }}</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="name" id="name" class="form-control" value="{{ @$menu->name }}" autocomplete="off">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="btn-group float-right">
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{ trans('tadcms::app.save') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body" id="form-menu">

                            <div class="dd" id="nestable">
                                <ol class="dd-list" id="dd-empty-placeholder"></ol>
                            </div>

                            <textarea name="content" id="nestable-output" class="form-control d-none"></textarea>
                        </div>

                        <div class="card-footer">
                            <div class="btn-group">
                                <a href="javascript:void(0)" class="text-danger delete-menu">{{ trans('tadcms::app.delete_menu') }}</a>
                            </div>

                            <div class="btn-group float-right">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{ trans('tadcms::app.save') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-edit-menu">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ trans('tadcms::app.add_menu') }}</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <input type='hidden' id='id' class='form-control' value="">
                <div class="modal-body">
                    <div class='form-group'>
                        <label class="form-label">{{ trans('tadcms::app.title') }}</label>
                        <input type='text' id='content' class='form-control' value="">
                    </div>

                    <div class='form-group'>
                        <label class="form-label">{{ trans('tadcms::app.url') }}</label>
                        <input type='text' id='url' class='form-control' value="">
                    </div>

                    <div class="form-group">
                        <label class="custom-switch">
                            <input type="checkbox" id="new_tab" class="custom-switch-input" value="1">
                            <span class="custom-switch-indicator"></span>
                            <span class="custom-switch-description"> {{ trans('tadcms::app.open_new_tab') }}</span>
                        </label>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary save-menu-item"><i class="fa fa-save"></i> {{ trans('tadcms::app.save') }}</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times-circle"></i> {{ trans('tadcms::app.close') }}</button>
                </div>
            </div>
        </div>
    </div>

    <template id="menu-item">
        <li class='dd-item' id="item-{id}" data-id="{id}" data-content="{content}" data-object_id="{object_id}" data-url="{url}" data-new_tab="{new_tab}" data-object_type="{object_type}">
            <div class='dd-handle'>{content}</div>
            <div class='float-right item-edit'>
                <a href='javascript:void(0)' class="edit-menu-item" title='{{ trans('tadcms::app.edit') }}'><i class='fa fa-edit'></i></a>
                <a href='javascript:void(0)' class='text-red remove-menu-item' title='{{ trans('tadcms::app.remove') }}'><i class='fa fa-times-circle'></i></a>
            </div>
            {children}
        </li>
    </template>

    <script type="text/javascript">
        var dataJson = '{!! isset($menu->content) ? $menu->content : '{}' !!}';
    </script>

    <script type="text/javascript" src="{{ asset('styles/js/add-menu.js') }}"></script>

@endsection