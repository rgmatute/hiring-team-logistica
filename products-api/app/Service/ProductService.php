<?php 

    namespace App\Service;

    use App\Exceptions\GenericException;
    use App\Repository\ProductRepository;
    use Carbon\Carbon;
    use Exception;
    use App\Http\Helpers\Utils;
    use Illuminate\Pagination\LengthAwarePaginator;
    use App\Service\HistoryService;

    class ProductService
    {

        use Utils;
        private $productRepository;
        private $historyService;

        public function __construct(){
            $this->productRepository = new ProductRepository();
            $this->historyService = new HistoryService();
        }

        /**
         * @throws GenericException
         */
        public function findAll(): LengthAwarePaginator
        {
            try {
                return $this->productRepository->findAll();
            }catch (Exception $e){
                throw new GenericException($e->getMessage());
            }
        }

        /**
         * @throws GenericException
         */
        public function findById($id, $jwtInfo) {
            
            if(!is_numeric($id)){
                throw new GenericException('Necesita proporcionar un código numerico!', 400);
            }

            $response = $this->productRepository->findById($id);

            $this->historyService->created([
                'event' => 'findById',
                'product_id' => $id,
                'before' => json_encode([]),
                'after' => json_encode([])
            ], $jwtInfo);

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
                'serial_code'   =>  'required|string|max:100|unique:product',
                'name'          =>  'required|string|max:150',
                'price'         =>  'required|numeric',
                'stock'         =>  'required|integer',
                'catalog_id' => 'required|exists:catalog,id'
            ]);

            $inData['created_by']       = $jwtInfo->username ?? 'system';
            $inData['last_modified_by'] = $jwtInfo->username ?? 'system';

            $id = $this->productRepository->save($inData);

            $catalog = $this->productRepository->findById($id);

            if(!isset($catalog)) {
                throw new GenericException("No se pudo guardar el catalog!", 404);
            } else {

                unset($catalog['catalog']);

                $this->historyService->created([
                    'event' => 'created',
                    'product_id' => $id,
                    'before' => json_encode([]),
                    'after' => $catalog->toJson()
                ], $jwtInfo);
            }

            return $catalog;
        }

        /**
         * @throws GenericException
         */
        public function update($inData, $jwtInfo, $id)
        {
            $exits = $this->productRepository->findById($id);

            if(!isset($exits)){
                throw new GenericException("No existe el registro con Id $id!");
            }

            $update = $exits->toArray();

            $update['serial_code']  = $inData['serial_code']    ?? $update['serial_code'];
            $update['name']         = $inData['name']           ?? $update['name'];
            $update['description']  = $inData['description']    ?? $update['description'];
            $update['price']        = $inData['price']          ?? $update['price'];
            $update['iva']          = $inData['iva']            ?? $update['iva'];
            $update['discount']     = $inData['discount']       ?? $update['discount'];
            $update['resource_id']  = $inData['resource_id']    ?? $update['resource_id'];
            $update['stock']        = $inData['stock']          ?? $update['stock'];
            $update['status']       = $inData['status']         ?? $update['status'];
            $update['catalog_id']   = $inData['catalog_id']     ?? $update['catalog_id'];

            $update['last_modified_by']      = $jwtInfo->username ?? 'system';
            $update['updated_at']           = Carbon::now();
            
            unset($update['id'], $update['created_at'], $update['catalog']);

            // dd($update);

            $this->productRepository->update($update, $id);

            $product = $this->productRepository->findById($id);

            if(!isset($product)) {
                throw new GenericException("No se pudo guardar el catalog!", 404);
            } else {
                
                unset($product['catalog'], $exits['catalog']);

                $this->historyService->created([
                    'event' => 'updated',
                    'product_id' => $id,
                    'before' => $exits->toJson(),
                    'after' => $product->toJson()
                ], $jwtInfo);
            }

            return $product;
        }

        /**
         * @throws GenericException
         */
        public function delete($id, $jwtInfo)
        {
            // Por ahora el registro existe con estado false, pero hago de cuenta que no existe
            $exits = $this->productRepository->findByIdAndStatus($id, true);
            if(!isset($exits)){
                // 
                $exits = $this->productRepository->findByIdAndStatus($id, false);
                if(isset($exits)){
                    throw new GenericException("El producto con id --> '$id' está inactivo!");
                } else {
                    throw new GenericException("No existe el producto con id --> '$id'");
                }
            }

            $this->productRepository->delete($id);
            $exits = $this->productRepository->isActiveById($id);

            if(isset($exits)){
                throw new GenericException("No se pudo eliminar el producto con id --> '$id'");
            } else {
                $this->historyService->created([
                    'event' => 'deleted',
                    'product_id' => $id,
                    'before' => json_encode([]),
                    'after' => json_encode([])
                ], $jwtInfo);
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

            $response = $this->productRepository->search($key, $value);

            if(!isset($response)){
                throw new GenericException("No existen registros!", 404);
            }

            return $response;
        }
    }
?>