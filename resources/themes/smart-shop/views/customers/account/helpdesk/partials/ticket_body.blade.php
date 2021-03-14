<div class="card mb-3">
    <div class="card-body row">
        <div class="col-md-6">
            <p><strong>{{ trans('shop::app.customer.account.helpdesk.owner') }}</strong>: 
                <span>{{ $customer->name }}</span>
            </p>
            <p>
                <strong>{{ trans('shop::app.customer.account.helpdesk.status') }}</strong>:
                @if( $ticket->isComplete() )
                    <span style="color: blue">Complete</span>
                @else
                    <span style="color: {{ $ticket->status->color }}">{{ $ticket->status->name }}</span>
                @endif

            </p>
            <p>
                <strong>{{ trans('shop::app.customer.account.helpdesk.priority') }}</strong>: 
                <span style="color: {{ $ticket->priority->color }}">
                    {{ $ticket->priority->name }}
                </span>
            </p>
        </div>
        <div class="col-md-6">
            <p>
                <strong>{{ trans('shop::app.customer.account.helpdesk.category') }}</strong>: 
                <span style="color: {{ $ticket->category->color }}">
                    {{ $ticket->category->name }}
                </span>
            </p>
            <p> <strong>{{ trans('shop::app.customer.account.helpdesk.created') }}</strong>: {{ $ticket->created_at->diffForHumans() }}</p>
            <p> <strong>{{ trans('shop::app.customer.account.helpdesk.last-update') }}</strong>: {{ $ticket->updated_at->diffForHumans() }}</p>
        </div>
        <div class="col-md-6">
            <p>
                <strong>{{ trans('shop::app.customer.account.helpdesk.description') }}</strong>: 
                <span>
                    {{ $ticket->content }}
                </span>
            </p>
        </div>
    </div>
</div>