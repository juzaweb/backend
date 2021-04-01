<div class="form-group">
    <label class="col-form-label" for="baseName">@lang('tadcms::app.name')</label>

    <input type="text" name="name" class="form-control" id="baseName" value="{{ $model->name }}" autocomplete="off" required>
</div>

<div class="form-group">
    <label class="col-form-label" for="description">@lang('tadcms::app.description')</label>
    <textarea class="form-control" name="description" id="description" rows="4">{{ $model->description }}</textarea>
</div>