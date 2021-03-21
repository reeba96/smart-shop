<div class="aside-nav">
    <ul>
        <li class="nav-link {{ Request::is('admin/predictionio/users*') ? 'active' : ''}}">
            <a href="{{ route('admin.predictionio.users') }}">{{ __('admin::app.predictionio.users') }}
                <span class="badge badge-pill badge-secondary ">
                    
                </span>
                {!! Request::is('admin/predictionio/users*') ? "<i class='angle-right-icon'></i>" : ""  !!}
            </a>
        </li>

        <li class="nav-link {{ Request::is('admin/predictionio/items*') ? 'active' : ''}}">
            <a href="{{ route('admin.predictionio.items') }}">{{ __('admin::app.predictionio.items') }}
                <span class="badge badge-pill badge-secondary ">
                    
                </span>
                {!! Request::is('admin/predictionio/items*') ? "<i class='angle-right-icon'></i>" : ""  !!}
            </a>
        </li>

        <li class="nav-link {{ Request::is('admin/predictionio/views*') ? 'active' : ''}}">
            <a href="{{ route('admin.predictionio.views') }}">{{ __('admin::app.predictionio.views') }}
                <span class="badge badge-pill badge-secondary ">
                    
                </span>
                {!! Request::is('admin/predictionio/views*') ? "<i class='angle-right-icon'></i>" : ""  !!}
            </a>
        </li>

        <li class="nav-link {{ Request::is('admin/predictionio/purchases*') ? 'active' : ''}}">
            <a href="{{ route('admin.predictionio.purchases') }}">{{ __('admin::app.predictionio.purchases') }}
                <span class="badge badge-pill badge-secondary ">
                    
                </span>
                {!! Request::is('admin/predictionio/purchases*') ? "<i class='angle-right-icon'></i>" : ""  !!}
            </a>
        </li>

        <li class="nav-link {{ Request::is('admin/predictionio/settings*') ? 'active' : ''}}">
            <a href="{{ route('admin.predictionio.settings') }}">{{ __('admin::app.predictionio.settings') }}
                <span class="badge badge-pill badge-secondary ">
                    
                </span>
                {!! Request::is('admin/predictionio/settings*') ? "<i class='angle-right-icon'></i>" : ""  !!}
            </a>
        </li>
    </ul>
</div>