<?php

use Phalcon\Mvc\Router\Group;

$router = $di->getRouter();

$group = new Group();

$group->setPrefix('/api');
$group->addGet('/products', [
    'controller' => 'product',
    'action' => 'index'
]);
$router->mount($group);


// Define routes

// Handle the request
$router->handle($_SERVER['REQUEST_URI']);
