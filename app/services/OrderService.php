<?php

namespace App\Services;

use App\Models\Orders;
use App\Models\ClientAddresses;

use App\Exceptions\ModelNotFoundException;

class OrderService
{
    public function all(): array
    {
        return Orders::find()->toArray();
    }

    public function find(int $id): Orders
    {
        $order = Orders::findFirst([
            'conditions' => 'id = :id:',
            'bind'       => [
                'id' => $id,
            ],
        ]);

        if(!$order) {
            throw new ModelNotFoundException('Order not found');
        }

        return $order;
    }

    public function create(array $data): Orders
    {
        $this->validateAddressForClient($data['client_id'], $data['address_id']);
        
        $order = new Orders();
        $order->assign($data, [
            'client_id',
            'address_id', 
            'order_code',
            'carrier',
            'tracking_code',
            'shipping_status',
            'total_weight',
            'total_volume',
            'notes'
        ]);
        $order->save();

        $order->refresh();

        return $order;
    }

    public function cancel(int $id): Orders
    {
        $order = $this->find($id);
        
        if (!in_array($order->shipping_status, ['pending', 'checkout'])) {
            throw new \Exception('Order cannot be cancelled. Only orders with status "pending" or "checkout" can be cancelled.', 422);
        }
        
        $order->shipping_status = 'cancelled';
        $order->save();
        $order->refresh();
        
        return $order;
    }

    private function validateAddressForClient(int $clientId, int $addressId): void
    {
        $address = ClientAddresses::findFirst([
            'conditions' => 'id = :address_id: AND client_id = :client_id: AND label = :label:',
            'bind' => [
                'address_id' => $addressId,
                'client_id' => $clientId,
                'label' => 'delivery'
            ]
        ]);

        if (!$address) {
            throw new ModelNotFoundException('Address not found, does not belong to client, or is not a delivery address');
        }
    }
}