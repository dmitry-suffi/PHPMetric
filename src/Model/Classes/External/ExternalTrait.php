<?php

namespace Suffi\PHPMetric\Model\Classes\External;
/**
 * For HavingUseCasesInterface
 * Trait ExternalTrait
 */
trait ExternalTrait
{
    /** @var UseCaseInterface[] */
    protected array $useCased = [];

    public function addUseCase(UseCaseInterface $useCase)
    {
        $this->useCased[] = $useCase;
    }

    public function getUseCases(): array
    {
        return $this->useCased;
    }

    public function isDefined(): bool
    {
        foreach ($this->useCased as $useCase) {
            if (!$useCase->isDefined()) {
                return false;
            }
        }

        return $this->useCased ? true : false;
    }
}
