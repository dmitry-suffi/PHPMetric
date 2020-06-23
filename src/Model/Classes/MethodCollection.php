<?php declare(strict_types=1);

namespace Suffi\PHPMetric\Model\Classes;

use Suffi\PHPMetric\Model\Classes\Interfaces\ConstantInterface;
use Suffi\PHPMetric\Model\Classes\Interfaces\MethodCollectionInterface;
use Suffi\PHPMetric\Model\Classes\Interfaces\MethodInterface;

/**
 * Коллекция методов
 * Class MethodCollection
 */
class MethodCollection implements MethodCollectionInterface
{
    private array $items = [];

    /**
     * {@inheritDoc}
     */
    public function add(MethodInterface $method): void
    {
        $this->items[$method->getName()] = $method;
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
    public function get(string $name): MethodInterface
    {
        if (!$this->has($name)) {
            throw new Exception("Method not found");
        }
        return $this->items[$name];
    }
}
