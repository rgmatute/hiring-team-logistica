<?php

namespace App\Http\Controllers;

use App\AuthToken\JWToken;
use App\Service\HistoryService;
use Exception;
use Illuminate\Http\Request;
use App\Http\Helpers\Utils;
use Illuminate\Pagination\LengthAwarePaginator;

class HistoryController extends Controller
{

    use Utils;

    private $historyService;
    private $jwtInfo;

    public function __construct(Request $request){
        $this->historyService = new HistoryService();
        $this->jwtInfo = JWToken::userInfo($request);
    }

    /**
     * @throws Exception
     */
    public function search(Request $request) : LengthAwarePaginator
    {
        $key = $request->query('key');
        $value = $request->query('value');

        return $this->historyService->search($key, $value, $this->jwtInfo);
    }
}