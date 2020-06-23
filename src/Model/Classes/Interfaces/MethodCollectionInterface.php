<?php

declare(strict_types=1);

namespace Suffi\PHPMetric\Model\Classes\Interfaces;

/**
 * Коллекция методов
 * Interface MethodCollectionInterface
 */
interface MethodCollectionInterface extends \Countable, \IteratorAggregate
{
    /**
     * Добавление метода в коллекцию
     *
     * @param  MethodInterface $method
     * @return void
     */
    public function add(MethodInterface $method): void;

    /**
     * Проверка наличия метода с именем $name в коллекции
     *
     * @param  string $name
     * @return bool
     */
    public function has(string $name): bool;

    /**
     * Получение метода по имени
     *
     * @param  string $name
     * @return MethodInterface
     */
    public function get(string $name): MethodInterface;
}
