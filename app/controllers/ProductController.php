<?php
declare(strict_types=1);

use Phalcon\Mvc\Controller;

use Phalcon\Http\Response;

use App\Traits\ApiResponse;

use App\Services\ProductService;

use App\Validators\ProductValidator;

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

        return $this->successResponse(
            [
                'products' => $products
            ],
            'Products fetched successfully'
        );
    }

    public function createAction(): Response
    {
        $requestData = $this->request->getJsonRawBody(true);

        $validator = new ProductValidator();
        $validator->validateData($requestData);

        $product = $this->productService->create($requestData);

        return $this->successResponse(
            ['product' => $product],
            'Product created successfully',
            201
        );
    }
}
