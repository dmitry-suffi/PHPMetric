<?php

declare(strict_types=1);

namespace Suffi\PHPMetric\Model\Classes\Interfaces;

/**
 * Интерфейс типа-трейт
 * Interface TraitInterface
 */
interface TraitInterface extends TypeInterface
{
    /**
     * Коллекция свойств
     *
     * @return PropertyCollectionInterface
     */
    public function getProperties(): PropertyCollectionInterface;

    /**
     * Используемые трейты
     *
     * @return TraitCollectionInterface
     */
    public function getTraits(): TraitCollectionInterface;
}
