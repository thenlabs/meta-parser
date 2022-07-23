<?php
declare(strict_types=1);

namespace ThenLabs\MetaParser;

use ReflectionAttribute;
use ReflectionClass;
use ReflectionProperty;
use TypeError;

/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 */
class Metadata
{
    /**
     * @var mixed
     */
    protected $data;

    /**
     * @param array|object $data
     */
    public function __construct($data)
    {
        if (! is_array($data) && ! is_object($data)) {
            throw new TypeError('The data argument can be only of kind array or object.');
        }

        $this->data = $data;
    }

    public function has(string $name): bool
    {
        if (is_object($this->data)) {
            if ($this->data instanceof ReflectionAttribute) {
                $arguments = $this->data->getArguments();
                return array_key_exists($name, $arguments);
            } else {
                $class = new ReflectionClass($this->data);
                return $class->hasProperty($name);
            }
        } elseif (is_array($this->data)) {
            return array_key_exists($name, $this->data);
        }
    }

    public function get(string $name)
    {
        if (is_object($this->data)) {
            if ($this->data instanceof ReflectionAttribute) {
                $arguments = $this->data->getArguments();
                return $arguments[$name] ?? null;
            } else {
                $property = new ReflectionProperty($this->data, $name);
                $property->setAccessible(true);
                return $property->getValue($this->data);
            }
        } elseif (is_array($this->data)) {
            return $this->data[$name] ?? null;
        }
    }

    public function getData()
    {
        return $this->data;
    }
}
