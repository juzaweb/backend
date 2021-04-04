<div class="form-group">
    <label for="{{ $name }}">{{ $title }}</label>
    <textarea type="text" name="{{ $name }}" class="form-control" id="{{ $name }}" rows="3">{{ get_config($name) }}</textarea>
</div>