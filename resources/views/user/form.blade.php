@extends('tadcms::layouts.admin')

@section('content')

    @component('tadcms::components.form', [
        'method' => $model->id ? 'put' : 'post',
        'action' => $model->id ?
            route('admin.users.update', [$model->id]) :
            route('admin.users.store')
    ])
        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <label class="col-form-label" for="name">@lang('tadcms::app.name')</label>

                    <input type="text" name="name" class="form-control" id="name" value="{{ $model->name }}" autocomplete="off" required>
                </div>

                <div class="form-group">
                    <label class="col-form-label" for="email">@lang('tadcms::app.email')</label>
                    <input type="text" class="form-control" id="email" value="{{ $model->email }}" autocomplete="off" @if($model->id) disabled @else name="email" required @endif>
                </div>

                <div class="form-group">
                    <label class="col-form-label" for="is_admin">@lang('tadcms::app.permission')</label>
                    <select name="is_admin" id="is_admin" class="form-control" required>
                        <option value="0" @if($model->is_admin == 0) selected @endif>@lang('tadcms::app.user')</option>
                        <option value="1" @if($model->is_admin == 1) selected @endif>@lang('tadcms::app.admin')</option>
                    </select>
                </div>

                <hr>

                <div class="form-group">
                    <label class="col-form-label" for="password">@lang('tadcms::app.password')</label>
                    <input type="password" name="password" class="form-control" id="password" autocomplete="off" @if(empty($model->id)) required @endif>
                </div>

                <div class="form-group">
                    <label class="col-form-label" for="password_confirmation">@lang('tadcms::app.confirm-password')</label>
                    <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" autocomplete="off" @if(empty($model->id)) required @endif>
                </div>
            </div>

            <div class="col-md-1"></div>
            <div class="col-md-3">
                <div class="form-thumbnail text-center">
                    <input id="avatar" type="file" name="avatar" class="d-none" accept="image/jpeg,image/png,image/gif">
                    <div id="holder">
                        <img src="{{ $model->getAvatar() }}" class="w-100">
                    </div>

                    <a href="javascript:void(0)" class="btn btn-primary text-capitalize choose-avatar">
                        <i class="fa fa-picture-o"></i> @lang('tadcms::app.choose-avatar')
                    </a>
                </div>

                <div class="form-group">
                    <label class="col-form-label" for="status">@lang('tadcms::app.status')</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="active" @if($model->status == 'active') selected @endif>@lang('tadcms::app.active')</option>
                        <option value="inactive" @if($model->status == 'inactive') selected @endif>@lang('tadcms::app.inactive')</option>
                        <option value="trash" @if($model->status == 'trash') selected @endif>@lang('tadcms::app.trash')</option>
                    </select>
                </div>
            </div>

            <input type="hidden" name="id" value="{{ $model->id }}">
        </div>
    @endcomponent

    <script type="text/javascript">
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#holder img').attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#avatar").change(function() {
            readURL(this);
        });

        $('.choose-avatar').on('click', function () {
            $("#avatar").trigger('click');
        });
    </script>
@endsection
