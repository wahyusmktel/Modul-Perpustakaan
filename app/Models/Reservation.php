<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = ['member_id', 'book_id', 'status', 'queued_at', 'ready_at', 'ready_expire_at', 'picked_at'];
    protected $casts = [
        'queued_at' => 'datetime',
        'ready_at' => 'datetime',
        'ready_expire_at' => 'datetime',
        'picked_at' => 'datetime',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function scopeActive($q)
    {
        return $q->whereIn('status', ['queued', 'ready']);
    }
}
