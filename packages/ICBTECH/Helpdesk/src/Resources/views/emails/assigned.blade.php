<?php // dd(unserialize($notification_owner)); ?>
<?php $notification_owner = unserialize($notification_owner);?>
<?php $ticket = unserialize($ticket);?>

@extends($email)

@section('subject')
	{{ trans('helpdesk::email/globals.assigned') }}
@stop

@section('link')
	<a style="color:#ffffff" href="{{ route('customer.helpdesk.show', $ticket->id) }}">
		{{ trans('helpdesk::email/globals.view-ticket') }}
	</a>
@stop

@section('content')
	{!! trans('helpdesk::email/assigned.data', [
		'name'      =>  $notification_owner->name,
		'subject'   =>  $ticket->subject,
		'status'    =>  $ticket->status->name,
		'category'  =>  $ticket->category->name
	]) !!}
@stop
