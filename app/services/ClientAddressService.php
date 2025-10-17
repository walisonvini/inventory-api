<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\ClientAddresses;

use App\Services\ClientService;

use App\Exceptions\ModelNotFoundException;

class ClientAddressService
{
    private $clietService;

    public function __construct()
    {   
        $this->clietService = new ClientService();
    }
    
    public function find(int $id): ClientAddresses
    {
        $client_address = ClientAddresses::findFirst($id);

        if (!$client_address) {
            throw new ModelNotFoundException('Address not found');
        }

        return $client_address;
    }

    public function findByClient(int $client_id): array
    {
        $client = $this->clietService->find($client_id);

        $addresses = $client->addresses;

        $delivery = null;
        $billing = null;

        if ($addresses) {
            foreach ($addresses as $address) {
                if ($address->label === 'delivery') {
                    $delivery = $address->toArray();
                } elseif ($address->label === 'billing') {
                    $billing = $address->toArray();
                }
            }
        }

        return [
            'delivery' => $delivery,
            'billing' => $billing,
        ];
    }

    public function upsert(int $client_id, array $data): array
    {
        $this->clietService->find($client_id);

        $deliveryPayload = $data['addresses']['delivery'] ?? null;
        $billingPayload = $data['addresses']['billing'] ?? null;

        if (!$billingPayload && $deliveryPayload) {
            $billingPayload = $deliveryPayload;
        }

        $deliveryAddress = null;
        $billingAddress = null;

        if ($deliveryPayload) {
            $deliveryPayload['label'] = 'delivery';
            $existingDelivery = $this->findByClientAndLabel($client_id, 'delivery');
            if ($existingDelivery) {
                $deliveryPayload['id'] = (int)$existingDelivery->id;
                $deliveryAddress = $this->update((int)$existingDelivery->id, $deliveryPayload);
            } else {
                $deliveryAddress = $this->create($client_id, $deliveryPayload);
            }
        }

        if ($billingPayload) {
            $billingPayload['label'] = 'billing';
            $existingBilling = $this->findByClientAndLabel($client_id, 'billing');
            if ($existingBilling) {
                $billingPayload['id'] = (int)$existingBilling->id;
                $billingAddress = $this->update((int)$existingBilling->id, $billingPayload);
            } else {
                $billingAddress = $this->create($client_id, $billingPayload);
            }
        }

        return [
            'delivery' => $deliveryAddress,
            'billing' => $billingAddress
        ];
    }

    private function findByClientAndLabel(int $client_id, string $label): ?ClientAddresses
    {
        return ClientAddresses::findFirst([
            'conditions' => 'client_id = :client_id: AND label = :label:',
            'bind' => [
                'client_id' => $client_id,
                'label' => $label,
            ],
        ]) ?: null;
    }

    private function create(int $client_id, array $data): ClientAddresses
    {
        $address = new ClientAddresses();

        $address->assign(
            $data,
            [
                'label',
                'street',
                'number',
                'neighborhood',
                'city',
                'state',
                'zip',
                'country',
            ]
        );

        $address->client_id = $client_id;

        $address->save();

        $address->refresh();

        return $address;
    }

    public function update(int $id, array $data): ClientAddresses
    {
        $address = $this->find($id);

        $address->assign(
            $data,
            [
                'label',
                'street',
                'number',
                'neighborhood',
                'city',
                'state',
                'zip',
                'country',
            ]
        );

        $address->save();

        $address->refresh();

        return $address;
    }
}

