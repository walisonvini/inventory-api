<?php

namespace App\Validators;

use Phalcon\Filter\Validation;

use App\Exceptions\ValidatorException;

class BaseValidator extends Validation
{
    public function validateData($data)
    {
        if (is_array($data)) {
            $data = $this->flattenArray($data);
        }

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

    protected function flattenArray(array $array, string $prefix = ''): array
    {
        $result = [];

        foreach ($array as $key => $value) {
            $newKey = $prefix === '' ? $key : "$prefix.$key";

            if (is_array($value)) {
                $result += $this->flattenArray($value, $newKey);
            } else {
                $result[$newKey] = $value;
            }
        }

        return $result;
    }
}
