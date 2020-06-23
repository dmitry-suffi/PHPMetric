<?php

namespace Suffi\PHPMetric\Model\Classes\External\UseCases;

use Suffi\PHPMetric\Model\Classes\External\UseCaseInterface;
use Suffi\PHPMetric\Model\Classes\Interfaces\TypeInterface;

abstract class UseCase implements UseCaseInterface
{
    protected TypeInterface $type;

    protected bool $isDefined = false;

    /**
     * UseCase constructor.
     * @param TypeInterface $type
     */
    public function __construct(TypeInterface $type)
    {
        $this->type = $type;
    }

    public function getType(): TypeInterface
    {
        return $this->type;
    }

    abstract public function define(TypeInterface $type);

    public function isDefined(): bool
    {
        return $this->isDefined;
    }
}
