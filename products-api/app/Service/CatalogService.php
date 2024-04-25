<?php 

    namespace App\Service;

    use App\AuthToken\JWToken;
    use App\Exceptions\GenericException;
    use App\Repository\CatalogRepository;
    use Carbon\Carbon;
    use Exception;
    use App\Http\Helpers\Utils;
    use Illuminate\Pagination\LengthAwarePaginator;

    class CatalogService
    {

        use Utils;
        private $catalogRepository;

        public function __construct(){
            $this->catalogRepository = new CatalogRepository();
        }

        /**
         * @throws GenericException
         */
        public function findAll(): LengthAwarePaginator
        {
            try {
                return $this->catalogRepository->findAll();
            }catch (Exception $e){
                throw new GenericException($e->getMessage());
            }
        }

        /**
         * @throws GenericException
         */
        public function findById($id) {
            if(!is_numeric($id)){
                throw new GenericException('Necesita proporcionar un código numerico!', 400);
            }

            $response = $this->catalogRepository->findById($id);

            if(!isset($response)){
                throw new GenericException("No existe el registro con id '$id'", 404);
            }

            return $response;
        }

        /**
         * @throws GenericException
         */
        public function created($inData, $jwtInfo)
        {

            $validatedRequest = $this->validateRequest([
                'catalog_key'   =>  'required|string|max:100',
                'catalog_name'  =>  'required|string|max:150|unique:catalog',
                'item_name'     =>  'required|string|min:8',
            ]);

            $inData['created_by']       = $jwtInfo->username ?? 'system';
            $inData['last_modified_by'] = $jwtInfo->username ?? 'system';

            $id = $this->catalogRepository->save($inData);

            $catalog = $this->catalogRepository->findById($id);

            if(!isset($catalog)) {
                throw new GenericException("No se pudo guardar el catalog!", 404);
            }

            return $catalog;
        }

        /**
         * @throws GenericException
         */
        public function update($inData, $jwtInfo, $id)
        {
            $exits = $this->catalogRepository->findById($id);

            if(!isset($exits)){
                throw new GenericException("No existe el registro con Id $id!");
            }

            $update = $exits->toArray();

            $update['catalog_key']           = $inData['catalog_key']           ?? $update['catalog_key'];
            $update['item_name']             = $inData['item_name']             ?? $update['item_name'];
            $update['catalog_name']          = $inData['catalog_name']          ?? $update['catalog_name'];
            $update['catalog_description']   = $inData['catalog_description']   ?? $update['catalog_description'];
            $update['status']                = $inData['status']                ?? $update['status'];

            $update['last_modified_by']      = $jwtInfo->username ?? 'system';
            $update['updated_at']           = Carbon::now();
            unset($update['id'], $update['created_at']);

            $this->catalogRepository->update($update, $id);

            $catalog = $this->catalogRepository->findById($id);

            if(!isset($catalog)) {
                throw new GenericException("No se pudo guardar el catalog!", 404);
            }

            return $catalog;
        }

        /**
         * @throws GenericException
         */
        public function delete($id, $jwtInfo)
        {
            // Por ahora el registro existe con estado false, pero hago de cuenta que no existe
            $exits = $this->catalogRepository->findByIdAndStatus($id, true);
            if(!isset($exits)){
                throw new GenericException("No existe el registro con id --> '$id'");
            }

            $id = $this->catalogRepository->delete($id);
            $exits = $this->catalogRepository->isActiveById($id);

            if(isset($exits)){
                throw new GenericException("No se pudo eliminar el cliente con id --> '$id'");
            }
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

            $response = $this->catalogRepository->search($key, $value);

            if(!isset($response)){
                throw new GenericException("No existen registros!", 404);
            }

            return $response;
        }
    }
?>