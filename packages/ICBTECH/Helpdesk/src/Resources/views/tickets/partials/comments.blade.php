@if($comments)
    @foreach($comments as $comment)
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-baseline flex-wrap">
                <div></div>
            </div>
            <div class="card-body pb-0">
                <?php 
                    if($comment->user_id == 0) { 
                        $username = $comment->admin->name;
                    } else { 
                        $username = $customer->name;
                    }
                ?>
                <accordian :title="'{!! $username !!} ({{ $comment->created_at->diffForHumans() }})'" :active="true">
                    <div slot="body">
                        <div class="section-content">
                            <div class="row">
                                {{ $comment->html }} [[ {{ $comment->created_at }}  ]]
                            </div>
                        </div>
                    </div>
                </accordian>
            </div>
        </div>
    @endforeach

    {!! view_render_event('bagisto.shop.admin.helpdesk.reply.before') !!}

    <form method="POST" action="{{ route('admin.helpdesk.reply') }}" @submit.prevent="onSubmit" enctype="multipart/form-data">
        @csrf

        {!! view_render_event('bagisto.shop.admin.helpdesk.reply_form_controls.before') !!}
        @if ( $ticket->status_id != $default_close_status_id->default)

            <div class="control-group" :class="[errors.has('content') ? 'has-error' : '']">
                <textarea class="form-control" rows="5" cols="160" name="content" style="font-size: 15px;" v-validate="'required'" data-vv-as="&quot;{{ __('shop::app.customer.account.helpdesk.description') }}&quot;"></textarea>
                <span class="control-error" v-if="errors.has('content')">@{{ errors.first('content') }}</span>
            </div>

            <input type="hidden" id="ticket_id"   name="ticket_id" value="{{ $ticket->id }}">
            <input type="hidden" id="admin_id"   name="admin_id" value="{{ $customer->id }}">

            {!! view_render_event('bagisto.shop.admin.helpdesk.reply_form_controls.after') !!}
            
            <button type="submit" class="btn btn-lg btn-primary"> {{ __('shop::app.customer.account.helpdesk.reply') }} </button>
        @endif
    </form>

    {!! view_render_event('bagisto.shop.admin.helpdesk.reply.after') !!}
@endif