<?php

namespace Suffi\PHPMetric\Model\Classes\External;

use Suffi\PHPMetric\Model\Classes\ClassType;

class ExternalClassType extends ClassType implements HavingUseCasesInterface
{
    use ExternalTrait;
}
