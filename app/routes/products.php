<?php

$apiGroup->addGet('/products', [
    'controller' => 'App\Controllers\Product',
    'action' => 'index'
]);

$apiGroup->addGet('/products/{id:[0-9]+}', [
    'controller' => 'App\Controllers\Product',
    'action' => 'show'
]);

$apiGroup->addPost('/products', [
    'controller' => 'App\Controllers\Product',
    'action' => 'save'
]);

$apiGroup->addPut('/products/{id:[0-9]+}', [
    'controller' => 'App\Controllers\Product',
    'action' => 'update'
]);

$apiGroup->addDelete('/products/{id:[0-9]+}', [
    'controller' => 'App\Controllers\Product',
    'action' => 'delete'
]);