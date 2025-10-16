<?php

namespace App\Validators\Products;

use App\Validators\BaseValidator;

use Phalcon\Filter\Validation\Validator\Numericality;
use Phalcon\Filter\Validation\Validator\PresenceOf;
use Phalcon\Filter\Validation\Validator\Uniqueness;
use Phalcon\Filter\Validation\Validator\StringLength\Max;

use App\Models\Products;

class SaveProductValidator extends BaseValidator
{
    public function initialize()
    {
        $this->add(
            'name',
            new PresenceOf([
                'message' => 'Name is required',
            ])
        );

        $this->add(
            'name',
            new Max([
                'max' => 255,
                'message' => 'Name must not exceed 255 characters',
            ])
        );

        $this->add(
            'sku',
            new PresenceOf([
                'message' => 'SKU is required',
            ])
        );

        $this->add(
            'sku',
            new Uniqueness([
                'model' => new Products(),
                'message' => 'This SKU is already in use',
            ])
        );

        $this->add(
            'sku',
            new Max([
                'max' => 100,
                'message' => 'SKU must not exceed 100 characters',
            ])
        );

        $this->add(
            'price',
            new PresenceOf([
                'message' => 'Price is required',
            ])
        );

        $this->add(
            'price',
            new Numericality([
                'message' => 'Price must be a numeric value',
            ])
        );

        $this->add(
            'stock',
            new PresenceOf([
                'message' => 'Stock is required',
            ])
        );

        $this->add(
            'stock',
            new Numericality([
                'message' => 'Stock must be a numeric value',
            ])
        );
    }
}
