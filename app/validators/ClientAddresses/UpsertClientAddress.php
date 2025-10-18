<?php

namespace App\Validators\ClientAddresses;

use App\Validators\BaseValidator;

use Phalcon\Filter\Validation\Validator\PresenceOf;
use Phalcon\Filter\Validation\Validator\StringLength\Max;
use Phalcon\Filter\Validation\Validator\Callback;

use Phalcon\Messages\Message;

class UpsertClientAddress extends BaseValidator
{
    public function initialize()
    {
        $this->add(
            'addresses.delivery.street',
            new PresenceOf([
                'message' => 'Delivery street is required',
            ])
        );

        $this->add(
            'addresses.delivery.street',
            new Max([
                'max' => 255,
                'message' => 'Delivery street must not exceed 255 characters',
            ])
        );

        $this->add(
            'addresses.delivery.number',
            new PresenceOf([
                'message' => 'Delivery number is required',
            ])
        );

        $this->add(
            'addresses.delivery.number',
            new Max([
                'max' => 20,
                'message' => 'Delivery number must not exceed 20 characters',
            ])
        );

        $this->add(
            'addresses.delivery.neighborhood',
            new PresenceOf([
                'message' => 'Delivery neighborhood is required',
            ])
        );

        $this->add(
            'addresses.delivery.neighborhood',
            new Max([
                'max' => 100,
                'message' => 'Delivery neighborhood must not exceed 100 characters',
            ])
        );

        $this->add(
            'addresses.delivery.city',
            new PresenceOf([
                'message' => 'Delivery city is required',
            ])
        );

        $this->add(
            'addresses.delivery.city',
            new Max([
                'max' => 100,
                'message' => 'Delivery city must not exceed 100 characters',
            ])
        );

        $this->add(
            'addresses.delivery.state',
            new PresenceOf([
                'message' => 'Delivery state is required',
            ])
        );

        $this->add(
            'addresses.delivery.state',
            new Max([
                'max' => 50,
                'message' => 'Delivery state must not exceed 50 characters',
            ])
        );

        $this->add(
            'addresses.delivery.zip',
            new PresenceOf([
                'message' => 'Delivery zip code is required',
            ])
        );

        $this->add(
            'addresses.delivery.zip',
            new Max([
                'max' => 20,
                'message' => 'Delivery zip code must not exceed 20 characters',
            ])
        );

        $this->add(
            'addresses.delivery.country',
            new PresenceOf([
                'message' => 'Delivery country is required',
            ])
        );

        $this->add(
            'addresses.delivery.country',
            new Max([
                'max' => 50,
                'message' => 'Delivery country must not exceed 50 characters',
                'cancelOnFail' => true,
            ])
        );

        $this->add(
            'addresses',
            new Callback([
                'callback' => function ($data) {
                    $hasBilling = false;
                    $billingFields = [];
                    
                    foreach ($data as $key => $value) {
                        if (strpos($key, 'addresses.billing.') === 0) {
                            $hasBilling = true;
                            $field = str_replace('addresses.billing.', '', $key);
                            $billingFields[$field] = $value;
                        }
                    }
                    
                    if (!$hasBilling || empty($billingFields)) {
                        return true;
                    }
                    
                    $requiredFields = ['street', 'number', 'neighborhood', 'city', 'state', 'zip', 'country'];
                    $maxLengths = [
                        'street' => 255,
                        'number' => 20,
                        'neighborhood' => 100,
                        'city' => 100,
                        'state' => 50,
                        'zip' => 20,
                        'country' => 50
                    ];
                    
                    $hasErrors = false;
                    
                    foreach ($requiredFields as $field) {
                        if (empty($billingFields[$field])) {
                            $this->appendMessage(new Message("Billing {$field} is required", "addresses.billing.{$field}"));
                            $hasErrors = true;
                        }
                        
                        if (!empty($billingFields[$field]) && strlen($billingFields[$field]) > $maxLengths[$field]) {
                            $this->appendMessage(new Message("Billing {$field} must not exceed {$maxLengths[$field]} characters", "addresses.billing.{$field}"));
                            $hasErrors = true;
                        }
                    }
                    
                    return !$hasErrors;
                }
            ])
        );
    }
}
