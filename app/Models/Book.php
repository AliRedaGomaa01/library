<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    # accessors and mutators and casts
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'title' => 'array',
            'description' => 'array',
        ];
    }

    # Relations
    public function images()
    {
        return $this->hasMany(Image::class, 'book_id', 'id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'book_tags', 'book_id', 'tag_id');
    }

    public function borrowers()
    {
        return $this->belongsToMany(User::class, 'orders', 'book_id', 'user_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'book_id', 'id');
    }

}
