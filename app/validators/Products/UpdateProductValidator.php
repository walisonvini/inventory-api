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
        $this->add(
            'name',
            new Max([
                'max' => 255,
                'message' => 'Name must not exceed 255 characters',
                'allowEmpty' => true,
            ])
        );

        $this->add(
            'sku',
            new Uniqueness([
                'model' => new Products(),
                'message' => 'This SKU is already in use',
                'allowEmpty' => true,
            ])
        );

        $this->add(
            'sku',
            new Max([
                'max' => 100,
                'message' => 'SKU must not exceed 100 characters',
                'allowEmpty' => true,
            ])
        );

        $this->add(
            'price',
            new Numericality([
                'message' => 'Price must be a numeric value',
                'allowEmpty' => true,
            ])
        );

        $this->add(
            'stock',
            new Numericality([
                'message' => 'Stock must be a numeric value',
                'allowEmpty' => true,
            ])
        );
    }
}
