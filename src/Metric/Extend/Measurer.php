<?php

declare(strict_types=1);

namespace Suffi\PHPMetric\Metric\Extend;

use Suffi\PHPMetric\Metric\MeasuredCollection;
use Suffi\PHPMetric\Metric\MetricValue;
use Suffi\PHPMetric\Model\Classes\Interfaces\ClassInterface;
use Suffi\PHPMetric\Model\Classes\Interfaces\InterfaceInterface;
use Suffi\PHPMetric\Model\Classes\Interfaces\TraitInterface;

class Measurer extends \Suffi\PHPMetric\Metric\Measurer
{
    const TRAIT_NOC = 'TraitNOC';
    const INTERFACE_NOC = 'InterfaceNOC';
    const CLASS_NOC = 'ClassNOC';
    const CLASS_DIT = 'ClassDIT';
    const NOC = 'NOC';

    public function measure(MeasuredCollection $measuredCollection): MeasuredCollection
    {
        $traitsNOC = [];
        $interfacesNOC = [];
        $classesNOC = [];
        $classesDIT = [];

        $classesWithParent = [];

        foreach ($measuredCollection->getAll() as $measuredType) {
            $type = $measuredType->getType();

            if ($type instanceof ClassInterface) {
                if ($type->getParent()) {
                    $parentFullName = $type->getParent()->getFullName();
                    $classesNOC[$parentFullName] = ($classesNOC[$parentFullName] ?? 0) + 1;
                    $classesWithParent[$type->getFullName()] = $type->getFullName();
                }

                $classesDIT[$type->getFullName()] = 0;

                foreach ($type->getExpands() as $interface) {
                    $interfacesNOC[$interface->getFullName()] = ($interfacesNOC[$interface->getFullName()] ?? 0) + 1;
                }
                foreach ($type->getTraits() as $trait) {
                    $traitsNOC[$trait->getFullName()] = ($traitsNOC[$trait->getFullName()] ?? 0) + 1;
                }
            }
        }

        while (count($classesWithParent) > 0) {
            foreach ($classesWithParent as $k => $name) {
                /** @var ClassInterface $type */
                $type = $measuredCollection->get($name)->getType();
                if (!isset($classesWithParent[$type->getParent()->getFullName()])) {
                    //@todo $classesDIT не содержит родителя, если он внешний
                    $classesDIT[$type->getFullName()] = ($classesDIT[$type->getParent()->getFullName()] ?? 0) + 1;
                    unset($classesWithParent[$k]);
                }
            }
        }

        foreach ($measuredCollection->getAll() as $measuredType) {
            $name = $measuredType->getType()->getFullName();
            $measuredType->addValue(new MetricValue(self::TRAIT_NOC, $traitsNOC[$name] ?? 0));
            $measuredType->addValue(new MetricValue(self::INTERFACE_NOC, $interfacesNOC[$name] ?? 0));
            $measuredType->addValue(new MetricValue(self::CLASS_NOC, $classesNOC[$name] ?? 0));
            $measuredType->addValue(new MetricValue(self::CLASS_DIT, $classesDIT[$name] ?? 0));

            $noc = 0;
            if ($measuredType->getType() instanceof InterfaceInterface) {
                $noc = $interfacesNOC[$name] ?? 0;
            }
            if ($measuredType->getType() instanceof TraitInterface) {
                $noc = $traitsNOC[$name] ?? 0;
            }
            if ($measuredType->getType() instanceof ClassInterface) {
                $noc = $classesNOC[$name] ?? 0;
            }
            $measuredType->addValue(new MetricValue(self::NOC, $noc));
        }

        return $measuredCollection;
    }
}
