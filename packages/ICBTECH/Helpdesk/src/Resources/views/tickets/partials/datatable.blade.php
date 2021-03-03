<table class="ticketit-table table table-striped  dt-responsive nowrap" style="width:100%">
    <thead>
        <tr>
            <td>{{ trans('helpdesk::lang.table-id') }}</td>
            <td>{{ trans('helpdesk::lang.table-subject') }}</td>
            <td>{{ trans('helpdesk::lang.table-status') }}</td>
            <td>{{ trans('helpdesk::lang.table-last-updated') }}</td>
            <td>{{ trans('helpdesk::lang.table-agent') }}</td>
          @if( $u->isAgent() || $u->isAdmin() )
            <td>{{ trans('helpdesk::lang.table-priority') }}</td>
            <td>{{ trans('helpdesk::lang.table-owner') }}</td>
            <td>{{ trans('helpdesk::lang.table-category') }}</td>
          @endif
        </tr>
    </thead>
</table>