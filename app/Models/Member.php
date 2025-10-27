<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Member extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'name', 'email', 'phone', 'address', 'expires_at', 'status'];
    protected $casts = ['expires_at' => 'date'];

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function scopeActive($q)
    {
        return $q->where('status', 'active');
    }
}
