<?php

namespace App\Services;

use App\Models\Orders;
use App\Models\OrderItems;
use App\Models\ClientAddresses;
use App\Models\Products;

use App\Exceptions\ModelNotFoundException;

class OrderService
{
    public function all(): array
    {
        $result = [];
        $orders = Orders::find();

        foreach ($orders as $order) {
            $orderArr = $order->toArray();
            $orderArr['items'] = $order->items ? $order->items->toArray() : [];
            $result[] = $orderArr;
        }

        return $result;
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
        
        $this->validateStock($data['items']);
        
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

        $this->saveOrderItems($order->id, $data['items']);

        return $order;
    }

    public function updateStatus(int $id, string $status): Orders
    {
        $order = $this->find($id);
        
        $order->shipping_status = $status;
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

    private function validateStock(array $items): void
    {
        foreach ($items as $item) {
            $product = Products::findFirst([
                'conditions' => 'id = :id:',
                'bind' => ['id' => $item['product_id']]
            ]);

            if (!$product) {
                throw new ModelNotFoundException("Product with ID {$item['product_id']} not found");
            }

            if ($product->stock < $item['quantity']) {
                throw new \Exception("Insufficient stock for product_id {$product->id}. Available: {$product->stock}, Requested: {$item['quantity']}", 422);
            }
        }
    }

    private function saveOrderItems(int $orderId, array $items): void
    {
        foreach ($items as $item) {
            $product = Products::findFirst([
                'conditions' => 'id = :id:',
                'bind' => ['id' => $item['product_id']]
            ]);

            $orderItem = new OrderItems();
            $orderItem->order_id = $orderId;
            $orderItem->product_id = $item['product_id'];
            $orderItem->quantity = $item['quantity'];
            $orderItem->save();

            $product->stock -= $item['quantity'];
            $product->save();
        }
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