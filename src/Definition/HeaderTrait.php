<?php

namespace Spartan\Http\Definition;

trait HeaderTrait
{
    /**
     * @var mixed[]
     */
    protected array $directives = [];

    /**
     * HeaderTrait constructor.
     *
     * @param string|mixed[] $directives
     */
    public function __construct($directives)
    {
        $this->withDirectives((array)$directives);
    }

    /**
     * @param mixed[]|string $directives
     *
     * @return mixed|HeaderInterface
     */
    public static function from($directives)
    {
        if (is_array($directives)) {
            return new self($directives);
        }

        $directivesLine = (string)$directives;
        if (substr($directivesLine, 0, strlen(static::NAME)) === static::NAME) {
            [$name, $directivesLine] = explode(':', $directivesLine, 2);
        }

        $directives = [];
        foreach (explode(';', $directivesLine) as $item) {
            if (strpos($item, '=')) {
                [$key, $value] = explode('=', $item, 2);
                $directives[trim($key)] = trim($value, ' "');
            } else {
                $directives[] = trim($item, ' "');
            }
        }

        return new self($directives);
    }

    /**
     * @param mixed[] $directives
     *
     * @return $this
     */
    public function withDirectives(array $directives)
    {
        $this->directives = $directives + $this->directives;

        return $this;
    }

    /**
     * @return mixed[]
     */
    public function directives(): array
    {
        return $this->directives;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return static::NAME;
    }

    /**
     * @return string
     */
    public function value(): string
    {
        $directives = [];
        foreach ($this->directives as $directiveName => $directiveValue) {
            $directiveValue = trim($directiveValue, '"');
            if (is_numeric($directiveName)) {
                $directives[] = $directiveValue;
            } else {
                $directives[] = sprintf('%s="%s"', $directiveName, $directiveValue);
            }
        }

        return trim(implode('; ', $directives));
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return static::NAME . ': ' . $this->value();
    }
}
