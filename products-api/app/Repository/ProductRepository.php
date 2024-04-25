<?php

namespace App\Repository;

use App\Domain\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductRepository
{

    public function findAll(): LengthAwarePaginator
    {

        $perPage = request()->input('size', 10) ?? 10;

        return Product::with('catalog')->where('status', true)->paginate($perPage);
    }

    public function findById( int $id){
        return Product::with('catalog')->where('id', $id)->first();
    }

    public function save(Array $product) : int {
        return Product::insertGetId($product);
    }

    public function update(Array $product, $id) : int {
        return Product::where('id', $id)->update($product);
    }

    public function delete($id) : int {
        return Product::where('id', $id)->update(['status' => false]);
    }

    public function search($key, $value) {

        $perPage = request()->input('size', 10) ?? 10;

        if (strpos($key, "stock") !== false) {
            if ($value == -1) {
                return Product::with('catalog')->where($key, '>', 0)->paginate($perPage);
            } else {
                return Product::with('catalog')->where($key, '=', $value)->paginate($perPage);
            }
        } else {
            if (strpos($key, "category") !== false) {
                return Product::whereHas('catalog', function ($query) use ($key, $value) {
                    $query->where('catalog_name', 'like', '%'.$value.'%');
                })
                ->with('catalog')->paginate($perPage);
            }

            return Product::with('catalog')->where($key, 'like', '%'.$value.'%')->paginate($perPage);
        }
    }

    public function isActiveById($id) {
        return Product::with('catalog')->where('id', $id)->where('status', true)->first();
    }

    public function findByIdAndStatus( $id, $status){
        return Product::where('id', $id)->where('status', $status)->first();
    }
}