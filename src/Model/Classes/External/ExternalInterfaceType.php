<?php

namespace Suffi\PHPMetric\Model\Classes\External;

use Suffi\PHPMetric\Model\Classes\InterfaceType;

class ExternalInterfaceType extends InterfaceType implements HavingUseCasesInterface
{
    use ExternalTrait;
}
