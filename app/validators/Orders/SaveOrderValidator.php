<?php

namespace App\Validators\Orders;

use App\Validators\BaseValidator;

use Phalcon\Filter\Validation\Validator\PresenceOf;
use Phalcon\Filter\Validation\Validator\Uniqueness;
use Phalcon\Filter\Validation\Validator\StringLength\Max;
use Phalcon\Filter\Validation\Validator\Numericality;
use Phalcon\Filter\Validation\Validator\InclusionIn;

use App\Models\Orders;

class SaveOrderValidator extends BaseValidator
{
    public function initialize()
    {
        $this->add(
            'client_id',
            new PresenceOf([
                'message' => 'Client ID is required',
            ])
        );

        $this->add(
            'client_id',
            new Numericality([
                'message' => 'Client ID must be a numeric value',
            ])
        );

        $this->add(
            'address_id',
            new PresenceOf([
                'message' => 'Address ID is required',
            ])
        );

        $this->add(
            'address_id',
            new Numericality([
                'message' => 'Address ID must be a numeric value',
            ])
        );

        $this->add(
            'order_code',
            new PresenceOf([
                'message' => 'Order code is required',
            ])
        );

        $this->add(
            'order_code',
            new Uniqueness([
                'model' => new Orders(),
                'message' => 'This order code is already in use',
            ])
        );

        $this->add(
            'order_code',
            new Max([
                'max' => 100,
                'message' => 'Order code must not exceed 100 characters',
            ])
        );

        $this->add(
            'carrier',
            new Max([
                'max' => 100,
                'message' => 'Carrier must not exceed 100 characters',
            ])
        );

        $this->add(
            'tracking_code',
            new Max([
                'max' => 100,
                'message' => 'Tracking code must not exceed 100 characters',
            ])
        );

        $this->add(
            'shipping_status',
            new InclusionIn([
                'domain' => ['pending', 'checkout', 'in_transit', 'delivered', 'returned', 'cancelled'],
                'message' => 'Shipping status must be one of: pending, checkout, in_transit, delivered, returned, cancelled',
            ])
        );

        $this->add(
            'total_weight',
            new Numericality([
                'message' => 'Total weight must be a numeric value',
            ])
        );

        $this->add(
            'total_volume',
            new Numericality([
                'message' => 'Total volume must be a numeric value',
            ])
        );

        $this->add(
            'notes',
            new Max([
                'max' => 1000,
                'message' => 'Notes must not exceed 1000 characters',
            ])
        );
    }
}
