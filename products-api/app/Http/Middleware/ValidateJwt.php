<?php
    namespace App\Http\Middleware;
    use App\AuthToken\JWToken;
    use App\Exceptions\GenericException;
    use Closure;

    class ValidateJwt {
        /**
         * @throws GenericException
         */
        public function handle($request, Closure $next){
            $obj_JWToken = new JWToken;
            $response = [];
            $token = $request->header('Authorization');
            if (!isset($token)) {
                throw new GenericException("No se encuentra autenticado!", 401);
                // dd($obj_JWToken, $token);
            } else {
                // $datos = $obj_JWToken->validateToken($token);
                
                $token = $this->extractTokenFromAuthorizationHeader($token);

                if($obj_JWToken->isValid($token)) {
                    return $next($request);
                } else {
                    throw new GenericException("La sesion ha caducado!", 401);
                }
                // dd($obj_JWToken, $token, $datos);
            }
        }

        private function extractTokenFromAuthorizationHeader($authorizationHeader) {
            // Verifica si el encabezado de autorización comienza con "Bearer"
            if (strpos($authorizationHeader, 'Bearer ') === 0) {
                // Si comienza con "Bearer", extrae solo el token
                return substr($authorizationHeader, 7);
            }
        
            // Si no comienza con "Bearer", asume que el token está completo y lo devuelve tal cual
            return $authorizationHeader;
        }
    }
?>