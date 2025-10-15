<?php

use Phalcon\Mvc\Router\Group;

$router = $di->getRouter();

$group = new Group();

$group->setPrefix('/api');


$group->addGet('/products', [
    'controller' => 'product',
    'action' => 'index'
]);

$group->addGet('/products/{id:[0-9]+}', [
    'controller' => 'product',
    'action' => 'show'
]);

$group->addPost('/products', [
    'controller' => 'product',
    'action'=> 'save'
]);

$group->addPut('/products/{id:[0-9]+}', [
    'controller' => 'product',
    'action'=> 'update'
]);

$group->addDelete('/products/{id:[0-9]+}', [
    'controller' => 'product',
    'action'=> 'delete'
]);


$router->mount($group);

// Define routes

// Handle the request
$router->handle($_SERVER['REQUEST_URI']);
