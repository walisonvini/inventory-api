<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\Products;

class ProductService
{
    public function all(): array
    {
        return Products::find()->toArray();
    }

    public function create(array $data): Products
    {
        $product = new Products();
        $product->assign($data, ['name', 'sku', 'price', 'stock', 'description']);
        $product->save();

        $product->refresh();

        return $product;
    }
}