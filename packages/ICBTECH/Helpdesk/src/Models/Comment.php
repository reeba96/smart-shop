<?php

namespace ICBTECH\Helpdesk\Models;

use Illuminate\Database\Eloquent\Model;
use ICBTECH\Helpdesk\Traits\ContentEllipse;
use ICBTECH\Helpdesk\Traits\Purifiable;
use Webkul\User\Models\Admin;

class Comment extends Model
{
    use ContentEllipse;
    use Purifiable;

    protected $table = 'ticketit_comments';

    /**
     * Get related ticket.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ticket()
    {
        return $this->belongsTo('ICBTECH\Helpdesk\Models\Ticket', 'ticket_id');
    }

    /**
     * Get comment owner.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('Webkul\Customer\Models\Customer', 'user_id');
    }

     /**
     * Get comment owner.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function admin()
    {  
        return $this->belongsTo('Webkul\User\Models\Admin', 'admin_id');
    }
    
}
