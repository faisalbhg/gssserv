<?php

namespace App\Policies;

use App\Models\TempCustomerSignature;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TempCustomerSignaturePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TempCustomerSignature  $tempCustomerSignature
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, TempCustomerSignature $tempCustomerSignature)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TempCustomerSignature  $tempCustomerSignature
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, TempCustomerSignature $tempCustomerSignature)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TempCustomerSignature  $tempCustomerSignature
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, TempCustomerSignature $tempCustomerSignature)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TempCustomerSignature  $tempCustomerSignature
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, TempCustomerSignature $tempCustomerSignature)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TempCustomerSignature  $tempCustomerSignature
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, TempCustomerSignature $tempCustomerSignature)
    {
        //
    }
}
