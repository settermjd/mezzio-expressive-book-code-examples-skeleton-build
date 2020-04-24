<?php

namespace Movies\Middleware;

use Mezzio\Router\RouteResult;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;

/**
 * Class LoggingMiddleware
 * @package Movies\Middleware
 */
class LoggingMiddleware implements MiddlewareInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * LoggingMiddleware constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * {@inheritDoc}
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // Log the requested route
        $this->logger->info(
            ($request->getAttribute(RouteResult::class))
                ->getMatchedRouteName()
        );

        // All processing of any further middleware in the pipeline
        return $handler->process($request, $handler);
    }
}
