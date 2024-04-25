<?php

namespace App\Domain;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{

    protected $table = 'user';

    protected $fillable = [
        'firts_name',
        'last_name',
        'email',
        'password',
        'status',
        'created_at',
        'updated_at'
    ];

    protected $hidden = [
        'password',
    ];
}