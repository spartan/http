<?php

namespace Spartan\Http;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Request Pipeline
 *
 * @package Spartan\Http
 * @author  Iulian N. <iulian@spartanphp.com>
 * @license LICENSE MIT
 */
class Pipeline implements RequestHandlerInterface
{
    /**
     * @var PriorityQueue
     */
    protected PriorityQueue $queue;

    /**
     * Pipe constructor.
     *
     * @param mixed[] $middlewares Middlewares to process
     */
    public function __construct(array $middlewares)
    {
        $this->queue = new PriorityQueue();

        foreach ($middlewares as $name => $priority) {
            if (is_numeric($name)) {
                $this->queue()->insert($priority);
            } else {
                $this->queue()->insert($name, $priority);
            }
        }
    }

    /**
     * @return PriorityQueue
     */
    public function queue(): PriorityQueue
    {
        return $this->queue;
    }

    /**
     * Handle the request and return a response.
     *
     * @param ServerRequestInterface $request PSR-7 Request object
     *
     * @return ResponseInterface
     * @throws \ReflectionException
     * @throws \Spartan\Service\Exception\ContainerException
     * @throws \Spartan\Service\Exception\NotFoundException
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $middleware = $this->queue->extract();

        if (is_string($middleware)) {
            $middleware = $this->instance($middleware);
        } elseif ($middleware instanceof \Closure) {
            return $middleware($request, $this);
        }

        return $middleware->process($request, $this);
    }

    /**
     * @param string $class
     *
     * @return MiddlewareInterface|ResponseInterface
     * @throws \ReflectionException
     * @throws \Spartan\Service\Exception\ContainerException
     * @throws \Spartan\Service\Exception\NotFoundException
     */
    public function instance(string $class)
    {
        if (function_exists('container')) {
            return container()->get($class);
        }

        return new $class;
    }
}
