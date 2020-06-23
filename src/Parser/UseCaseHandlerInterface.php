<?php

declare(strict_types=1);

namespace Suffi\PHPMetric\Parser;

use Suffi\PHPMetric\Model\Classes\External\UseCaseInterface;
use Suffi\PHPMetric\Model\Classes\Interfaces\TypeInterface;

/**
 * Обработчик найденного использования
 * Interface UseCaseHandlerInterface
 */
interface UseCaseHandlerInterface
{
    /**
     * Проверка $object на соответствие типа, подходщего для данного использования
     *
     * @param  mixed $object
     * @return bool
     */
    public function checkType($object): bool;

    /**
     * Добавление $object к $currentType
     *
     * @param TypeInterface $currentType
     * @param TypeInterface $object
     */
    public function add(TypeInterface $currentType, TypeInterface $object): void;

    /**
     * Создание типа. Должен соответствовать проверке checkType
     *
     * @param  string $name
     * @param  string $fullName
     * @return TypeInterface
     */
    public function createType(string $name, string $fullName): TypeInterface;

    /**
     * Создание исользования
     *
     * @param  TypeInterface $currentType
     * @param  TypeInterface $object
     * @return UseCaseInterface
     */
    public function createUseCase(TypeInterface $currentType, TypeInterface $object): UseCaseInterface;
}
