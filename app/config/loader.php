<?php

$loader = new \Phalcon\Autoload\Loader();

$loader->setNamespaces(
    [
       'App\Controllers'   => $config->application->controllersDir,
       'App\Models'        => $config->application->modelsDir,
       'App\Traits'        => APP_PATH . '/traits',
       'App\Services'      => APP_PATH . '/services',
       'App\Validators'    => APP_PATH . '/validators',
       'App\Exceptions'    => APP_PATH . '/exceptions',
    ]
)->register();

$loader->setDirectories(
    [
        $config->application->controllersDir,
        $config->application->modelsDir,
    ]
)->register();
