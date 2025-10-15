<?php

namespace App\Exceptions;

use Phalcon\Mvc\Model\Exception;

class ModelNotFoundException extends Exception 
{
    public function __construct($message = 'Resource not found', $code = 404, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
