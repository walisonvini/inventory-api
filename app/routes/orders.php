<?php

$apiGroup->addGet('/orders', [
    'controller' => 'App\Controllers\Order',
    'action' => 'index'
]);

$apiGroup->addGet('/orders/{id:[0-9]+}', [
    'controller' => 'App\Controllers\Order',
    'action' => 'show'
]);

$apiGroup->addPost('/orders', [
    'controller' => 'App\Controllers\Order',
    'action' => 'save'
]);

$apiGroup->addPatch('/orders/{id:[0-9]+}/cancel', [
    'controller' => 'App\Controllers\Order',
    'action' => 'cancel'
]);