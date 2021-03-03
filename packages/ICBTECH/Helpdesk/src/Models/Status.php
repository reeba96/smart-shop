<?php

namespace ICBTECH\Helpdesk\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'ticketit_statuses';

    protected $fillable = ['name', 'color'];

    /**
     * Indicates that this model should not be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get related tickets.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tickets()
    {
        return $this->hasMany('ICBTECH\Helpdesk\Models\Ticket', 'status_id');
    }
}
