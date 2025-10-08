<?php
declare(strict_types=1);

use Phalcon\Mvc\Controller;

use App\Traits\ApiResponse;
use App\Services\ProductService;

use Phalcon\Http\Response;

class ProductController extends Controller
{
    use ApiResponse;

    private ProductService $productService;
    public function onConstruct(): void
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
}
