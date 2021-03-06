<?php

declare(strict_types=1);

namespace Suffi\PHPMetric\Model\Classes\External;

use Suffi\PHPMetric\Model\Classes\TraitType;

class ExternalTraitType extends TraitType implements HavingUseCasesInterface
{
    use ExternalTrait;
}
