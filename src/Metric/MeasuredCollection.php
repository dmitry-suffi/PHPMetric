<?php declare(strict_types=1);

namespace Suffi\PHPMetric\Metric;

use Suffi\PHPMetric\Model\Classes\Exception;

class MeasuredCollection
{
    /** @var MeasuredType[] */
    private array $types = [];

    public function addMeasuredType(MeasuredType $measuredType)
    {
        $this->types[$measuredType->getType()->getFullName()] = $measuredType;
    }

    public function getAll(): array
    {
        return $this->types;
    }

    public function has(string $name): bool
    {
        return isset($this->types[$name]);
    }

    public function get(string $name): MeasuredType
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
