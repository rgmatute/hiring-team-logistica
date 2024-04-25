<?php

namespace App\Domain;

use Illuminate\Database\Eloquent\Model;

class Catalog extends Model
{

    protected $table = 'catalog';

    protected $fillable = [
        'item_name',
        'catalog_key',
        'catalog_name',
        'catalog_description',
        'status',
        'created_by',
        'last_modified_by',
        'created_date',
        'last_modified_date'
    ];

    protected $hidden = [];

    public function product()
    {
        return $this->hasMany(Product::class);
    }
}