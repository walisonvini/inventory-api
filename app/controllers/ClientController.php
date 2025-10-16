<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Traits\ApiResponse;

use App\Services\ClientService;

use App\Validators\Clients\SaveClientValidator;
use App\Validators\Clients\UpdateClientValidator;

class ClientController extends \Phalcon\Mvc\Controller
{
    use ApiResponse;

    private ClientService $clientService;
    
    public function initialize(): void
    {
        $this->clientService = new ClientService();
    }

    public function saveAction()
    {
        $requestData = $this->request->getJsonRawBody(true);

        $validator = new SaveClientValidator();
        $validator->validateData($requestData);

        $client = $this->clientService->create($requestData);

        return $this->successResponse(
            ['client' => $client],
            'Client created successfully',
            201
        );
    }

    public function indexAction()
    {
        $clients = $this->clientService->all();

        return $this->successResponse(['clients' => $clients], 'Clients fetched successfully', 200);
    }

    public function showAction(int $id)
    {
        $client = $this->clientService->find($id);

        return $this->successResponse(['client' => $client], 'Client fetched successfully', 200);
    }

    public function updateAction(int $id)
    {
        $requestData = $this->request->getJsonRawBody(true);

        $validator = new UpdateClientValidator();
        $validator->validateData($requestData);

        $client = $this->clientService->update($id, $requestData);

        return $this->successResponse(['client' => $client], 'Client updated successfully', 200);
    }

    public function deleteAction(int $id)
    {
        $this->clientService->delete($id);

        return $this->successResponse(null, 'Client deleted successfully', 200);
    }

}

