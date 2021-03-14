@if(!$comments->isEmpty())
    @foreach($comments as $comment)
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-baseline flex-wrap">
                <?php 
                    if($comment->user_id == 0) { 
                        $username = $comment->admin->name;
                    } else { 
                        $username = $customer->name;
                    }
                ?>
                <div>{!! $username !!}</div>
                <div>{!! $comment->created_at->diffForHumans() !!}</div>
            </div>
            <div class="card-body pb-0">
                {!! $comment->html !!}
            </div>
        </div>
    @endforeach
    
    {!! view_render_event('bagisto.shop.customers.account.helpdesk.reply.before') !!}

    <form method="POST" action="{{ route('customer.helpdesk.reply') }}" @submit.prevent="onSubmit" enctype="multipart/form-data"><br>
        @csrf

        {!! view_render_event('bagisto.shop.customers.account.helpdesk.reply_form_controls.before') !!}
         @if ( $ticket->status_id != $default_close_status_id->default)
        
            <div class="control-group" :class="[errors.has('content') ? 'has-error' : '']">
                <textarea class="form-control" rows="5" name="content" style="font-size: 15px;" v-validate="'required'" data-vv-as="&quot;{{ __('shop::app.customer.account.helpdesk.description') }}&quot;"></textarea>
                <span class="control-error" v-if="errors.has('content')">@{{ errors.first('content') }}</span>
            </div>

            <input type="hidden" id="ticket_id"   name="ticket_id" value="{{ $ticket->id }}">
            <input type="hidden" id="customer_id"   name="customer_id" value="{{ $customer->id }}">

            {!! view_render_event('bagisto.shop.customers.account.helpdesk.reply_form_controls.after') !!}
            
            <br><button type="submit" class="btn btn-lg btn-primary reply-ticket"> {{ __('shop::app.customer.account.helpdesk.reply') }} </button>
         @endif

    </form>

    {!! view_render_event('bagisto.shop.customers.account.helpdesk.reply.after') !!}
@endif