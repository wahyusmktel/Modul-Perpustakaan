<?php

namespace App\Services;

use Carbon\Carbon;

class LoanPolicyService
{
    public function dueDate(?Carbon $start = null): Carbon
    {
        $start = $start ?: now();
        $days  = (int) config('library.policy.loan_days', 7);
        return $start->copy()->startOfDay()->addDays($days);
    }

    public function fineForReturn(\DateTimeInterface $dueDate, ?\DateTimeInterface $returnedAt = null): int
    {
        $returned = $returnedAt ? Carbon::instance($returnedAt) : now();
        $due      = Carbon::instance($dueDate)->endOfDay();
        $grace    = (int) config('library.policy.grace_days', 0);

        if ($returned->lessThanOrEqualTo($due->copy()->addDays($grace))) return 0;

        $daysLate = $due->diffInDays($returned) - $grace;
        $finePer  = (int) config('library.policy.fine_per_day', 1000);
        return max(0, $daysLate * $finePer);
    }

    public function maxItems(): int
    {
        return (int) config('library.policy.max_items', 3);
    }

    public function renewMax(): int
    {
        return (int) config('library.policy.renew_max', 2);
    }

    public function readyDays(): int
    {
        return (int) config('library.policy.reservation_ready_days', 2);
    }
}
