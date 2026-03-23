<?php

namespace App\Util;

use App\Exception\MethodNotFoundException;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;

final class Reflection
{
    private object $object;
    private ReflectionClass $reflection;

    /**
     * @throws ReflectionException
     */
    public function __construct(string|object $object)
    {
        if (is_string($object) && class_exists($object)) {
            $object = new $object();
        }
        $this->object = $object;
        $this->reflection = new ReflectionClass($this->object);
    }

    public function getReflection(): ReflectionClass
    {
        return $this->reflection;
    }

    public function getPropertyNames(): array
    {
        $names = [];
        foreach ($this->reflection->getProperties() as $property) {
            $names[] = $property->getName();
        }
        return $names;
    }

    /**
     * @param string $methodName
     * @return ReflectionMethod
     * @throws MethodNotFoundException
     * @throws ReflectionException
     */
    public function getMethod(string $methodName): ReflectionMethod
    {
        if (!$this->reflection->hasMethod($methodName)) {
            throw new MethodNotFoundException($methodName);
        }
        return $this->reflection->getMethod($methodName);
    }

}
