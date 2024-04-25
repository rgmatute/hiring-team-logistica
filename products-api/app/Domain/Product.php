<?php

namespace App\Domain;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $table = 'product';

    protected $fillable = [
        'serial_code',
        'name',
        'description',
        'price',
        'iva',
        'discount',
        'resource_id',
        'stock',
        'status',
        'catalog_id',
        'created_by',
        'last_modified_by',
        'created_at',
        'updated_at'
    ];

    protected $hidden = [];

    public function catalog()
    {
        return $this->belongsTo(Catalog::class);
    }
}