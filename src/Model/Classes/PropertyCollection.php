<?php

declare(strict_types=1);

namespace Suffi\PHPMetric\Model\Classes;

use Suffi\PHPMetric\Model\Classes\Interfaces\PropertyCollectionInterface;
use Suffi\PHPMetric\Model\Classes\Interfaces\PropertyInterface;

/**
 * Коллекция свойств
 * Class PropertyCollection
 */
class PropertyCollection implements PropertyCollectionInterface
{
    private array $items = [];

    /**
     * {@inheritDoc}
     */
    public function add(PropertyInterface $property)
    {
        $this->items[$property->getName()] = $property;
    }

    /**
     * {@inheritDoc}
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->items);
    }

    /**
     * {@inheritDoc}
     */
    public function count()
    {
        return count($this->items);
    }

    /**
     * {@inheritDoc}
     */
    public function has(string $name): bool
    {
        return isset($this->items[$name]);
    }

    /**
     * {@inheritDoc}
     */
    public function get(string $name): PropertyInterface
    {
        if (!$this->has($name)) {
            throw new Exception("Property not found");
        }
        return $this->items[$name];
    }
}
