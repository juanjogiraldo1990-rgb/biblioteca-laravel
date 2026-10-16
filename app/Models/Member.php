<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [
        'document', 'name', 'email', 'phone', 'address', 'birth_date', 'status',
    ];

    protected $casts = ['birth_date' => 'date'];

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
}
