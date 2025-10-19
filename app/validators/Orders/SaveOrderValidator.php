<?php

namespace App\Validators\Orders;

use App\Validators\BaseValidator;

use Phalcon\Filter\Validation\Validator\PresenceOf;
use Phalcon\Filter\Validation\Validator\Uniqueness;
use Phalcon\Filter\Validation\Validator\StringLength\Max;
use Phalcon\Filter\Validation\Validator\Numericality;
use Phalcon\Filter\Validation\Validator\InclusionIn;
use Phalcon\Filter\Validation\Validator\Callback;

use Phalcon\Messages\Message;

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

        $this->add(
            'items',
            new Callback([
                'callback' => function ($data) {
                    $itemsByIndex = [];

                    foreach ($data as $key => $value) {
                        if (strpos($key, 'items.') === 0) {
                            $parts = explode('.', $key);
                            if (count($parts) >= 3) {
                                $index = $parts[1];
                                $field = $parts[2];
                                if (!isset($itemsByIndex[$index])) {
                                    $itemsByIndex[$index] = [];
                                }
                                $itemsByIndex[$index][$field] = $value;
                            }
                        }
                    }

                    $hasErrors = false;

                    if (empty($itemsByIndex)) {
                        $this->appendMessage(new Message('At least one item is required', 'items'));
                        return false;
                    }

                    foreach ($itemsByIndex as $index => $item) {
                        if (!isset($item['product_id']) || $item['product_id'] === '' || $item['product_id'] === null) {
                            $this->appendMessage(new Message('Product ID is required', "items.{$index}.product_id"));
                            $hasErrors = true;
                        } elseif (!is_numeric($item['product_id'])) {
                            $this->appendMessage(new Message('Product ID must be a numeric value', "items.{$index}.product_id"));
                            $hasErrors = true;
                        }

                        if (!isset($item['quantity']) || $item['quantity'] === '' || $item['quantity'] === null) {
                            $this->appendMessage(new Message('Quantity is required', "items.{$index}.quantity"));
                            $hasErrors = true;
                        } elseif (!is_numeric($item['quantity'])) {
                            $this->appendMessage(new Message('Quantity must be a numeric value', "items.{$index}.quantity"));
                            $hasErrors = true;
                        } elseif ((float) $item['quantity'] < 1) {
                            $this->appendMessage(new Message('Quantity must be at least 1', "items.{$index}.quantity"));
                            $hasErrors = true;
                        }
                    }

                    return !$hasErrors;
                }
            ])
        );
    }
}
