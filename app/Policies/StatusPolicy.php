<?php

namespace App\Policies;

use App\Status;
use Illuminate\Auth\Access\HandlesAuthorization;
use Webkul\User\Models\Admin;

class StatusPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \Webkul\User\Models\Admin  $admin
     * @return mixed
     */
    public function viewAny(Admin $admin)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \Webkul\User\Models\Admin  $admin
     * @param  \App\Status  $status
     * @return mixed
     */
    public function view(Admin $admin, Status $status)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \Webkul\User\Models\Admin  $admin
     * @return mixed
     */
    public function create(Admin $admin)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \Webkul\User\Models\Admin  $admin
     * @param  \App\Status  $status
     * @return mixed
     */
    public function update(Admin $admin, Status $status)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \Webkul\User\Models\Admin  $admin
     * @param  \App\Status  $status
     * @return mixed
     */
    public function delete(Admin $admin, Status $status)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \Webkul\User\Models\Admin  $admin
     * @param  \App\Status  $status
     * @return mixed
     */
    public function restore(Admin $admin, Status $status)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \Webkul\User\Models\Admin  $admin
     * @param  \App\Status  $status
     * @return mixed
     */
    public function forceDelete(Admin $admin, Status $status)
    {
        //
    }
}
