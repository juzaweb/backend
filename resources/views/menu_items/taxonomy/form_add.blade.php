<div class="card card-menu-items">
    <div class="card-header card-header-flex">
        <div class="d-flex flex-column justify-content-center">
            <h5 class="mb-0">{{ $title }}</h5>
        </div>

        <div class="ml-auto d-flex align-items-stretch">
            <a href="javascript:void(0)" class="card-menu-show"><i class="fa fa-sort-down"></i></a>
        </div>
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
    </div>
</div>