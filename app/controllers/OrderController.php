<?php
declare(strict_types=1);

namespace App\Controllers;

use Phalcon\Http\Response;

use App\Validators\Orders\SaveOrderValidator;

use App\Services\OrderService;

use App\Traits\ApiResponse;

class OrderController extends \Phalcon\Mvc\Controller
{
    use ApiResponse;

    private OrderService $orderService;
    
    public function initialize(): void
    {
        $this->orderService = new OrderService();
    }

    public function indexAction(): Response
    {
        $orders = $this->orderService->all();

        return $this->successResponse(['orders' => $orders],
            'Orders fetched successfully',
            200
        );
    }

    public function showAction(int $id): Response
    {
        $order = $this->orderService->find($id);

        return $this->successResponse(['order' => $order],
            'Order fetched successfully',
            200
        );
    }

    public function saveAction(): Response
    {
        $requestData = $this->request->getJsonRawBody(true);

        $validator = new SaveOrderValidator();
        $validator->validateData($requestData);

        $order = $this->orderService->create($requestData);

        return $this->successResponse(
            ['order' => $order],
            'Order created successfully',
            201
        );
    }

    public function cancelAction(int $id): Response
    {
        $order = $this->orderService->cancel($id);

        return $this->successResponse(
            ['order' => $order],
            'Order cancelled successfully',
            200
        );
    }

}

