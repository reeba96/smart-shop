<?php

namespace ICBTECH\Helpdesk\Models;

// use App\User;
use Webkul\User\Models\Admin;
use Auth;

class Agent extends Admin
{
    protected $table = 'admins';

    /**
     * list of all agents and returning collection.
     *
     * @param $query
     * @param bool $paginate
     *
     * @return bool
     *
     * @internal param int $cat_id
     */
    public function scopeAgents($query, $paginate = false)
    {
        if ($paginate) {
            return $query->where('role_id', '1')->paginate($paginate, ['*'], 'agents_page');
        } else {
            return $query->where('role_id', '1');
        }
    }

    /**
     * list of all admins and returning collection.
     *
     * @param $query
     * @param bool $paginate
     *
     * @return bool
     *
     * @internal param int $cat_id
     */
    public function scopeAdmins($query, $paginate = false)
    {
        if ($paginate) {
            return $query->where('role_id', '1')->paginate($paginate, ['*'], 'admins_page');
        } else {
            return $query->where('role_id', '1')->get();
        }
    }

    /**
     * list of all agents and returning collection.
     *
     * @param $query
     * @param bool $paginate
     *
     * @return bool
     *
     * @internal param int $cat_id
     */
    public function scopeUsers($query, $paginate = false)
    {
        if ($paginate) {
            return $query->where('role_id', '1')->paginate($paginate, ['*'], 'users_page');
        } else {
            return $query->where('role_id', '1')->get();
        }
    }

    /**
     * list of all agents and returning lists array of id and name.
     *
     * @param $query
     *
     * @return bool
     *
     * @internal param int $cat_id
     */
    public function scopeAgentsLists($query)
    {
        if (version_compare(app()->version(), '5.2.0', '>=')) {
            return $query->where('role_id', '1')->pluck('name', 'id')->toArray();
        } else { // if Laravel 5.1
            return $query->where('role_id', '1')->lists('name', 'id')->toArray();
        }
    }

    /**
     * Check if user is agent.
     *
     * @return bool
     */
    public static function isAgent($id = null)
    {   
        /*
        if (isset($id)) {
            $user = Admin::find($id);
            if ($user->role_id) {
                return true;
            }

            return false;
        }
        if (auth()->check()) {
            if (auth()->user()->role_id) {
                return true;
            }
        }
        */
        // Admin is always agent
        return true;
    }

    /**
     * Check if user is admin.
     *
     * @return bool
     */
    public static function isAdmin()
    {
        // return auth()->check() && auth()->user()->ticketit_admin;
        return true;
    }

    /**
     * Check if user is the assigned agent for a ticket.
     *
     * @param int $id ticket id
     *
     * @return bool
     */
    public static function isAssignedAgent($id)
    {   
        /*
        return auth()->check() &&
        	Auth::user()->role_id &&
            Auth::user()->id == Ticket::find($id)->agent->id;
            */
        return true;
    }

    /**
     * Check if user is the owner for a ticket.
     *
     * @param int $id ticket id
     *
     * @return bool
     */
    public static function isTicketOwner($id)
    {
    	$ticket = Ticket::find($id);
        return $ticket && auth()->check() &&
            auth()->user()->id == $ticket->user->id;
    }

    /**
     * Get related categories.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categories()
    {
        return $this->belongsToMany('ICBTECH\Helpdesk\Models\Category', 'ticketit_categories_users', 'user_id', 'category_id');
    }

    /**
     * Get related agent tickets (To be deprecated).
     */
    public function agentTickets($complete = false)
    {
        if ($complete) {
            return $this->hasMany('ICBTECH\Helpdesk\Models\Ticket', 'agent_id')->whereNotNull('completed_at');
        } else {
            return $this->hasMany('ICBTECH\Helpdesk\Models\Ticket', 'agent_id')->whereNull('completed_at');
        }
    }

    /**
     * Get related user tickets (To be deprecated).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userTickets($complete = false)
    {
        if ($complete) {
            return $this->hasMany('ICBTECH\Helpdesk\Models\Ticket', 'user_id')->whereNotNull('completed_at');
        } else {
            return $this->hasMany('ICBTECH\Helpdesk\Models\Ticket', 'user_id')->whereNull('completed_at');
        }
    }

    public function tickets($complete = false)
    {
        if ($complete) {
            return $this->hasMany('ICBTECH\Helpdesk\Models\Ticket', 'user_id')->whereNotNull('completed_at');
        } else {
            return $this->hasMany('ICBTECH\Helpdesk\Models\Ticket', 'user_id')->whereNull('completed_at');
        }
    }

    public function allTickets($complete = false) // (To be deprecated)
    {
        if ($complete) {
            return Ticket::whereNotNull('completed_at');
        } else {
            return Ticket::whereNull('completed_at');
        }
    }

    public function getTickets($complete = false) // (To be deprecated)
    {
        $user = self::find(auth()->user()->id);
        
        if ($user->isAdmin()) {
            $tickets = $user->allTickets($complete);
        } elseif ($user->isAgent()) {
            $tickets = $user->agentTickets($complete);
        } else {
            $tickets = $user->userTickets($complete);
        }

        return $tickets;
    }

    /**
     * Get related agent total tickets.
     */
    public function agentTotalTickets()
    {
        return $this->hasMany('ICBTECH\Helpdesk\Models\Ticket', 'agent_id');
    }

    /**
     * Get related agent Completed tickets.
     */
    public function agentCompleteTickets()
    {
        return $this->hasMany('ICBTECH\Helpdesk\Models\Ticket', 'agent_id')->whereNotNull('completed_at');
    }

    /**
     * Get related agent tickets.
     */
    public function agentOpenTickets()
    {
        return $this->hasMany('ICBTECH\Helpdesk\Models\Ticket', 'agent_id')->whereNull('completed_at');
    }

    /**
     * Get related user total tickets.
     */
    public function userTotalTickets()
    {
        return $this->hasMany('ICBTECH\Helpdesk\Models\Ticket', 'user_id');
    }

    /**
     * Get related user Completed tickets.
     */
    public function userCompleteTickets()
    {
        return $this->hasMany('ICBTECH\Helpdesk\Models\Ticket', 'user_id')->whereNotNull('completed_at');
    }

    /**
     * Get related user tickets.
     */
    public function userOpenTickets()
    {
        return $this->hasMany('ICBTECH\Helpdesk\Models\Ticket', 'user_id')->whereNull('completed_at');
    }
}
