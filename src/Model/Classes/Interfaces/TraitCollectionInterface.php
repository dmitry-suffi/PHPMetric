<?php declare(strict_types=1);

namespace Suffi\PHPMetric\Model\Classes\Interfaces;

/**
 * Коллекция трейтов
 * Interface TraitCollectionInterface
 */
interface TraitCollectionInterface extends \Countable, \IteratorAggregate
{
    /**
     * Добавление трейта в коллекцию
     * @param TraitInterface $trait
     * @return void
     */
    public function add(TraitInterface $trait): void;

    /**
     * Проверка наличия трейта с именем $name в коллекции
     * @param string $name
     * @return bool
     */
    public function has(string $name): bool;

    /**
     * Получение трейта по имени
     * @param string $name
     * @return TraitInterface
     */
    public function get(string $name): TraitInterface;

    /**
     * Замена трейта, если существует в коллекции с именем $name
     * @param string $name
     * @param TraitInterface $trait
     */
    public function replace(string $name, TraitInterface $trait): void;
}
