<?php

namespace App\Policies;

use App\User;
use App\Wallet;
use Illuminate\Auth\Access\HandlesAuthorization;

class WalletPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the wallet.
     *
     * @param  \App\User  $user
     * @param  \App\Wallet  $wallet
     * @return mixed
     */
    public function view(User $user, Wallet $wallet)
    {
        return $user->id === $wallet->users_foreign_id;
    }

    /**
     * Determine whether the user can create wallets.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    public function storeTransfer(User $user, Wallet $wallet)
    {
        return $user->id === $wallet->users_id_foreign ? true:false;
    }

    public function transfer(User $user, Wallet $wallet)
    {
        return $user->id === $wallet->users_id_foreign ? true:false;
    }

    /**
     * Determine whether the user can update the wallet.
     *
     * @param  \App\User  $user
     * @param  \App\Wallet  $wallet
     * @return mixed
     */
    public function update(User $user, Wallet $wallet)
    {
        return $user->id === $wallet->users_id_foreign ? true:false;
    }

    /**
     * Determine whether the user can delete the wallet.
     *
     * @param  \App\User  $user
     * @param  \App\Wallet  $wallet
     * @return mixed
     */
    public function delete(User $user, Wallet $wallet)
    {
        return $user->id === $wallet->users_id_foreign ? true:false;
    }

    /**
     * Determine whether the user can restore the wallet.
     *
     * @param  \App\User  $user
     * @param  \App\Wallet  $wallet
     * @return mixed
     */
    public function restore(User $user, Wallet $wallet)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the wallet.
     *
     * @param  \App\User  $user
     * @param  \App\Wallet  $wallet
     * @return mixed
     */
    public function forceDelete(User $user, Wallet $wallet)
    {
        //
    }
}
