<div class="cui__topbar">
    <div class="mr-4">
        <a href="{{ url('/') }}" class="mr-2" target="_blank">
            <i class="dropdown-toggle-icon fa fa-home" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Visit website"></i> Visit Site
        </a>
    </div>

    <div class="mr-auto">
        <div class="dropdown mr-4 d-none d-sm-block">
            <a href="javascript:void(0)" class="dropdown-toggle text-nowrap" data-toggle="dropdown">
                <i class="fa fa-plus"></i>
                <span class="dropdown-toggle-text"> New</span>
            </a>

            <div class="dropdown-menu" role="menu">
                {{--<a class="dropdown-item" href="{{ route('admin.post-type.create', ['posts']) }}">Post</a>
                <a class="dropdown-item" href="{{ route('admin.post-type.create', ['pages']) }}">Page</a>--}}
                <a class="dropdown-item" href="{{ route('admin.users.create') }}">User</a>
            </div>
        </div>
    </div>

    <div class="dropdown mr-4 d-none d-sm-block">
        <a href="" class="dropdown-toggle text-nowrap" data-toggle="dropdown" data-offset="5,15">
            <span class="dropdown-toggle-text">EN</span>
        </a>
        <div class="dropdown-menu dropdown-menu-right" role="menu">
            <a class="dropdown-item " href="javascript:void(0)"><span class="text-uppercase font-size-12 mr-1">EN</span>
                English</a>
        </div>
    </div>

    <div class="cui__topbar__actionsDropdown dropdown mr-4 d-none d-sm-block">
        <a href="javascript:void(0)" class="dropdown-toggle text-nowrap" data-toggle="dropdown" aria-expanded="false" data-offset="0,15">
            <i class="dropdown-toggle-icon fa fa-bell-o"></i>
        </a>

        <div class="cui__topbar__actionsDropdownMenu dropdown-menu dropdown-menu-right" role="menu">
            <div style="width: 350px;">
                <div class="card-body">
                    <div class="tab-content">
                        <div class="height-300 kit__customScroll">
                            <ul class="list-unstyled">
                                {{--@php
                                    $notifications = Auth::user()->unreadNotifications()
                                        ->orderBy('id', 'DESC')
                                        ->limit(5)
                                        ->get(['id', 'data']);
                                @endphp

                                @if($notifications->isEmpty())
                                    <p>@lang('tadcms::app.no_notifications')</p>
                                @else
                                    @foreach($notifications as $notification)
                                        <li class="mb-3">
                                            <div class="d-flex align-items-baseline alert alert-info">
                                                <p class="kit__l2__title">
                                                    <a href="{{ route('account.notification.detail', [$notification->id]) }}" data-turbolinks="false">{{ $notification->data['subject'] }}</a>
                                                </p>
                                            </div>
                                        </li>
                                    @endforeach
                                @endif--}}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="dropdown">
        <a href="" class="dropdown-toggle text-nowrap" data-toggle="dropdown" aria-expanded="false" data-offset="5,15">
            <img class="dropdown-toggle-avatar" src="{{ Auth::user()->getAvatar() }}" alt="User avatar" width="30" height="30"/>
        </a>

        <div class="dropdown-menu dropdown-menu-right" role="menu">
            <a href="{{ route('admin.users.edit', [Auth::id()]) }}" class="dropdown-item">
                <i class="dropdown-icon fe fe-user"></i>
                @lang('tadcms::app.profile')
            </a>

            <div class="dropdown-divider"></div>
            <a href="{{ route('auth.logout') }}" class="dropdown-item" data-turbolinks="false">
                <i class="dropdown-icon fe fe-log-out"></i> @lang('tadcms::app.logout')
            </a>
        </div>
    </div>
</div>