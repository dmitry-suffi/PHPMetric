<?php

declare(strict_types=1);

namespace Suffi\PHPMetric\Model;

use Suffi\PHPMetric\Model\Classes\Exception;
use Suffi\PHPMetric\Model\Classes\Interfaces\TypeInterface;

class TypesCollection
{
    private array $types = [];

    public function addType(TypeInterface $type): void
    {
        $this->types[$type->getFullName()] = $type;
    }

    /**
     * @return TypeInterface[]
     */
    public function getTypes(): array
    {
        return $this->types;
    }

    public function has(string $name): bool
    {
        return isset($this->types[$name]);
    }

    public function get(string $name): TypeInterface
    {
        if (!$this->has($name)) {
            throw new Exception("Type not found");
        }
        return $this->types[$name];
    }

    public function delete(string $name)
    {
        if ($this->has($name)) {
            unset($this->types[$name]);
        }
    }
}
