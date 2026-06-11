<?php

namespace App\Policies;

use App\Models\Account;
use App\Models\User;

class AccountPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('finance.accounts.view');
    }

    public function create(User $user): bool
    {
        return $user->hasPermission('finance.accounts.manage');
    }

    public function update(User $user, Account $account): bool
    {
        return $user->hasPermission('finance.accounts.manage');
    }
}
