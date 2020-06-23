<?php

declare(strict_types=1);

namespace Suffi\PHPMetric\Model\Classes\Interfaces;

/**
 * Интерфейс типа-интерфейса
 * Interface InterfaceInterface
 */
interface InterfaceInterface extends TypeInterface
{
    /**
     * Коллекция констант
     *
     * @return ConstantCollectionInterface
     */
    public function getConstants(): ConstantCollectionInterface;

    /**
     * Коллекция родительских интерфейсов
     *
     * @return InterfaceCollectionInterface
     */
    public function getExpands(): InterfaceCollectionInterface;
}
