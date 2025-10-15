<?php
declare(strict_types=1);

use Phalcon\Mvc\Controller;

use Phalcon\Http\Response;

use App\Traits\ApiResponse;

use App\Services\ProductService;

use App\Validators\Products\SaveProductValidator;
use App\Validators\Products\UpdateProductValidator;

class ProductController extends Controller
{
    use ApiResponse;

    private ProductService $productService;
    
    public function initialize(): void
    {
        $this->productService = new ProductService();
    }
    
    public function indexAction(): Response
    {
        $products = $this->productService->all();

        return $this->successResponse(['products' => $products],
            'Products fetched successfully',
            200
        );
    }

    public function showAction(int $id): Response
    {
        $product = $this->productService->find($id);

        return $this->successResponse(['product' => $product],
            'Product fetched successfully',
            200
        );
    }

    public function saveAction(): Response
    {
        $requestData = $this->request->getJsonRawBody(true);

        $validator = new SaveProductValidator();
        $validator->validateData($requestData);

        $product = $this->productService->create($requestData);

        return $this->successResponse(
            ['product' => $product],
            'Product created successfully',
            201
        );
    }

    public function updateAction(int $id): Response
    {
        $requestData = $this->request->getJsonRawBody(true);

        $validator = new UpdateProductValidator();
        $validator->validateData($requestData);

        $product = $this->productService->update($id, $requestData);

        return $this->successResponse(
            ['product' => $product],
            'Product updated successfully',
            200
        );
    }

    public function deleteAction(int $id): Response
    {
        $this->productService->delete($id);

        return $this->successResponse(null,
            'Product deleted successfully',
            200
        );
    }
}
