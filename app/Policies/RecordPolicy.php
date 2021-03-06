<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Record;
use Illuminate\Auth\Access\HandlesAuthorization;

class RecordPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the record can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list records');
    }

    /**
     * Determine whether the record can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Record  $model
     * @return mixed
     */
    public function view(User $user, Record $model)
    {
        return $user->hasPermissionTo('view records');
    }

    /**
     * Determine whether the record can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create records');
    }

    /**
     * Determine whether the record can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Record  $model
     * @return mixed
     */
    public function update(User $user, Record $model)
    {
        return $user->hasPermissionTo('update records');
    }

    /**
     * Determine whether the record can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Record  $model
     * @return mixed
     */
    public function delete(User $user, Record $model)
    {
        return $user->hasPermissionTo('delete records');
    }

    /**
     * Determine whether the record can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Record  $model
     * @return mixed
     */
    public function restore(User $user, Record $model)
    {
        return false;
    }

    /**
     * Determine whether the record can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Record  $model
     * @return mixed
     */
    public function forceDelete(User $user, Record $model)
    {
        return false;
    }
}
