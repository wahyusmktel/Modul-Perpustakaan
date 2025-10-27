<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BookItem extends Model
{
    use HasFactory;

    protected $fillable = ['book_id', 'copy_no', 'barcode', 'condition', 'status'];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function loanItems()
    {
        return $this->hasMany(LoanItem::class);
    }

    public function scopeAvailable($q)
    {
        return $q->where('status', 'available');
    }
}
