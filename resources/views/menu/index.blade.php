@extends('tadcms::layouts.admin')

@section('content')

    @livewire('tadcms::menu.menu-index')

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

@endsection