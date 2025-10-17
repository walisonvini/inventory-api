<?php
declare(strict_types=1);

namespace App\Controllers;

use Phalcon\Http\Response;

use App\Services\ClientService;
use App\Services\ClientAddressService;

use App\Traits\ApiResponse;

class ClientAddressController extends \Phalcon\Mvc\Controller
{
    use ApiResponse;

    private ClientService $clientService;
    private ClientAddressService $clientAddressService;
    
    public function initialize(): void
    {
        $this->clientService = new ClientService();
        $this->clientAddressService = new ClientAddressService();
    }

    public function indexAction(int $client_id): Response
    {
        $address = $this->clientAddressService->findByClient($client_id);

        return $this->successResponse(
            ['addresses' => $address],
            'Client addresses retrieved successfully',
            200
        );
    }

    public function upsertAction(int $client_id): Response
    {
        $requestData = $this->request->getJsonRawBody(true);

        $address = $this->clientAddressService->upsert($client_id, $requestData);

        return $this->successResponse(
            ['addresses' => $address],
            'Client addresses saved successfully',
            201
        );
    }

}

