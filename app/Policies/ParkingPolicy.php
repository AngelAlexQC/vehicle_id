<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Parking;
use Illuminate\Auth\Access\HandlesAuthorization;

class ParkingPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the parking can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list parkings');
    }

    /**
     * Determine whether the parking can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Parking  $model
     * @return mixed
     */
    public function view(User $user, Parking $model)
    {
        return $user->hasPermissionTo('view parkings');
    }

    /**
     * Determine whether the parking can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create parkings');
    }

    /**
     * Determine whether the parking can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Parking  $model
     * @return mixed
     */
    public function update(User $user, Parking $model)
    {
        return $user->hasPermissionTo('update parkings');
    }

    /**
     * Determine whether the parking can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Parking  $model
     * @return mixed
     */
    public function delete(User $user, Parking $model)
    {
        return $user->hasPermissionTo('delete parkings');
    }

    /**
     * Determine whether the parking can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Parking  $model
     * @return mixed
     */
    public function restore(User $user, Parking $model)
    {
        return false;
    }

    /**
     * Determine whether the parking can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Parking  $model
     * @return mixed
     */
    public function forceDelete(User $user, Parking $model)
    {
        return false;
    }
}
