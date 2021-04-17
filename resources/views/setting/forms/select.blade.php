<div class="form-group">
    @php
    $config = get_config($name);
    @endphp
    <label class="col-form-label" for="{{ $name }}">{{ $title }}</label>
    <select name="{{ $name }}" id="{{ $name }}" class="form-control select2">
        @foreach($options as $key => $option)
        <option value="{{ $key }}" @if($key == $config) selected @endif>{{ $option }}</option>
        @endforeach
    </select>
</div>