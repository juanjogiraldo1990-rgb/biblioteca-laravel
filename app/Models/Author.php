<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $fillable = ['name', 'nationality', 'birth_date'];

    protected $casts = ['birth_date' => 'date'];

    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
