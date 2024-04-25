<?php

    namespace App\AuthToken;
    use App\Exceptions\GenericException;
    use App\Http\Helpers\Utils;
    use Lcobucci\JWT\Builder;
    use Lcobucci\JWT\ValidationData;
    use Lcobucci\JWT\Signer\Hmac\Sha256;
    use Lcobucci\JWT\Parser;
    use Illuminate\Support\Facades\Cache;

    class JWToken{

        protected $key = 'wlWlFIHcioMnyYvUMkbbYWrJHXCZTw1k';    # key para el firmado del token
        protected $minutosValidez = 1440;                       # tiempo en minutos de validez del token
        protected $emisorToken = 'http://www.google.com';

        public function destroyToken($token, $username, $tiempo = 60){
            Cache::put($token, $username, $tiempo);
        }

        public function generateToken($username, $role){
            $signer = new Sha256();
            $builderToken = new Builder();
            $time = time();
            $token = $builderToken->setIssuer($this->emisorToken) 	# Configura el emisor (iss claim)
            ->setAudience($username) # Configura el receptor (aud claim)
            ->setId(md5($username . $time)) # Configura el id (jti claim), replica como item del header, ID unico del token. md5(cod_usuario + iat claim)
            ->setIssuedAt($time) # Configura el datetime en que el token fue emitido (iat claim)
            ->setNotBefore($time) # Configura el datetime en que el token puede ser usado (nbf claim)
            ->setExpiration($time + $this->minutosValidez*60) # Configura el datetime de expiracion del token (exp claim)
            ->set('data', ['username' => $username, 'auth' => $role]) # Configura un nuevo claim, llamado "data", recordar que esto no va cifrado, ser cuidadoso con lo que se envía
            ->sign($signer, $this->key) # crea una firma usando $key como llave
            ->getToken(); # Pide el token generado
            $token->getHeaders(); # Obtiene el header del token
            $token->getClaims(); # Obtiene el claim del token
            if (!Cache::has((string)$token)) {
                Cache::put((string)$token, (string)$username, ($this->minutosValidez*60));
            }
            return (string)$token;
        }

        private function renewToken($token, $username, $role){
            $this->destroyToken($token, $username);
            $newToken = $this->generateToken($username, $role);

            return $newToken;
        }

        public static function userInfo($request){
            $parser 	= new Parser();
            $strToken 	= $request->header('Authorization');
            
            if(!empty($strToken)){
                
                $strToken = Utils::extractTokenFromAuthorizationHeader($strToken);

                $token 		= $parser->parse($strToken); # Parsea desde una string
                $token->getHeaders(); 	# Obtiene todo el header del token
                $token->getClaims(); 	# Obtiene todos los claims del token
                $userData 	= $token->getClaim('data');
            }

            return $userData ?? [];
        }

        public function validarToken($token){
            $informacion	= [];
            $parser 		= new Parser();
            $signer 		= new Sha256();
            $data 			= new ValidationData(); # Valida basado en la fecha y hora actual (iat, nbf and exp)
            try {
                $strToken 	= (string)$token;

                if (!Cache::has($strToken)) {
                    return $informacion['valid'] = false;
                }
                $token 		= $parser->parse($strToken); # Parsea desde una string
                $token->getHeaders();	# Obtiene todo el header del token
                $token->getClaims(); 	# Obtiene todos los claims del token
                $userData 	= $token->getClaim('data');
                $iatData 	= $token->getClaim('iat');
                $data->setIssuer($this->emisorToken);
                $data->setAudience($userData->username);
                $data->setId(md5($userData->username . $iatData));
                if($token->validate($data) and $token->verify($signer, $this->key)){ # Si token es válido
                    
                    /*
                    $newToken = $this->renewToken($strToken, $userData->comid, $userData->useid, $userData->codper);
                    $informacion['newToken'] = $newToken;
                    */

                    $informacion['valid'] 		= true;
                    $informacion['userInfo'] 	= $token->getClaim('data');
                }else{	# Token no es válido
                    $informacion['valid'] 		= false;
                }
            }catch (\Exception $e){
                $informacion['valid'] 		= false;
            }

            return $informacion;
        }

        /**
         * @throws GenericException
         */
        public function isValid($token) : bool{
            $informacion	= [];
            $parser 		= new Parser();
            $signer 		= new Sha256();
            $data 			= new ValidationData(); # Valida basado en la fecha y hora actual (iat, nbf and exp)
            try {
                $strToken 	= (string)$token;
                if (!Cache::has($strToken)) {
                    throw new GenericException("The session is not valid!", 401);
                }
                $token 		= $parser->parse($strToken); # Parsea desde una string
                $token->getHeaders();	# Obtiene todo el header del token
                $token->getClaims(); 	# Obtiene todos los claims del token
                $userData 	= $token->getClaim('data');
                $iatData 	= $token->getClaim('iat');
                $data->setIssuer($this->emisorToken);
                $data->setAudience($userData->username);
                $data->setId(md5($userData->username . $iatData));
                if($token->validate($data) and $token->verify($signer, $this->key)){ # Si token es válido
                    // el token si es valido
                }else{	# Token no es válido
                    throw new GenericException("The session is not valid!", 401);
                }
            }catch (\Exception $e){
                throw new GenericException("The session is not valid!", 401);
            }

            return true;
        }
    }
?>