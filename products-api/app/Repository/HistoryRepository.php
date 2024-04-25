<?php

namespace App\Repository;

use App\Domain\History;

class HistoryRepository
{

    public function save(Array $catalog) : int {
        return History::insertGetId($catalog);
    }

    public function search($key, $value) {

        $perPage = request()->input('size', 10) ?? 10;

        return History::where($key, '=', $value)->paginate($perPage);
    }
}