@extends('tadcms::auth')

@section('content')
    <div class="cui__layout__content">

        <div class="cui__utils__content">
            <div class="cui__auth__authContainer">

                <div class="cui__auth__containerInner">
                    <div class="text-center mb-5">
                        <h1 class="mb-5 px-3">
                            <strong>Welcome to Clean UI Pro</strong>
                        </h1>

                        <p class="mb-4">
                            Pluggable enterprise-level application framework.
                            <br />
                            An excellent front-end solution for web applications built upon Ant Design.
                        </p>

                    </div>

                    <div class="card cui__auth__boxContainer">
                        <div class="text-dark font-size-24 mb-4">
                            <strong>Sign in to your account</strong>
                        </div>

                        <form action="{{ route('auth.login') }}" method="post" class="mb-4 form-ajax">
                            <input type="hidden" name="redirect" value="{{ route('admin.dashboard') }}">

                            <div class="form-group mb-4">
                                <input type="email" name="email" class="form-control" placeholder="Email Address" />
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
                        <span class="mr-2">@lang('tadcms::app.dont-have-an-account')</span>
                        <a href="" class="kit__utils__link font-size-16">
                            @lang('app.sign-up')
                        </a>
                    </div>
                </div>

                <div class="mt-auto pb-5 pt-5">
                    <ul class="cui__auth__footerNav list-unstyled d-flex mb-0 flex-wrap justify-content-center">
                        <li class="list-inline-item">
                            <a href="">Terms of Use</a>
                        </li>

                        <li class="list-inline-item">
                            <a href="">Compliance</a>
                        </li>

                        <li class="list-inline-item">
                            <a href="">Support</a>
                        </li>

                        <li class="list-inline-item">
                            <a href="">Contacts</a>
                        </li>
                    </ul>
                    <div class="text-center">
                        Copyright © 2021 TAD CMS |
                        <a href="" target="_blank" rel="noopener noreferrer">
                            Privacy Policy
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection