<?php declare(strict_types=1);

namespace Suffi\PHPMetric\Model\Classes\Interfaces;

/**
 * Свойство
 * Interface PropertyInterface
 */
interface PropertyInterface
{
    /**
     * Имя
     * @return string
     */
    public function getName(): string;

    /**
     * Флаг статического свойства
     * @return bool
     */
    public function isStatic(): bool;

    /**
     * Тип, к которому принадлежит свойство
     * @return TypeInterface
     */
    public function getType(): TypeInterface;
}
