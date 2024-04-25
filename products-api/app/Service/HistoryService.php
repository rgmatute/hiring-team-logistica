<?php 

    namespace App\Service;

    use App\Exceptions\GenericException;
    use App\Repository\HistoryRepository;
    use App\Http\Helpers\Utils;
    use Illuminate\Pagination\LengthAwarePaginator;

    class HistoryService
    {

        use Utils;
        private $historyRepository;

        public function __construct(){
            $this->historyRepository = new HistoryRepository();
        }

        /**
         * @throws GenericException
         */
        public function created($inData, $jwtInfo)
        {

            $inData['created_by']       = $jwtInfo->username ?? 'system';
            $inData['last_modified_by'] = $jwtInfo->username ?? 'system';

            $this->historyRepository->save($inData);

        }

        /**
         * @throws GenericException
         */
        public function search($key, $value, $jwtInfo) : LengthAwarePaginator {

            if(!isset($key)){
                throw new GenericException("Necesita proporcionar el parametro 'key'!", 400);
            }

            if(!isset($value)){
                throw new GenericException("Necesita proporcionar el parametro 'value'!", 400);
            }

            $response = $this->historyRepository->search($key, $value);

            if(!isset($response)){
                throw new GenericException("No existen registros!", 404);
            }

            return $response;
        }
    }
?>