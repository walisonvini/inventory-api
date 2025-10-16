<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\Products;

use App\Exceptions\ModelNotFoundException;

class ProductService
{
    public function all(): array
    {
        return Products::find()->toArray();
    }

    public function find(int $id): Products
    {
        $product = Products::findFirst($id);

        if(!$product)
            throw new ModelNotFoundException('Product not found');

        return $product;
    }

    public function create(array $data): Products
    {
        $product = new Products();
        $product->assign($data, ['name', 'sku', 'price', 'stock', 'description']);
        $product->save();

        $product->refresh();

        return $product;
    }

    public function update(int $id, array $data): Products
    {
        $product = $this->find($id);

        $product->assign($data, ['name', 'sku', 'price', 'stock', 'description']);
        $product->save();

        $product->refresh();

        return $product;
    }

    public function delete(int $id): bool
    {
        $product = $this->find($id);

        $product->delete();

        return true;
    }
}