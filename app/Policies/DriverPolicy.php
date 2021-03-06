<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Driver;
use Illuminate\Auth\Access\HandlesAuthorization;

class DriverPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the driver can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list drivers');
    }

    /**
     * Determine whether the driver can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Driver  $model
     * @return mixed
     */
    public function view(User $user, Driver $model)
    {
        return $user->hasPermissionTo('view drivers');
    }

    /**
     * Determine whether the driver can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create drivers');
    }

    /**
     * Determine whether the driver can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Driver  $model
     * @return mixed
     */
    public function update(User $user, Driver $model)
    {
        return $user->hasPermissionTo('update drivers');
    }

    /**
     * Determine whether the driver can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Driver  $model
     * @return mixed
     */
    public function delete(User $user, Driver $model)
    {
        return $user->hasPermissionTo('delete drivers');
    }

    /**
     * Determine whether the driver can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Driver  $model
     * @return mixed
     */
    public function restore(User $user, Driver $model)
    {
        return false;
    }

    /**
     * Determine whether the driver can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Driver  $model
     * @return mixed
     */
    public function forceDelete(User $user, Driver $model)
    {
        return false;
    }
}
