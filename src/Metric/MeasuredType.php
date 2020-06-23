<?php

declare(strict_types=1);

namespace Suffi\PHPMetric\Metric;

use Suffi\PHPMetric\Model\Classes\Interfaces\TypeInterface;

class MeasuredType
{
    private TypeInterface $type;

    /**
     * @var MetricValue[]
     */
    private array $values = [];

    /**
     * MeasuredType constructor.
     *
     * @param TypeInterface $type
     */
    public function __construct(TypeInterface $type)
    {
        $this->type = $type;
    }

    /**
     * @return TypeInterface
     */
    public function getType(): TypeInterface
    {
        return $this->type;
    }

    public function addValue(MetricValue $value): void
    {
        $this->values[$value->getName()] = $value;
    }

    public function hasValue(string $name): bool
    {
        return isset($this->values[$name]);
    }

    public function getValue(string $name): MetricValue
    {
        if (!isset($this->values[$name])) {
            throw new \Exception('Value not defined');
        }
        return $this->values[$name];
    }
}
