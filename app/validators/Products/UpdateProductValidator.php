<?php

namespace App\Validators\Products;

use App\Validators\BaseValidator;

use Phalcon\Filter\Validation\Validator\Numericality;
use Phalcon\Filter\Validation\Validator\Uniqueness;
use Phalcon\Filter\Validation\Validator\StringLength\Max;

use App\Models\Products;

class UpdateProductValidator extends BaseValidator
{
    public function initialize()
    {
        $this->add('name', new Max(['max' => 255, 'message' => ':field must be at most 255 characters']));
        
        $this->add('sku', new Uniqueness(['model' => new Products(), 'message' => ':field must be unique']));

        $this->add('sku', new Max(['max' => 100, 'message' => ':field must be at most 100 characters']));

        $this->add('price', new Numericality(['message' => ':field must be a numeric value']));

        $this->add('stock', new Numericality(['message' => ':field must be a numeric value']));
    }
}
