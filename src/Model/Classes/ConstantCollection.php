<?php

declare(strict_types=1);

namespace Suffi\PHPMetric\Model\Classes;

use Suffi\PHPMetric\Model\Classes\Interfaces\ConstantCollectionInterface;
use Suffi\PHPMetric\Model\Classes\Interfaces\ConstantInterface;

/**
 * Коллекция констант
 * Class ConstantCollection
 */
class ConstantCollection implements ConstantCollectionInterface
{
    private array $items = [];

    /**
     * {@inheritDoc}
     */
    public function add(ConstantInterface $constant): void
    {
        $this->items[$constant->getName()] = $constant;
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
    public function get(string $name): ConstantInterface
    {
        if (!$this->has($name)) {
            throw new Exception("Constant not found");
        }
        return $this->items[$name];
    }
}
