<?php

declare(strict_types=1);

namespace Suffi\PHPMetric\Model\Classes;

use Suffi\PHPMetric\Model\Classes\Interfaces\TraitCollectionInterface;
use Suffi\PHPMetric\Model\Classes\Interfaces\TraitInterface;

/**
 * Коллекция трейтов
 * Class TraitCollection
 */
class TraitCollection implements TraitCollectionInterface
{
    private array $items = [];

    /**
     * {@inheritDoc}
     */
    public function add(TraitInterface $trait): void
    {
        $this->items[$trait->getFullName()] = $trait;
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
    public function get(string $name): TraitInterface
    {
        if (!$this->has($name)) {
            throw new Exception("Trait not found");
        }
        return $this->items[$name];
    }

    /**
     * {@inheritDoc}
     */
    public function replace(string $name, TraitInterface $trait): void
    {
        if ($this->has($name)) {
            $this->items[$name] = $trait;
        }
    }
}
