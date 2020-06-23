<?php declare(strict_types=1);

namespace Suffi\PHPMetric\Model\Classes;

use Suffi\PHPMetric\Model\Classes\Interfaces\InterfaceCollectionInterface;
use Suffi\PHPMetric\Model\Classes\Interfaces\InterfaceInterface;

/**
 * Коллекция интерфейсов
 * Class InterfaceCollection
 */
class InterfaceCollection implements InterfaceCollectionInterface
{
    private array $items = [];

    /**
     * {@inheritDoc}
     */
    public function add(InterfaceInterface $interface): void
    {
        $this->items[$interface->getFullName()] = $interface;
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
    public function get(string $name): InterfaceInterface
    {
        if (!$this->has($name)) {
            throw new Exception("Interface not found");
        }
        return $this->items[$name];
    }

    /**
     * {@inheritDoc}
     */
    public function replace(string $name, InterfaceInterface $interface): void
    {
        if ($this->has($name)) {
            $this->items[$name] = $interface;
        }
    }
}
