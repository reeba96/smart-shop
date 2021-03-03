<div class="aside-nav">
    <ul>
        <li class="{!! $tools->isUrlExtends(route('admin.helpdesk.index')) ? "active" : "" !!}">
            <a href="{{ route('admin.helpdesk.index') }}">{{ trans('helpdesk::lang.nav-active-tickets') }}
                <span class="badge badge-pill badge-secondary ">
                     <?php 
                        if ($u->isAdmin()) {
                            echo ICBTECH\Helpdesk\Models\Ticket::active()->count();
                        } elseif ($u->isAgent()) {
                            echo ICBTECH\Helpdesk\Models\Ticket::active()->agentUserTickets($u->id)->count();
                        } else {
                            echo ICBTECH\Helpdesk\Models\Ticket::userTickets($u->id)->active()->count();
                        }
                    ?>
                </span>
                {!! $tools->isUrlExtends(route('admin.helpdesk.index')) ? "<i class='angle-right-icon'></i>" : "" !!}
            </a>
        </li>

        <li class="{!! $tools->isUrlExtends(route('admin.helpdesk.index.complete')) ? "active" : "" !!}">
            <a href="{{ route('admin.helpdesk.index.complete') }}">{{ trans('helpdesk::lang.nav-completed-tickets') }}
               <span class="badge badge-pill badge-secondary">
                   <?php 
                       if ($u->isAdmin()) {
                           echo ICBTECH\Helpdesk\Models\Ticket::complete()->count();
                       } elseif ($u->isAgent()) {
                           echo ICBTECH\Helpdesk\Models\Ticket::complete()->agentUserTickets($u->id)->count();
                       } else {
                           echo ICBTECH\Helpdesk\Models\Ticket::userTickets($u->id)->complete()->count();
                       }
                   ?>
               </span>
               {!! $tools->isUrlExtends(route('admin.helpdesk.index.complete')) ? "<i class='angle-right-icon'></i>" : "" !!}
           </a>
        </li>

        <li class="{!! $tools->isUrlExtends(route('admin.helpdesk.status.index')) ? "active" : "" !!}">
            <a href="{{ route('admin.helpdesk.status.index') }}">{{ trans('helpdesk::admin.nav-statuses') }}
                <span class="badge badge-pill badge-secondary">
                    <?php 
                        if ($u->isAdmin()) {
                            echo ICBTECH\Helpdesk\Models\Ticket::complete()->count();
                        } elseif ($u->isAgent()) {
                            echo ICBTECH\Helpdesk\Models\Ticket::complete()->agentUserTickets($u->id)->count();
                        } else {
                            echo ICBTECH\Helpdesk\Models\Ticket::userTickets($u->id)->complete()->count();
                        }
                    ?>
                </span>
                {!! $tools->isUrlExtends(route('admin.helpdesk.status.index')) ? "<i class='angle-right-icon'></i>" : "" !!}
            </a>
        </li>

        <li class="{!! $tools->isUrlExtends(action('\ICBTECH\Helpdesk\Http\Controllers\PrioritiesController@index')) ? "active" : "" !!}">
            <a href="{{ route('admin.helpdesk.priority.index') }}">{{ trans('helpdesk::admin.nav-priorities') }}
                <span class="badge badge-pill badge-secondary">
                    <?php 
                        if ($u->isAdmin()) {
                            echo ICBTECH\Helpdesk\Models\Ticket::complete()->count();
                        } elseif ($u->isAgent()) {
                            echo ICBTECH\Helpdesk\Models\Ticket::complete()->agentUserTickets($u->id)->count();
                        } else {
                            echo ICBTECH\Helpdesk\Models\Ticket::userTickets($u->id)->complete()->count();
                        }
                    ?>
                </span>
                {!! $tools->isUrlExtends(route('admin.helpdesk.priority.index')) ? "<i class='angle-right-icon'></i>" : "" !!}
            </a>
        </li>

        <li class="{!! $tools->isUrlExtends(action('\ICBTECH\Helpdesk\Http\Controllers\CategoriesController@index')) ? "active" : "" !!}">
            <a href="{{ route('admin.helpdesk.category.index') }}">{{ trans('helpdesk::admin.nav-categories') }}
                <span class="badge badge-pill badge-secondary">
                    <?php 
                        if ($u->isAdmin()) {
                            echo ICBTECH\Helpdesk\Models\Ticket::complete()->count();
                        } elseif ($u->isAgent()) {
                            echo ICBTECH\Helpdesk\Models\Ticket::complete()->agentUserTickets($u->id)->count();
                        } else {
                            echo ICBTECH\Helpdesk\Models\Ticket::userTickets($u->id)->complete()->count();
                        }
                    ?>
                </span>
                {!! $tools->isUrlExtends(route('admin.helpdesk.category.index')) ? "<i class='angle-right-icon'></i>" : "" !!}
            </a>
        </li>

        <li class="{!! $tools->isUrlExtends(action('\ICBTECH\Helpdesk\Http\Controllers\ConfigurationsController@index')) ? "active" : "" !!}">
            <a href="{{ route('admin.helpdesk.configuration.index') }}">{{ trans('helpdesk::admin.nav-configuration') }}
                <span class="badge badge-pill badge-secondary">
                    <?php 
                        if ($u->isAdmin()) {
                            echo ICBTECH\Helpdesk\Models\Ticket::complete()->count();
                        } elseif ($u->isAgent()) {
                            echo ICBTECH\Helpdesk\Models\Ticket::complete()->agentUserTickets($u->id)->count();
                        } else {
                            echo ICBTECH\Helpdesk\Models\Ticket::userTickets($u->id)->complete()->count();
                        }
                    ?>
                </span>
                {!! $tools->isUrlExtends(route('admin.helpdesk.configuration.index')) ? "<i class='angle-right-icon'></i>" : "" !!}
            </a>
        </li>
    </ul>
</div>