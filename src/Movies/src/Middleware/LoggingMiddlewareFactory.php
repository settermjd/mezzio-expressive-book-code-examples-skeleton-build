<?php

namespace Movies\Services\Log;

use Interop\Container\ContainerInterface;
use Movies\Middleware\LoggingMiddleware;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class LoggingMiddlewareFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $log = new Logger('name');
        $log->pushHandler(new StreamHandler('./data/log/app.log'));

        return new LoggingMiddleware($log);
    }
}
