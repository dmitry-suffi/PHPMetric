<?php

declare(strict_types=1);

namespace Suffi\PHPMetric\Model\Classes\Interfaces;

/**
 * Интерфейс метода
 * Interface MethodInterface
 */
interface MethodInterface
{
    /**
     * Имя
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Флаг статического свойства
     *
     * @return bool
     */
    public function isStatic(): bool;

    /**
     * Флаг финального класса
     *
     * @return bool
     */
    public function isFinal(): bool;

    /**
     * Флаг абстракного класса
     *
     * @return bool
     */
    public function isAbstract(): bool;

    /**
     * Тип, к которому принадлежит метод
     *
     * @return TypeInterface
     */
    public function getType(): TypeInterface;
}
