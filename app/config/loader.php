<?php

$loader = new \Phalcon\Autoload\Loader();

$loader->setNamespaces(
    [
       'App\Traits'        => APP_PATH . '/traits',
       'App\Services'      => APP_PATH . '/services',
       'App\Models'        => $config->application->modelsDir,
    ]
)->register();

$loader->setDirectories(
    [
        $config->application->controllersDir,
        $config->application->modelsDir,
    ]
)->register();
