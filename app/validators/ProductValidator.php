<?php

namespace App\Validators;

use Phalcon\Filter\Validation\Validator\Numericality;
use Phalcon\Filter\Validation\Validator\PresenceOf;
use Phalcon\Filter\Validation\Validator\Uniqueness;
use Phalcon\Filter\Validation\Validator\StringLength\Max;

use App\Models\Products;

class ProductValidator extends BaseValidator
{
    public function initialize()
    {
        $this->add('name', new PresenceOf(['message' => 'The name is required']));
        $this->add('name', new Max(['max' => 255, 'message' => 'Name must be at most 255 characters']));

        $this->add('sku', new PresenceOf(['message' => 'The sku is required']));
        $this->add('sku', new Uniqueness(["model" => new Products(), 'message' => 'SKU must be unique']));
        $this->add('sku', new Max(['max' => 100, 'message' => 'SKU must be at most 100 characters']));

        $this->add('price', new PresenceOf(['message' => 'The price is required']));
        $this->add('price', new Numericality(['message' => 'Price must be a numeric value']));

        $this->add('stock', new PresenceOf(['message' => 'The stock is required']));
        $this->add('stock', new Numericality(['message' => 'Stock must be a numeric value']));
    }
}
