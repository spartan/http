<?php

namespace Spartan\Http;

use Laminas\Diactoros\MessageTrait as DiactorosMessageTrait;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\StreamInterface;
use Spartan\Http\Definition\MessageTrait;

class Message implements MessageInterface
{
    use DiactorosMessageTrait;
    use MessageTrait;

    /**
     * Message constructor.
     *
     * @param mixed[]              $headers
     * @param StreamInterface|null $stream
     * @param string               $protocol
     */
    public function __construct(array $headers = [], StreamInterface $stream = null, $protocol = '1.1')
    {
        $this->withHeaders($headers);
        $this->withProtocolVersion($protocol);
        $this->withBody($this->getStream($stream ?: 'php://memory', 'r+'));
    }
}
