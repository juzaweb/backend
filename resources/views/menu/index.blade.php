@extends('tadcms::layouts.admin')

@section('content')

    @livewire('tadcms::menu.menu-index')

    <div class="row alert alert-light p-3 no-radius">
        <div class="col-md-6">
            <div class="alert-default">
                Select a menu to edit:
                <select name="id" class="w-25">
                    @if(isset($menu->id))
                        <option value="{{ $menu->id }}" selected>{{ $menu->name }}</option>
                    @endif
                </select>

                or <a href="javascript:void(0)" class="ml-1"><i class="fa fa-plus"></i> {{ trans('tadcms::app.create-new-menu') }}</a>
            </div>
        </div>

        <div class="col-md-6 box-hidden">
            <form action="{{ route('admin.menu.add') }}" method="post" class="form-ajax form-inline">
                <div class="form-group">
                    <input type="text" name="name" class="form-control" autocomplete="off" required placeholder="{{ trans('tadcms::app.menu-name') }}">
                </div>

                <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> {{ trans('tadcms::app.add-menu') }}</button>
            </form>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-4" wire:init="loadItems">
            <h5 class="mb-2 font-weight-bold">Add menu items</h5>
        </div>

        <div class="col-md-8">
            <h5 class="mb-2 font-weight-bold">Menu structure</h5>

            <form action="{{ route('admin.menu.save') }}" method="post" class="form-ajax">
                <input type="hidden" name="id" value="{{ @$menu->id }}">

                <div class="card">
                    <div class="card-header bg-light">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group row">
                                    <label for="name" class="col-sm-3">{{ trans('tadcms::app.menu-name') }}</label>
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
                            <ol class="dd-list">
                                <li class="dd-item dd3-item" data-id="13">
                                    <div class="dd-handle dd3-handle"></div>
                                    <div class="dd3-content">Level 1</div>
                                </li>
                                <li class="dd-item dd3-item" data-id="14">
                                    <div class="dd-handle dd3-handle"></div>
                                    <div class="dd3-content">Level 1</div>
                                </li>
                                <li class="dd-item dd3-item" data-id="15">
                                    <div class="dd-handle dd3-handle"></div>
                                    <div class="dd3-content">Level 1</div>
                                    <ol class="dd-list">
                                        <li class="dd-item dd3-item" data-id="16">
                                            <div class="dd-handle dd3-handle"></div>
                                            <div class="dd3-content">Level 2</div>
                                        </li>
                                        <li class="dd-item dd3-item" data-id="17">
                                            <div class="dd-handle dd3-handle"></div>
                                            <div class="dd3-content">Level 2</div>
                                        </li>
                                        <li class="dd-item dd3-item" data-id="18">
                                            <div class="dd-handle dd3-handle"></div>
                                            <div class="dd3-content">Level 2</div>
                                        </li>
                                    </ol>
                                </li>
                            </ol>
                        </div>

                        <textarea name="content" id="nestable-output" class="form-control"></textarea>
                    </div>

                    <div class="card-footer">
                        <div class="btn-group">
                            <a href="javascript:void(0)" class="text-danger" wire:click="deleteMenu">{{ trans('tadcms::app.delete-menu') }}</a>
                        </div>

                        <div class="btn-group float-right">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{ trans('tadcms::app.save') }}</button>
                        </div>
                    </div>
                </div>
            </form>
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

    <script type="text/javascript">
        $(document).ready(function() {

            var updateOutput = function(e)
            {
                var list   = e.length ? e : $(e.target);
                if (window.JSON) {
                    $('#nestable-output').val(window.JSON.stringify(list.nestable('serialize')));
                } else {
                    console.log('JSON browser support required for this demo.');
                }
            };

            $('#nestable').nestable({
                group: 1
            }).on('change', updateOutput);

        });
    </script>

@endsection