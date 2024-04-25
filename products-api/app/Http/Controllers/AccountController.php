<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Utils;
use App\Service\AccountService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\AuthToken\JWToken;

class AccountController extends Controller
{
    use Utils;

    private $accountService;
    private $jwtInfo;

    public function __construct(Request $request){
        $this->accountService = new AccountService();
        $this->jwtInfo = JWToken::userInfo($request);
    }

    public function login(Request $request)
    {
        $request = json_decode($request->getContent(), true);

        $bearerToken = $this->accountService->login($request);

        return $this->successLogin($bearerToken);

    }

    public function logout(Request $request): JsonResponse
    {
        $token = $request->header('Authorization');

        $this->accountService->destroyToken($token);

        return $this->successOnlyMessage();
    }

    public function logout_(Request $request): JsonResponse
    {
        try {
            $jwt = new JWToken();
            $token = $request->header('Authorization');

            $jwt->destroyToken($token, null, 0);

            //$this->notificarEvent($this->user_id, 'You have logged out');
            return response()->json(['message' => "Session closed successfully"]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
        return response()->json(null);
    }

    public function accountInfo(): JsonResponse
    {
        $account = $this->accountService->accountInfo($this->jwtInfo);

        return $this->successResponse($account);
    }
}