<?php declare(strict_types=1);

namespace Suffi\PHPMetric\Model\Classes\Interfaces;

use Suffi\PHPMetric\Model\Classes\MethodCollection;

/**
 * Интерфейс типа (interface|class|trait)
 * Interface TypeInterface
 */
interface TypeInterface
{
    /**
     * Имя файла
     * @return string
     */
    public function getFileName(): string;

    /**
     * Название типа
     * @return string
     */
    public function getName(): string;

    /**
     * Полное название с namespace
     * @return string
     */
    public function getFullName(): string;

    /**
     * Коллекция методов
     * @return MethodCollection
     */
    public function getMethods(): MethodCollection;
}
