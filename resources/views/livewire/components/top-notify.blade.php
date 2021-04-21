<div class="cui__topbar__actionsDropdownMenu dropdown-menu dropdown-menu-right" role="menu" wire:init="loadItems" xmlns:wire="http://www.w3.org/1999/xhtml">
        <div style="width: 350px;">
            <div class="card-body">
                <div class="tab-content">
                    <div class="kit__l1">
                        <div class="text-uppercase mb-2 text-gray-6 mb-2 font-weight-bold">@lang('tadcms::app.notifications') (3)</div>
                        <hr>
                        <ul class="list-unstyled">
                            @if(empty($items))
                                <p>@lang('tadcms::app.no-notifications')</p>
                            @else
                                @foreach($items as $notify)
                                    <li class="kit__l1__item">
                                        <a href="{{ @$notify->data['url'] }}" class="kit__l1__itemLink" data-turbolinks="false">
                                            <div class="kit__l1__itemPic mr-3">
                                                @if(empty($notify->data['image']))
                                                <i class="kit__l1__itemIcon fa fa-envelope-square"></i>
                                                @else
                                                    <img src="{{ upload_url($notify->data['image']) }}" alt="">
                                                @endif
                                            </div>
                                            <div>
                                                <div class="text-blue">{{ @$notify->data['subject'] }}</div>
                                                <div class="text-muted">{{ $notify->created_at ? $notify->created_at->diffForHumans() : '' }}</div>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
