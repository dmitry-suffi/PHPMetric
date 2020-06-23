<?php

declare(strict_types=1);

namespace Suffi\PHPMetric\View;

class File
{
    /**
     * @var TypeContainer[]
     */
    private array $types = [];

    /**
     * File constructor.
     *
     * @param TypeContainer[] $types
     */
    public function __construct(array $types)
    {
        $this->types = $types;
    }

    /**
     * @return TypeContainer[]
     */
    public function getTypes(): array
    {
        return $this->types;
    }
}
