<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'sarpras_asset_id',
        'code',
        'title',
        'authors',
        'publisher',
        'isbn',
        'year',
        'rack_location',
        'subject',
        'language',
        'notes',
        'status'
    ];

    public function items()
    {
        return $this->hasMany(BookItem::class);
    }

    // helper ketersediaan
    public function availableItems()
    {
        return $this->items()->where('status', 'available');
    }
}
