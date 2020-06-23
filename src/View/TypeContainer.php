<?php

declare(strict_types=1);

namespace Suffi\PHPMetric\View;

use Suffi\PHPMetric\Model\Classes\Interfaces\TypeInterface;

class TypeContainer
{
    private TypeInterface $type;

    /**
     * TypeContainer constructor.
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

    /**
     * ...
     * Доп параметры
     */
}
