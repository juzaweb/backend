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

            <div class="card">
                <div class="card-header bg-light pb-1">
                    <h6 class="card-title"> {{ trans('tadcms::app.categories') }}</h6>
                </div>

                <div class="card-body">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" href="javascript: void(0);" data-toggle="tab">Most Used</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="tab">View All</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="javascript:void(0);" data-toggle="tab">Search</a>
                        </li>
                    </ul>

                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade p-2 active show" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                            <div class="form-check mt-1">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" value="">
                                    Option two is checked now
                                </label>
                            </div>
                            <div class="form-check mt-1">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" value="">
                                    Option two is checked now
                                </label>
                            </div>
                            <div class="form-check mt-1">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" value="">
                                    Option two is checked now
                                </label>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="checkbox" value="">
                                            Select all
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <button class="btn btn-primary">Add to menu</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <h5 class="mb-2 font-weight-bold">@lang('tadcms::app.menu-structure')</h5>

            <form action="{{ route('admin.menu.save') }}" method="post" class="form-ajax form-menu-structure">
                <input type="hidden" name="id" value="{{ $menu->id ?? '' }}">

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
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{ trans('tadcms::app.save') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" id="form-menu">

                        <div class="dd" id="nestable">
                            <ol class="dd-list">
                                <li class="dd-item" data-id="1">
                                    <div class="dd-handle">
                                        Level 1
                                        <a href="javascript:void(0)" class="dd-nodrag"><i class="fa fa-sort-down"></i></a>
                                    </div>
                                </li>
                                <li class="dd-item" data-id="2">
                                    <div class="dd-handle">Level 1</div>
                                    <ol class="dd-list">
                                        <li class="dd-item" data-id="3">
                                            <div class="dd-handle">Level 2</div>
                                        </li>
                                        <li class="dd-item" data-id="4">
                                            <div class="dd-handle">Level 2</div>
                                        </li>
                                        <li class="dd-item" data-id="5">
                                            <div class="dd-handle">Level 2</div>
                                            <ol class="dd-list">
                                                <li class="dd-item" data-id="6">
                                                    <div class="dd-handle">Level 3</div>
                                                </li>
                                                <li class="dd-item" data-id="7">
                                                    <div class="dd-handle">Level 3</div>
                                                </li>
                                                <li class="dd-item" data-id="8">
                                                    <div class="dd-handle">Level 3</div>
                                                </li>
                                            </ol>
                                        </li>
                                        <li class="dd-item" data-id="9">
                                            <div class="dd-handle">Level 2</div>
                                        </li>
                                        <li class="dd-item" data-id="10">
                                            <div class="dd-handle">Level 2</div>
                                        </li>
                                    </ol>
                                </li>
                                <li class="dd-item" data-id="11">
                                    <div class="dd-handle">Level 1</div>
                                </li>
                                <li class="dd-item" data-id="12">
                                    <div class="dd-handle">Level 1</div>
                                </li>
                            </ol>
                        </div>

                        <textarea name="content" id="nestable-output" class="form-control"></textarea>
                    </div>

                    <div class="card-footer">
                        <div class="btn-group">
                            <a href="javascript:void(0)" class="text-danger">{{ trans('tadcms::app.delete-menu') }}</a>
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
                group: 1,
                noDragClass: 'dd-nodrag'
            }).on('change', updateOutput);

        });
    </script>

@endsection