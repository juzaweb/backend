@extends('layouts.backend')

@section('title', $title)

@section('content')

{{ breadcrumb('admin', [
        'name' => trans('app.notification'),
        'url' => route('admin.notification')
    ]) }}

<div class="cui__utils__content">
    <form method="post" action="{{ route('admin.notification.save') }}" class="form-ajax">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="mb-0 card-title font-weight-bold">{{ $title }}</h5>
                    </div>

                    <div class="col-md-6">
                        <div class="btn-group float-right">
                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> @lang('app.save')</button>
                            <a href="{{ route('admin.notification') }}" class="btn btn-warning"><i class="fa fa-times-circle"></i> @lang('app.cancel')</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">

                <div class="row">
                    <div class="col-md-12">

                        <div class="form-group">
                            <label class="col-form-label" for="name">@lang('app.name') <span class="text-danger">*</span></label>

                            <input type="text" name="name" class="form-control" id="name" value="{{ $model->name }}" autocomplete="off" required>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label" for="users">@lang('app.send_for')</label>
                            <select name="users[]" id="users" class="form-control load-users" data-placeholder="--- @lang('app.users') ---" multiple>
                                @if($users)
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" selected>{{ $user->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <input type="checkbox" class="all-users"> @lang('tadcms::app.all-users')
                        </div>

                        <div class="form-group">
                            <label class="col-form-label" for="subject">@lang('app.subject') <span class="text-danger">*</span></label>
                            <input type="text" name="subject" class="form-control" id="subject" value="{{ $model->subject }}" autocomplete="off" required>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label" for="content">@lang('app.content') <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="content" id="content" rows="6">{{ $model->content }}</textarea>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label" for="subject">@lang('app.url')</label>
                            <input type="text" name="url" class="form-control" id="url" value="{{ $model->url }}" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label class="col-form-label" for="type">@lang('app.type')</label>

                            <select name="type" id="type" class="form-control" required>
                                <option value="1" @if($model->type == 1) selected @endif>@lang('app.notify')</option>
                                <option value="2" @if($model->type == 2) selected @endif>@lang('app.email')</option>
                                <option value="3" @if($model->type == 3) selected @endif>@lang('app.notify_and_email')</option>
                            </select>
                        </div>

                    </div>

                </div>

                <input type="hidden" name="id" value="{{ $model->id }}">
            </div>
        </div>
    </form>

    <script type="text/javascript">
        CKEDITOR.replace('content', {
            filebrowserImageBrowseUrl: '/admin-cp/filemanager?type=Images',
            filebrowserBrowseUrl: '/admin-cp/filemanager?type=Files'
        });

        $('.all-users').on('change', function () {
            if ($(this).is(':checked')) {
                $('#users').prop('disabled', true);
            }
            else {
                $('#users').prop('disabled', false);
            }
        });
    </script>
</div>
@endsection
