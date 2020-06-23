<?php declare(strict_types=1);

namespace Suffi\PHPMetric\Metric;

class MetricValue
{
    private $value;

    private string $name;

    /**
     * MetricValue constructor.
     * @param mixed $value
     * @param string $name
     */
    public function __construct(string $name, $value)
    {
        $this->value = $value;
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
