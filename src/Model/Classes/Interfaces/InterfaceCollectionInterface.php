<?php

declare(strict_types=1);

namespace Suffi\PHPMetric\Model\Classes\Interfaces;

/**
 * Коллекция интерфейсов
 * Interface InterfaceCollectionInterface
 */
interface InterfaceCollectionInterface extends \Countable, \IteratorAggregate
{
    /**
     * Добавление интерфейса в коллекцию
     *
     * @param  InterfaceInterface $interface
     * @return void
     */
    public function add(InterfaceInterface $interface): void;

    /**
     * Проверка наличия интерфейса с именем $name в коллекции
     *
     * @param  string $name
     * @return bool
     */
    public function has(string $name): bool;

    /**
     * Получение интерфейса по имени
     *
     * @param  string $name
     * @return InterfaceInterface
     */
    public function get(string $name): InterfaceInterface;

    /**
     * Замена интерфейса, если существует в коллекции с именем $name
     *
     * @param string             $name
     * @param InterfaceInterface $interface
     */
    public function replace(string $name, InterfaceInterface $interface): void;
}
