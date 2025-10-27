<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LoanItem extends Model
{
    use HasFactory;

    protected $fillable = ['loan_id', 'book_item_id', 'fine_amount', 'returned_at'];
    protected $casts = ['returned_at' => 'datetime'];

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    public function bookItem()
    {
        return $this->belongsTo(BookItem::class);
    }
}
