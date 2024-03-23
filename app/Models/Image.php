<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    # Ralations

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id', 'id');
    }
}
