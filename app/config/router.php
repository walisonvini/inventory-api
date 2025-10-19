<?php

use Phalcon\Mvc\Router\Group;

$router = $di->getRouter();

$apiGroup = new Group();
$apiGroup->setPrefix('/api');

// Include routes
include __DIR__ . '/../routes/products.php';
include __DIR__ . '/../routes/clients.php';
include __DIR__ . '/../routes/client-address.php';
include __DIR__ . '/../routes/orders.php';

$router->mount($apiGroup);

$router->handle($_SERVER['REQUEST_URI']);
