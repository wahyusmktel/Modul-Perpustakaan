<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = ['member_id', 'loan_date', 'due_date', 'return_date', 'total_fine', 'status'];
    protected $casts = ['loan_date' => 'date', 'due_date' => 'date', 'return_date' => 'date'];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function items()
    {
        return $this->hasMany(LoanItem::class);
    }

    public function scopeOpen($q)
    {
        return $q->where('status', 'open');
    }
    public function scopeOverdue($q)
    {
        return $q->where('status', 'overdue');
    }
}
