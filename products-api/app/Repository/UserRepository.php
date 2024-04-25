<?php

namespace App\Repository;

use App\Domain\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class UserRepository
{

    public function user(): Builder
    {
        return DB::table('user');
    }

    public function findAll(): LengthAwarePaginator
    {
        return User::where('status', true)->paginate(20);
    }

    public function findById( int $id){
        return User::where('id', $id)->first();
    }

    public function findByEmail($email){
        return User::where('email', $email)->first();
    }

    public function save(Array $client) : int {
        return User::insertGetId($client);
    }

    public function update(Array $client, $id) : int {
        return User::where('id', $id)->update($client);
    }

    public function delete($id) : int {
        return User::where('id', $id)->update(['status' => false]);
    }

    public function search($key, $value) {
        return User::where($key, 'like', '%'.$value.'%')->paginate();
    }

    public function isActiveById($id) {
        return User::where('id', $id)->where('status', true)->first();
    }

    public function findByIdAndStatus( int $id, bool $status){
        return User::where('id', $id)->where('status', $status)->first();
    }
}