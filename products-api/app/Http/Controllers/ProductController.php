<?php

namespace App\Http\Controllers;

use App\AuthToken\JWToken;
use App\Service\ProductService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Helpers\Utils;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductController extends Controller
{

    use Utils;

    private $productService;
    private $jwtInfo;

    public function __construct(Request $request){
        $this->productService = new ProductService();
        $this->jwtInfo = JWToken::userInfo($request);
    }

    // GET
    public function index(Request $request): LengthAwarePaginator
    {
        return $this->productService->findAll();
    }

    public function show($id, Request $request){

        $response = $this->productService->findById($id, $this->jwtInfo);

        return $this->successResponse($response);
    }

    /**
     * @throws Exception
     */
    public function store(Request $request): JsonResponse
    {
        $inData = json_decode($request->getContent(), true);

        $response = $this->productService->created($inData, $this->jwtInfo);

        return $this->successResponse($response);
    }

    /**
     * @throws Exception
     */
    public function update(Request $request, $id): JsonResponse
    {
        $inData = json_decode($request->getContent(), true);

        $response = $this->productService->update($inData, $this->jwtInfo, $id);

        return $this->successResponse($response);
    }

    /**
     * @throws Exception
     */
    public function delete(Request $request, $id): JsonResponse
    {
        $this->productService->delete($id, $this->jwtInfo);

        return $this->successOnlyMessage();
    }

    /**
     * @throws Exception
     */
    public function search(Request $request) : LengthAwarePaginator
    {
        $key = $request->query('key');
        $value = $request->query('value');

        return $this->productService->search($key, $value, $this->jwtInfo);
    }
}