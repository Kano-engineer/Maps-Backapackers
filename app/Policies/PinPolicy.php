<?php

namespace App\Policies;

use App\Pin;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PinPolicy
{
    use HandlesAuthorization;

    public function edit(User $user, Pin $pin)
    {
        //
        return $user->id === $pin->user_id;
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Pin  $pin
     * @return mixed
     */
    public function view(User $user, Pin $pin)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Pin  $pin
     * @return mixed
     */
    public function update(User $user, Pin $pin)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Pin  $pin
     * @return mixed
     */
    public function delete(User $user, Pin $pin)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Pin  $pin
     * @return mixed
     */
    public function restore(User $user, Pin $pin)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Pin  $pin
     * @return mixed
     */
    public function forceDelete(User $user, Pin $pin)
    {
        //
    }
    
}
