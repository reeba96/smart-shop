<?php $comment = unserialize($comment);?>
<?php $ticket = unserialize($ticket);?>
<?php $notification_owner = unserialize($notification_owner);?>

@extends($email)

@section('subject')
	{{ trans('helpdesk::email/globals.comment') }}
@stop

@section('link')
	<a style="color:#ffffff" href="{{ route('customer.helpdesk.show', $ticket->id) }}">
		{{ trans('helpdesk::email/globals.view-ticket') }}
	</a>
@stop

@section('content')
	{!! trans('helpdesk::email/comment.data', [
	    'name'      =>  $notification_owner->name,
	    'subject'   =>  $ticket->subject,
	    'status'    =>  $ticket->status->name,
	    'category'  =>  $ticket->category->name,
	    'comment'   =>  $comment->getShortContent()
	]) !!}
@stop
