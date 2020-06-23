<?php declare(strict_types=1);

namespace Suffi\PHPMetric\Model\Classes\Interfaces;

/**
 * Коллекция констант
 * Interface ConstantCollectionInterface
 */
interface ConstantCollectionInterface extends \Countable, \IteratorAggregate
{
    /**
     * Добавление константы в коллекцию
     * @param ConstantInterface $constant
     * @return void
     */
    public function add(ConstantInterface $constant): void;

    /**
     * Проверка наличия константы с именем $name в коллекции
     * @param string $name
     * @return bool
     */
    public function has(string $name): bool;

    /**
     * Получение константы по имени
     * @param string $name
     * @return ConstantInterface
     */
    public function get(string $name): ConstantInterface;
}
