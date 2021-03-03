<?php

namespace Spartan\Http\Exception;

use Laminas\Diactoros\ServerRequestFactory;
use Psr\Http\Client\RequestExceptionInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Http Exception
 *
 * @package Spartan\Http
 * @author  Iulian N. <iulian@spartanphp.com>
 * @license LICENSE MIT
 */
class Http extends \Exception implements RequestExceptionInterface
{
    const CODE = 0;
    const TEXT = 'Error';

    /**
     * @var \Laminas\Diactoros\ServerRequest|ServerRequestInterface|null
     */
    protected $request;

    /**
     * @param string                      $message  Exception message
     * @param ServerRequestInterface|null $request
     * @param \Throwable|null             $previous Previous exception
     */
    public function __construct($message = '', ServerRequestInterface $request = null, \Throwable $previous = null)
    {
        if (!is_string($message)) {
            $message = json_encode($message);
        }

        parent::__construct(
            $message ?: (static::CODE . ' ' . static::TEXT),
            static::CODE,
            $previous
        );

        $this->request = $request ?: ServerRequestFactory::fromGlobals();
    }

    /**
     * {@inheritdoc}
     */
    public function getRequest(): ServerRequestInterface
    {
        if(!$this->request) {
            return \Spartan\Http\Http::request();
        }

        return $this->request;
    }
}
