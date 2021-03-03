<?php

namespace ICBTECH\Helpdesk\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'ticketit_categories';

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
        return $this->hasMany('ICBTECH\Helpdesk\Models\Ticket', 'category_id');
    }

    /**
     * Get related agents.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function agents()
    {
        return $this->belongsToMany('\ICBTECH\Helpdesk\Models\Agent', 'ticketit_categories_users', 'category_id', 'user_id');
    }
}
