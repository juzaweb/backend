@extends('tadcms::layouts.admin')

@section('content')

    <form method="post" action="{{ route('admin.taxonomy.save', [$type, $taxonomy]) }}" class="form-ajax">

        <div class="row">
            <div class="col-md-6"></div>

            <div class="col-md-6">
                <div class="btn-group float-right">
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> @lang('tadcms::app.save')</button>

                    <a href="{{ route('admin.taxonomy', [$type, $taxonomy]) }}" class="btn btn-warning"><i class="fa fa-times-circle"></i> @lang('tadcms::app.cancel')</a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                @include('tadcms::category.form-input')

                @include('tadcms::category.form-image')
            </div>
        </div>

        <input type="hidden" name="id" value="{{ $model->id }}">

    </form>

@endsection