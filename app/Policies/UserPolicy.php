<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function update(User $current_user, User $user){
      return $current_user->id == $user->id;
    }

    public function destroy(User $current_user, User $user){
        return $current_user->is_admin == 1 && $current_user->id != $user->id;
    }
}
