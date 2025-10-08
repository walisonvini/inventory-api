<?php
declare(strict_types=1);

namespace App\Traits;

use Phalcon\Http\Response;

trait ApiResponse
{
    public function successResponse($data, string $message = 'Operation performed successfully', int $code = 200): Response
    {
        return $this->response
            ->setStatusCode($code)
            ->setJsonContent([
                'success' => true,
                'message' => $message,
                'data'    => $data
            ]);
    }

    public function errorResponse(string $message, int $code = 400, $errors = null): Response
    {
        $responseData = [
            'success' => false,
            'message' => $message,
        ];

        if ($errors) {
            $responseData['errors'] = $errors;
        }

        return $this->response
            ->setStatusCode($code)
            ->setJsonContent($responseData);
    }
}
