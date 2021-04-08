<div xmlns:wire="http://www.w3.org/1999/xhtml">
    <div class="row mt-3">
        <div class="col-md-6">
            <div class="alert-default">
                Select a menu to edit:
                <select name="id" class="w-25">
                    @if(isset($menu->id))
                        <option value="{{ $menu->id }}" selected>{{ $menu->name }}</option>
                    @endif
                </select>

                or <a href="javascript:void(0)" class="ml-1" wire:click="showAddMenu"><i class="fa fa-plus"></i> {{ trans('tadcms::app.create-new-menu') }}</a>
            </div>
        </div>

        @if($showAddMenu)
        <div class="col-md-6">
            <form action="{{ route('admin.menu.add') }}" method="post" class="form-ajax form-inline">
                <div class="form-group">
                    <input type="text" name="name" class="form-control" autocomplete="off" required placeholder="{{ trans('tadcms::app.menu-name') }}">
                </div>

                <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> {{ trans('tadcms::app.add-menu') }}</button>
            </form>
        </div>
        @endif
    </div>


    <div class="row mt-3">
        <div class="col-md-5" wire:init="loadItems">
            <h5 class="mb-2 font-weight-bold">Add menu items</h5>

            @foreach($items as $item)
                @livewire('tadcms::menu.menu-item')
            @endforeach
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



                        <textarea name="content" id="nestable-output" class="form-control d-none"></textarea>
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
</div>

