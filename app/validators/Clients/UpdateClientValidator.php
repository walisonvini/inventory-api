<?php

namespace App\Validators\Clients;

use App\Validators\BaseValidator;

use Phalcon\Filter\Validation\Validator\PresenceOf;
use Phalcon\Filter\Validation\Validator\Email;
use Phalcon\Filter\Validation\Validator\Uniqueness;
use Phalcon\Filter\Validation\Validator\StringLength\Max;

use App\Models\Clients;

class UpdateClientValidator extends BaseValidator
{
    public function initialize()
    {
        $this->add(
            'full_name',
            new Max([
                'max' => 150,
                'message' => 'Full name must not exceed 150 characters',
                'allowEmpty' => true,
            ])
        );

        $this->add(
            'email',
            new Email([
                'message' => 'Email must be a valid email address',
                'allowEmpty' => true,
            ])
        );

        $this->add(
            'email',
            new Uniqueness([
                'model' => new Clients(),
                'message' => 'This email is already registered',
                'allowEmpty' => true,
            ])
        );

        $this->add(
            'phone',
            new Max([
                'max' => 15,
                'message' => 'Phone number must not exceed 15 characters',
                'allowEmpty' => true,
            ])
        );

        $this->add(
            'document',
            new Max([
                'max' => 20,
                'message' => 'Document must not exceed 20 characters',
                'allowEmpty' => true,
            ])
        );
    }
}
