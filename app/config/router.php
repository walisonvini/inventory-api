<?php

$router = $di->getRouter();

// Define routes

// Handle the request
$router->handle($_SERVER['REQUEST_URI']);
