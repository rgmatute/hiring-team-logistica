<?php

namespace App\Domain;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{

    protected $table = 'history';

    protected $fillable = [
        'controller',
        'product_id',
        'method',
        'event',
        'before',
        'after',
        'created_by',
        'last_modified_by',
        'created_at',
        'updated_at'
    ];

    protected $hidden = [];
}