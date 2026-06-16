<?php

declare(strict_types=1);

namespace Softgeng\Paystack\Concerns;

use ReflectionClass;

trait HydratesFromArray
{
    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): static
    {
        $class = new ReflectionClass(static::class);
        $constructor = $class->getConstructor();

        if ($constructor === null) {
            return $class->newInstanceWithoutConstructor();
        }

        $arguments = [];

        foreach ($constructor->getParameters() as $parameter) {
            $name = $parameter->getName();

            if (array_key_exists($name, $data)) {
                $arguments[$name] = $data[$name];
            }
        }

        return new static(...$arguments);
    }
}
