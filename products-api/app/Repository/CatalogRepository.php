<?php

namespace App\Repository;

use App\Domain\Catalog;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class CatalogRepository
{

    // public function user(): Builder
    // {
    //     return DB::table('user');
    // }

    public function findAll(): LengthAwarePaginator
    {
        $perPage = request()->input('size', 10) ?? 10;


        return Catalog::where('status', true)->paginate($perPage);
    }

    public function findById( int $id){
        return Catalog::where('id', $id)->first();
    }

    public function save(Array $catalog) : int {
        return Catalog::insertGetId($catalog);
    }

    public function update(Array $catalog, $id) : int {
        return Catalog::where('id', $id)->update($catalog);
    }

    public function delete($id) : int {
        return Catalog::where('id', $id)->update(['status' => false]);
    }

    public function search($key, $value) {

        $perPage = request()->input('size', 10) ?? 10;

        return Catalog::where($key, 'like', '%'.$value.'%')->paginate($perPage);
    }

    public function isActiveById($id) {
        return Catalog::where('id', $id)->where('status', true)->first();
    }

    public function findByIdAndStatus( int $id, bool $status){
        return Catalog::where('id', $id)->where('status', $status)->first();
    }
}