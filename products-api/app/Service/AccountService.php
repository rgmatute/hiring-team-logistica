<?php

    namespace App\Service;

    use App\AuthToken\JWToken;
    use App\Exceptions\GenericException;
    use App\Http\Helpers\Utils;
    use App\Repository\UserRepository;
    use Illuminate\Support\Str;

    class AccountService
    {

        use Utils;
        private $userRepository;

        public function __construct(){
            $this->userRepository = new UserRepository();
        }

        /**
         * @throws GenericException
         */
        public function login($credentials) {

            $email = $credentials['email'] ?? null;
            $password = $credentials['password'] ?? null;

            if(!isset($email)){
                throw new GenericException('email es requerido!', 400);
            }

            if(!isset($password)){
                throw new GenericException('password es requerido!', 400);
            }

            $user = $this->userRepository->findByEmail($credentials['email']);

            if(!isset($user)){
                throw new GenericException('No existe el usuario!', 400);
            }

            if(!$this->verifyPassword($password, $user['password'])){
                throw new GenericException('Contraseña incorrecta!', 400);
            }

            $jwt     = new JWToken();
            return $jwt->generateToken($user['email'], 1);
        }

        /**
         * @throws GenericException
         */
        public function destroyToken($token) {

            if(!isset($token)){
                throw new GenericException('Necesita adjuntar el token en la cabecera de la consulta!', 400);
            }

            $jwt = new JWToken();

            // return ($jwt->validarToken($token));
            if(!$jwt->isValid($token)){
                throw new GenericException("El token no es valido - !");
            }

            $jwt->destroyToken($token, null, 0);
        }

        public function accountInfo($jwtInfo) {
            
            if(!isset($jwtInfo->username)){
                throw new GenericException('La sesion es incorrecta!', 400);
            }

            $response = $this->userRepository->findByEmail($jwtInfo->username);

            if(!isset($response)){
                throw new GenericException("No existen datos con la sesion actual!", 404);
            }


            $userArray = $response->toArray();
            $camelCaseArray = [];
            foreach ($userArray as $key => $value) {
                $camelCaseArray[Str::camel($key)] = $value;
            }

            $camelCaseArray['langKey']        = 'es';
            $camelCaseArray['login']        = $camelCaseArray['email'] ?? null;
            $camelCaseArray['authorities']  = [
                "ROLE_USER",
                "ROLE_ADMIN"
            ];

            return $camelCaseArray;
        }

    }

?>