<?php

declare(strict_types=1);

namespace Suffi\PHPMetric\Model\Classes\Interfaces;

/**
 * Коллекция свойств
 * Interface PropertyCollectionInterface
 */
interface PropertyCollectionInterface extends \Countable, \IteratorAggregate
{
    /**
     * Добавление свойства в коллекцию
     *
     * @param  PropertyInterface $property
     * @return mixed
     */
    public function add(PropertyInterface $property);

    /**
     * Проверка наличия свойства с именем $name в коллекции
     *
     * @param  string $name
     * @return bool
     */
    public function has(string $name): bool;

    /**
     * Получение свойства по имени
     *
     * @param  string $name
     * @return PropertyInterface
     */
    public function get(string $name): PropertyInterface;
}
