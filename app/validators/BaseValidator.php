<?php

namespace App\Validators;

use Phalcon\Filter\Validation;

use App\Exceptions\ValidatorException;

class BaseValidator extends Validation
{
    public function validateData($data)
    {
        $messages = parent::validate($data);

        if (count($messages)) {
            $errors = [];

            foreach ($messages as $message) {
                $errors[] = [
                    'field' => $message->getField(),
                    'message' => $message->getMessage()
                ];
            }

            throw new ValidatorException(json_encode($errors));
        }
    }
}
