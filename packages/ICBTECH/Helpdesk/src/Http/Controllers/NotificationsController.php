<?php

namespace ICBTECH\Helpdesk\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use ICBTECH\Helpdesk\Helpers\LaravelVersion;
use ICBTECH\Helpdesk\Models\Comment;
use ICBTECH\Helpdesk\Models\Setting;
use ICBTECH\Helpdesk\Models\Ticket;
use Webkul\Customer\Models\Customer;
use Webkul\Customer\Repositories\CustomerRepository;

class NotificationsController extends Controller
{
    public function newComment(Comment $comment)
    {
        $ticket = $comment->ticket;
        $notification_owner = Customer::find($ticket->user_id);
        $template = 'helpdesk::emails.comment';
        $data = ['comment' => serialize($comment), 'ticket' => serialize($ticket), 'notification_owner' => serialize($notification_owner)];

        $this->sendNotification($template, $data, $ticket, $notification_owner,
            trans('helpdesk::lang.notify-new-comment-from').$notification_owner->name.trans('helpdesk::lang.notify-on').$ticket->subject, 'comment');
    }

    public function ticketStatusUpdated(Ticket $ticket, Ticket $original_ticket)
    {
        $notification_owner = auth()->user();
        $template = 'helpdesk::emails.status';
        $data = [
            'ticket'             => serialize($ticket),
            'notification_owner' => serialize($notification_owner),
            'original_ticket'    => serialize($original_ticket),
        ];
        /*
        if (strtotime($ticket->completed_at)) {
            $this->sendNotification($template, $data, $ticket, $notification_owner,
                $notification_owner->name.trans('helpdesk::lang.notify-updated').$ticket->subject.trans('helpdesk::lang.notify-status-to-complete'), 'status');
        } else {
            $this->sendNotification($template, $data, $ticket, $notification_owner,
                $notification_owner->name.trans('helpdesk::lang.notify-updated').$ticket->subject.trans('helpdesk::lang.notify-status-to').$ticket->status->name, 'status');
        }
        */
    }

    public function ticketAgentUpdated(Ticket $ticket, Ticket $original_ticket)
    {
        $notification_owner = auth()->user();
        $template = 'helpdesk::emails.transfer';
        $data = [
            'ticket'             => serialize($ticket),
            'notification_owner' => serialize($notification_owner),
            'original_ticket'    => serialize($original_ticket),
        ];

        $this->sendNotification($template, $data, $ticket, $notification_owner,
            $notification_owner->name.trans('helpdesk::lang.notify-transferred').$ticket->subject.trans('helpdesk::lang.notify-to-you'), 'agent');
    }

    public function newTicketNotifyAgent(Ticket $ticket)
    {
        $notification_owner = $ticket->user()->first();
        $template = 'helpdesk::emails.assigned';
        $data = [
            'ticket'             => serialize($ticket),
            'notification_owner' => serialize($notification_owner),
        ];

        $this->sendNotification($template, $data, $ticket, $notification_owner,
            $notification_owner->name.trans('helpdesk::lang.notify-created-ticket').$ticket->subject, 'agent');
    }

    /**
     * Send email notifications from the action owner to other involved users.
     *
     * @param string $template
     * @param array  $data
     * @param object $ticket
     * @param object $notification_owner
     */
    public function sendNotification($template, $data, $ticket, $notification_owner, $subject, $type)
    {
        /**
         * @var User
         */
        $to = null;

        if ($type != 'agent') {
            $to = $ticket->user;

            if ($ticket->user->email != $notification_owner->email) {
                $to = $ticket->user;
            }

            if ($ticket->agent->email != $notification_owner->email) {
                $to = $ticket->agent;
            }
        } else {
            $to = $ticket->agent;
        }

        if (LaravelVersion::lt('5.4')) {
            $mail_callback = function ($m) use ($to, $notification_owner, $subject) {
                $m->to($to->email, $to->name);

                $m->replyTo($notification_owner->email, $notification_owner->name);

                $m->subject($subject);
            };

            if (Setting::grab('queue_emails') == 'yes') {
                Mail::queue($template, $data, $mail_callback);
            } else {
                Mail::send($template, $data, $mail_callback);
            }
        } elseif (LaravelVersion::min('5.4')) {
            $mail = new \ICBTECH\Helpdesk\Mail\TicketitNotification($template, $data, $notification_owner, $subject);

            if (Setting::grab('queue_emails') == 'yes') {
                Mail::to($to)->queue($mail);
            } else {
                Mail::to($to)->send($mail);
            }
        }
    }
}
