<?php

namespace App\Http\Helpers;

use App\Exceptions\GenericException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

trait Utils
{
    // Método para formatear una respuesta exitosa
    public function successResponse($data, $statusCode = Response::HTTP_OK) : JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => 'Transaction completed successfully!'
        ], $statusCode);
    }

    public function successOnlyMessage($statusCode = Response::HTTP_OK) : JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Transaction completed successfully!'
        ], $statusCode);
    }

    // Método para formatear una respuesta de error
    public function errorResponse($message, $statusCode) : JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message ?? 'aaaaaaaaa'
        ], $statusCode);
    }

    public function password($value) {
        return password_hash($value, PASSWORD_BCRYPT, ['cost' => 12]);
    }

    public function verifyPassword($password, $password_hash) {
        return password_verify($password, $password_hash);
    }

    public function successLogin($bearerToken, $statusCode = Response::HTTP_OK) : JsonResponse
    {
        return response()->json([
            'success' => true,
            'id_token' => $bearerToken
        ], $statusCode)
        ->header('Authorization', 'Bearer ' . $bearerToken);;
    }

    public function validateRequest(array $rules)
    {
        $validator = Validator::make(request()->all(), $rules);

        if ($validator->fails()) {
            throw new GenericException(json_encode($validator->errors()), 422);
            // return response()->json([
            //     'success' => false,
            //     'errors' => $validator->errors()
            // ], 422);
        }

        return request();
    }

    public static function extractTokenFromAuthorizationHeader($authorizationHeader) {
        // Verifica si el encabezado de autorización comienza con "Bearer"
        if (strpos($authorizationHeader, 'Bearer ') === 0) {
            // Si comienza con "Bearer", extrae solo el token
            return substr($authorizationHeader, 7);
        }
    
        // Si no comienza con "Bearer", asume que el token está completo y lo devuelve tal cual
        return $authorizationHeader;
    }
}