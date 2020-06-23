<?php

declare(strict_types=1);

namespace Suffi\PHPMetric\Model\Classes\External;

use Suffi\PHPMetric\Model\Classes\Interfaces\TypeInterface;

/**
 * Интерфейс использования внешнего типа
 * Interface UseCaseInterface
 */
interface UseCaseInterface
{
    /**
     * Используемый тип
     *
     * @return TypeInterface
     */
    public function getType(): TypeInterface;

    /**
     * Определить использование новым типом
     *
     * @param  TypeInterface $type
     * @return mixed
     */
    public function define(TypeInterface $type);

    /**
     * Флаг, что использование задано
     *
     * @return bool
     */
    public function isDefined(): bool;
}
