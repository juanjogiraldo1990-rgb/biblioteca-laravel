<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Editorial extends Model
{
    protected $fillable = ['name', 'phone', 'email', 'address'];

    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
