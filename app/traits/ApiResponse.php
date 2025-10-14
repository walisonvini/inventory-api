<?php
declare(strict_types=1);

namespace App\Traits;

use Phalcon\Http\Response;

trait ApiResponse
{
    protected function getResponse(): Response
    {
        if (property_exists($this, 'response') && $this->response instanceof Response) {
            return $this->response;
        }
        
        return new Response();
    }

    public function successResponse($data, string $message = 'Operation performed successfully', int $code = 200): Response
    {
        return $this->getResponse()
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

        return $this->getResponse()
            ->setStatusCode($code)
            ->setJsonContent($responseData);
    }
}
