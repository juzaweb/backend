@extends('tadcms::layouts.auth')

@section('content')
    <div class="cui__layout__content">
        <div class="cui__utils__content">
            <div class="cui__auth__authContainer">

                <div class="cui__auth__containerInner">
                    <div class="text-center mb-5">
                        <h1 class="mb-5 px-3">
                            <strong>@lang('tadcms::message.login-form.welcome', ['name' => get_config('sitename', 'TAD CMS')])</strong>
                        </h1>

                        <p class="mb-4">
                            @lang('tadcms::message.login-form.description')
                        </p>
                    </div>

                    <div class="card cui__auth__boxContainer">
                        <div class="text-dark font-size-24 mb-4">
                            <strong>@lang('tadcms::message.login-form.header')</strong>
                        </div>

                        <form action="{{ route('auth.login.handle') }}" method="post" class="mb-4 form-ajax">
                            <input type="hidden" name="redirect" value="{{ route('admin.dashboard') }}">

                            <div class="form-group mb-4">
                                <input type="email" name="email" class="form-control" placeholder="@lang('tadcms::app.email-address')" />
                            </div>

                            <div class="form-group mb-4">
                                <input type="password" name="password" class="form-control" placeholder="Password" />
                            </div>

                            <button type="submit" class="btn btn-primary text-center w-100" data-loading-text="@lang('tadcms::app.please-wait')"><i class="fa fa-sign-in"></i> @lang('tadcms::app.log-in')</button>
                        </form>

                        <a href="" class="kit__utils__link font-size-16">
                            @lang('tadcms::app.forgot-password')
                        </a>
                    </div>

                    <div class="text-center pt-2 mb-auto">
                        <span class="mr-2">@lang('tadcms::message.login-form.dont-have-an-account')</span>
                        <a href="{{ route('auth.register') }}" class="kit__utils__link font-size-16">
                            @lang('tadcms::app.sign-up')
                        </a>
                    </div>
                </div>

                <div class="mt-auto pb-5 pt-5">
                    <div class="text-center">
                        Copyright © {{ date('Y') }} {{ get_config('sitename') }} - Provided by TAD CMS
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection