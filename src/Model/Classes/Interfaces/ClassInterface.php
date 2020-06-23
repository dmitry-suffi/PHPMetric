<?php declare(strict_types=1);

namespace Suffi\PHPMetric\Model\Classes\Interfaces;

use Suffi\PHPMetric\Model\Classes\InterfaceCollection;

/**
 * Интерфейс типа-Класс (Class)
 * Interface ClassInterface
 */
interface ClassInterface extends TypeInterface
{
    /**
     * Коллекция констант
     * @return ConstantCollectionInterface
     */
    public function getConstants(): ConstantCollectionInterface;

    /**
     * Коллекция свойств
     * @return PropertyCollectionInterface
     */
    public function getProperties(): PropertyCollectionInterface;

    /**
     * Флаг финального класса
     * @return bool
     */
    public function isFinal(): bool;

    /**
     * Флаг абстракного класса
     * @return bool
     */
    public function isAbstract(): bool;

    /**
     * Родительские интерфейсы
     * @return InterfaceCollection
     */
    public function getExpands(): InterfaceCollection;

    /**
     * Родительский класс
     * @return null|ClassInterface
     */
    public function getParent(): ?ClassInterface;

    /**
     * Используемыве трейты
     * @return TraitCollectionInterface
     */
    public function getTraits(): TraitCollectionInterface;
}
