<?php
declare(strict_types=1);

use Phalcon\Di\FactoryDefault;

use App\Exceptions\ValidatorException;
use App\Exceptions\ModelNotFoundException;
use App\Traits\ApiResponse;

error_reporting(E_ALL);

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

try {
    /**
     * The FactoryDefault Dependency Injector automatically registers
     * the services that provide a full stack framework.
     */
    $di = new FactoryDefault();

    /**
     * Read services
     */
    include APP_PATH . '/config/services.php';

    /**
     * Handle routes
     */
    include APP_PATH . '/config/router.php';

    /**
     * Get config service for use in inline setup below
     */
    $config = $di->getConfig();

    /**
     * Include Autoloader
     */
    include APP_PATH . '/config/loader.php';

    /**
     * Handle the request
     */
    $application = new \Phalcon\Mvc\Application($di);

    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);

    echo $application->handle($_SERVER['REQUEST_URI'])->getContent();
} catch (ValidatorException $e) {
    $errors = json_decode($e->getMessage(), true);
    $response = (new class { use ApiResponse; })->errorResponse('Validation failed', $e->getCode(), $errors);
    http_response_code($e->getCode());
    echo $response->getContent();
} catch (ModelNotFoundException $e) {
    $response = (new class { use ApiResponse; })->errorResponse($e->getMessage(), $e->getCode());
    http_response_code($e->getCode());
    echo $response->getContent();
} catch (\Exception $e) {
    $code = $e->getCode() > 0 ? $e->getCode() : 500;
    $response = (new class { use ApiResponse; })->errorResponse($e->getMessage(), $code);
    http_response_code($code);
    echo $response->getContent();
}
