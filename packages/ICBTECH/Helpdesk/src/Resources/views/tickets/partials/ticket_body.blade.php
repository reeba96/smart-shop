<div class="card mb-3">
    <div class="card-body row">
        <div class="col-md-6">
            <p><strong>{{ trans('helpdesk::lang.owner') }}</strong>{{ trans('helpdesk::lang.colon') }}{{ $ticket->user_id == $u->id ? $u->name : $ticket->user->name }}</p>
            <p>
                <strong>{{ trans('helpdesk::lang.status') }}</strong>{{ trans('helpdesk::lang.colon') }}
                @if( $ticket->isComplete() && ! $setting->grab('default_close_status_id') )
                    <span style="color: blue">Complete</span>
                @else
                    <span style="color: {{ $ticket->status->color }}">{{ $ticket->status->name }}</span>
                @endif

            </p>
            <p>
                <strong>{{ trans('helpdesk::lang.priority') }}</strong>{{ trans('helpdesk::lang.colon') }}
                <span style="color: {{ $ticket->priority->color }}">
                    {{ $ticket->priority->name }}
                </span>
            </p>
        </div>
        <div class="col-md-6">
            <p> <strong>{{ trans('helpdesk::lang.responsible') }}</strong>{{ trans('helpdesk::lang.colon') }}{{ $ticket->agent_id == $u->id ? $u->name : $ticket->agent->name }}</p>
            <p>
                <strong>{{ trans('helpdesk::lang.category') }}</strong>{{ trans('helpdesk::lang.colon') }}
                <span style="color: {{ $ticket->category->color }}">
                    {{ $ticket->category->name }}
                </span>
            </p>
            <p> <strong>{{ trans('helpdesk::lang.created') }}</strong>{{ trans('helpdesk::lang.colon') }}{{ $ticket->created_at->diffForHumans() }}</p>
            <p> <strong>{{ trans('helpdesk::lang.last-update') }}</strong>{{ trans('helpdesk::lang.colon') }}{{ $ticket->updated_at->diffForHumans() }}</p>
        </div>
    </div>
</div>

{!! $ticket->html !!}

{!! CollectiveForm::open([
                'method' => 'DELETE',
                'route' => [
                            $setting->grab('main_route').'.destroy',
                            $ticket->id
                            ],
                'id' => "delete-ticket-$ticket->id"
                ])
!!}
{!! CollectiveForm::close() !!}


@if($u->isAgent() || $u->isAdmin())
    @include('helpdesk::tickets.edit')
@endif

{{-- // OR; Modal Window: 2/2 --}}
@if($u->isAdmin())
    @include('helpdesk::tickets.partials.modal-delete-confirm')
@endif
{{-- // END Modal Window: 2/2 --}}
