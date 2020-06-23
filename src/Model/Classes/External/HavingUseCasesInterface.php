<?php

declare(strict_types=1);

namespace Suffi\PHPMetric\Model\Classes\External;

/**
 * Внешний класс
 * Class ExternalType
 */
interface HavingUseCasesInterface
{
    /**
     * UseCases
     *
     * @return array
     */
    public function getUseCases(): array;

    /**
     * Флаг, что использование задано
     * Должен быть истиным только, если все UseCases заданы
     *
     * @return bool
     */
    public function isDefined(): bool;

    /**
     * @param  UseCaseInterface $useCase
     * @return mixed
     */
    public function addUseCase(UseCaseInterface $useCase);
}
