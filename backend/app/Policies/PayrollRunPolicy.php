<?php

namespace App\Policies;

use App\Models\PayrollRun;
use App\Models\User;

class PayrollRunPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('payroll.runs.view');
    }

    public function calculate(User $user, PayrollRun $run): bool
    {
        return $user->hasPermission('payroll.runs.calculate');
    }

    public function approve(User $user, PayrollRun $run): bool
    {
        return $user->hasPermission('payroll.runs.approve');
    }

    public function close(User $user, PayrollRun $run): bool
    {
        return $user->hasPermission('payroll.runs.close');
    }
}
