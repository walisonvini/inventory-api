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
}