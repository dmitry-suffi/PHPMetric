<?php declare(strict_types=1);

namespace Suffi\PHPMetric\Model\Classes\Interfaces;

/**
 * Интерфейс константы
 * Interface ConstantInterface
 */
interface ConstantInterface
{
    /**
     * Имя константы
     * @return string
     */
    public function getName(): string;

    /**
     * Тип, к которому принадлежит константа
     * @return TypeInterface
     */
    public function getType(): TypeInterface;
}
