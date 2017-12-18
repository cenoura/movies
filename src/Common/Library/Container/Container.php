<?php

namespace Cenoura\Common\Library\Container;

class Container implements \ArrayAccess
{
    private $keys = [];
    private $values = [];
    private $raw = [];
    private $frozen = [];

    public function __construct(array $values = [])
    {
        foreach ($values as $key => $value) {
            $this->offsetSet($key, $value);
        }
    }

    public function offsetSet($id, $value)
    {
        if (isset($this->frozen[$id])) {
            throw new \Exception('Identifier already frozen.');
        }

        $this->keys[$id] = true;
        $this->values[$id] = $value;
    }

    public function offsetGet($id)
    {
        if (!isset($this->keys[$id])) {
            throw new \Exception('Identifier doesn\'t exist.');
        }

        if (
            isset($this->raw[$id])
            || !is_object($this->values[$id])
            || !method_exists($this->values[$id], '__invoke')
        ) {
            return $this->values[$id];
        }

        $raw = $this->values[$id];
        $val = $this->values[$id] = $raw($this);
        $this->raw[$id] = $raw;

        $this->frozen[$id] = true;

        return $val;
    }

    public function offsetExists($id)
    {
        return isset($this->keys[$id]);
    }

    public function offsetUnset($id)
    {
        if (isset($this->keys[$id])) {
            unset(
                $this->values[$id],
                $this->frozen[$id],
                $this->raw[$id],
                $this->keys[$id]
            );
        }
    }

    public function raw($id)
    {
        if (!isset($this->keys[$id])) {
            throw new \Exception('Identifier doesn\'t exist.');
        }

        if (isset($this->raw[$id])) {
            return $this->raw[$id];
        }

        return $this->values[$id];
    }

    public function keys()
    {
        return array_keys($this->values);
    }

    public function register(ServiceProviderInterface $provider, array $values = [])
    {
        $provider->register($this);

        foreach ($values as $key => $value) {
            $this[$key] = $value;
        }

        return $this;
    }
}