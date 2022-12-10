<?php

namespace Spartan\Http;

use Http\Adapter\Guzzle7\Client;
use Laminas\Diactoros\{RequestFactory,
    Response,
    ResponseFactory,
    ServerRequestFactory,
    Stream,
    StreamFactory,
    UploadedFileFactory,
    UriFactory
};
use Psr\Container\ContainerInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\{RequestFactoryInterface,
    ResponseFactoryInterface,
    ResponseInterface,
    ServerRequestFactoryInterface,
    ServerRequestInterface,
    StreamFactoryInterface,
    StreamInterface,
    UploadedFileFactoryInterface,
    UriFactoryInterface
};
use Spartan\Service\Container;
use Spartan\Service\Definition\ProviderInterface;
use Spartan\Service\Pipeline;

/**
 * ServiceProvider Http
 *
 * @package Spartan\Http
 * @author  Iulian N. <iulian@spartanphp.com>
 * @license LICENSE MIT
 */
class ServiceProvider implements ProviderInterface
{
    /**
     * @return mixed[]
     */
    public function prototypes(): array
    {
        return [
            // aliases
            'client'                             => ClientInterface::class,
            'request'                            => ServerRequestInterface::class,
            'response'                           => ResponseInterface::class,
            'serverRequest.factory'              => ServerRequestFactoryInterface::class,
            'request.factory'                    => RequestFactoryInterface::class,
            'response.factory'                   => ResponseFactoryInterface::class,
            'uri.factory'                        => UriFactoryInterface::class,
            'stream.factory'                     => StreamFactoryInterface::class,
            'uploadedFile.factory'               => UploadedFileFactoryInterface::class,

            // PSR-7
            ServerRequestInterface::class        => function ($c) {
                return ServerRequestFactory::fromGlobals();
            },
            ResponseInterface::class             => Response::class,
            StreamInterface::class               => function ($c) {
                return new Stream('php://memory', 'rw');
            },

            // PSR-17
            ServerRequestFactoryInterface::class => ServerRequestFactory::class,
            RequestFactoryInterface::class       => RequestFactory::class,
            ResponseFactoryInterface::class      => ResponseFactory::class,
            UriFactoryInterface::class           => UriFactory::class,
            StreamFactoryInterface::class        => StreamFactory::class,
            UploadedFileFactoryInterface::class  => UploadedFileFactory::class,

            // PSR-18
            ClientInterface::class               => function ($c) {
                return new Client();
            },
        ];
    }

    /**
     * @param ContainerInterface $container
     * @param Pipeline           $handler
     *
     * @return ContainerInterface
     */
    public function process(ContainerInterface $container, Pipeline $handler): ContainerInterface
    {
        /** @var Container $container */
        return $handler->handle(
            $container->withBindings([], $this->prototypes())
        );
    }
}
