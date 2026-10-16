<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title', 'isbn', 'description', 'price', 'stock', 'status', 'image',
        'category_id', 'author_id', 'editorial_id',
    ];

    protected $casts = ['price' => 'decimal:2'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function editorial()
    {
        return $this->belongsTo(Editorial::class);
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
}