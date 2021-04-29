<li class="dd-item" data-id="1" data-text="{{ $text }}">
    <div class="dd-handle">
        {{ $text }}
        <a href="javascript:void(0)" class="dd-nodrag show-menu-edit">
            <i class="fa fa-sort-down"></i>
        </a>
    </div>

    <div class="form-item-edit box-hidden">
        <div class="form-group mb-0">
            <label class=" mb-0">Text</label>
            <input type="text" class="form-control" value="{{ $text }}">
        </div>

        <div class="form-group mb-0">
            <label class=" mb-0">Url</label>
            <input type="text" class="form-control" value="http://">
        </div>

        <a href="" class="text-danger">Delete</a>
        <a href="" class="text-info">Cancel</a>
    </div>
</li>