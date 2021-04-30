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

<div class="tab-content">
    <div class="tab-pane fade p-2 active show" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
        @foreach($items as $item)
            <div class="form-check mt-1">
                <label class="form-check-label">
                    <input class="form-check-input" type="checkbox" value="">
                    {{ $item->name }}
                </label>
            </div>
        @endforeach

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