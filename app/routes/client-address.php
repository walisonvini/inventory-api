<?php

$apiGroup->addGet('/clients/{client_id:[0-9]+}/addresses', [
    'controller' => 'App\Controllers\ClientAddress',
    'action' => 'index'
]);

$apiGroup->addPost('/clients/{client_id:[0-9]+}/addresses', [
    'controller' => 'App\Controllers\ClientAddress',
    'action' => 'upsert'
]);