@extends('tadcms::layouts.admin')

@section('content')
    <div class="row mb-2">
        <div class="col-md-6">
            @foreach($fileTypes as $key => $type)
                <a href="{{ route('admin.media.type', [$key]) }}" class="btn btn-primary w-25 @if($fileType == $key) disabled @endif">{{ strtoupper($key) }}</a>
            @endforeach
        </div>

        <div class="col-md-6">
            <div class="btn-group float-right">
                <a href="javascript:void(0)" class="btn btn-success" data-toggle="modal" data-target="#add-folder-modal"><i class="fa fa-plus"></i> @lang('tadcms::app.add-folder')</a>
                <a href="javascript:void(0)" class="btn btn-success" data-toggle="modal" data-target="#upload-modal"><i class="fa fa-cloud-upload"></i> @lang('tadcms::app.upload')</a>
            </div>
        </div>
    </div>

    <div class="list-media mt-5">
        @livewire('tadcms::media.media-list', ['type' => $fileType, 'folderId' => $folderId])
    </div>
@endsection

@section('footer')
    <div class="modal fade" id="add-folder-modal" tabindex="-1" role="dialog" aria-labelledby="add-folder-modal-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('admin.media.add-folder') }}" method="post" class="form-ajax">
                <input type="hidden" name="redirect" value="/{{ request()->path() }}">
                
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="add-folder-modal-label">@lang('tadcms::app.add-folder')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('tadcms::app.close') }}">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @component('tadcms::components.form_input', [
                            'label' => trans('tadcms::app.folder-name'),
                            'name' => 'name'
                        ])
                        @endcomponent

                        <input type="hidden" name="type" value="{{ $fileType }}">
                        <input type="hidden" name="parent_id" value="{{ $folderId }}">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> @lang('tadcms::app.close')</button>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('tadcms::app.add-folder')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="upload-modal" tabindex="-1" role="dialog" aria-labelledby="upload-modal-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="upload-modal-label">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group" id="attachment">
                        <div class="controls text-center">
                            <div class="text-center">
                                <a href="javascript:void(0)" class="btn btn-primary rounded-0" id="upload-button"><i class="fa
                                fa-cloud-upload"></i> {{ trans('filemanager::file-manager.message-choose') }}
                                </a>
                            </div>
                        </div>
                    </div>

                    <input type='hidden' name='working_dir' id='working_dir'>
                    <input type='hidden' name='previous_dir' id='previous_dir'>
                    <input type='hidden' name='type' id='type' value='{{ $fileType }}'>
                    <input type='hidden' name='_token' value='{{ csrf_token() }}'>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> @lang('tadcms::app.close')</button>
                </div>
            </div>
        </div>
    </div>
@endsection