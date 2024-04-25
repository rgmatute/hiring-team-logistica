<?php

namespace App\Http\Controllers;

use App\AuthToken\JWToken;
use App\Service\CatalogService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Helpers\Utils;
use Illuminate\Pagination\LengthAwarePaginator;

class CatalogController extends Controller
{

    use Utils;

    private $catalogService;
    private $jwtInfo;

    public function __construct(Request $request){
        $this->catalogService = new CatalogService();
        $this->jwtInfo = JWToken::userInfo($request);
    }

    // GET
    public function index(Request $request): LengthAwarePaginator
    {
        // return Clients::all();
        return $this->catalogService->findAll();
    }

    public function show($id, Request $request){
        // return Clients::findOrFail($id);
        $response = $this->catalogService->findById($id);

        return $this->successResponse($response);
    }

    /**
     * @throws Exception
     */
    public function store(Request $request): JsonResponse
    {
        $inData = json_decode($request->getContent(), true);

        $response = $this->catalogService->created($inData, $this->jwtInfo);

        return $this->successResponse($response);
    }

    /**
     * @throws Exception
     */
    public function update(Request $request, $id): JsonResponse
    {
        $inData = json_decode($request->getContent(), true);

        $response = $this->catalogService->update($inData, $this->jwtInfo, $id);

        return $this->successResponse($response);
    }

    /**
     * @throws Exception
     */
    public function delete(Request $request, $id): JsonResponse
    {
        $this->catalogService->delete($id, $this->jwtInfo);

        return $this->successOnlyMessage();
    }

    /**
     * @throws Exception
     */
    public function search(Request $request) : LengthAwarePaginator
    {
        $key = $request->query('key');
        $value = $request->query('value');

        return $this->catalogService->search($key, $value, $this->jwtInfo);
    }
}