<?php

$apiGroup->addGet('/clients', [
    'controller' => 'App\Controllers\Client',
    'action' => 'index'
]);

$apiGroup->addGet('/clients/{id:[0-9]+}', [
    'controller' => 'App\Controllers\Client',
    'action' => 'show'
]);

$apiGroup->addPost('/clients', [
    'controller' => 'App\Controllers\Client',
    'action' => 'save'
]);

$apiGroup->addPut('/clients/{id:[0-9]+}', [
    'controller' => 'App\Controllers\Client',
    'action' => 'update'
]);

$apiGroup->addDelete('/clients/{id:[0-9]+}', [
    'controller' => 'App\Controllers\Client',
    'action' => 'delete'
]);