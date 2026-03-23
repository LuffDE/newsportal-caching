<?php

namespace App\DTO\Factory;

use App\Exception\MethodNotFoundException;
use App\Util\Reflection;
use DateTime;
use DateTimeInterface;
use ReflectionException;
use Throwable;

class Hydrator
{
    /**
     * @throws ReflectionException
     */
    public static function hydrate(object $object, array $data): void
    {
        $reflection = new Reflection($object);
        foreach ($reflection->getPropertyNames() as $property) {
            if (!array_key_exists($property, $data)) {
                continue;
            }
            $setter = 'set' . ucfirst($property);
            if (!method_exists($object, $setter)) {
                continue;
            }
            try {
                $method = $reflection->getMethod($setter);
            } catch (MethodNotFoundException $e) {
                continue;
            }

            $params = $method->getParameters();
            if (count($params) !== 1) {
                continue;
            }
            $expectedType = $params[0]->getType();
            $value = $data[$property];

            if ($expectedType === null) {
                $method->invoke($object, $value);
            }

            $expectedTypeName = $expectedType->getName();
            if ($expectedType->isBuiltin()) {
                if (gettype($value) === $expectedTypeName) {
                    $method->invoke($object, $value);
                } elseif ($expectedTypeName === 'string' && is_numeric($value)) {
                    $method->invoke($object, (string)$value);
                }
            } elseif (is_a($expectedTypeName, DateTimeInterface::class, true)) {
                try {
                    if ($value instanceof DateTimeInterface) {
                        $method->invoke($object, $value);
                    } else {
                        $method->invoke($object, new DateTime($value));
                    }
                } catch (Throwable) {
                    continue;
                }
            }
        }
    }
}