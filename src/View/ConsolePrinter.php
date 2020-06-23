<?php declare(strict_types=1);

namespace Suffi\PHPMetric\View;

use Suffi\PHPMetric\Model\Classes\Interfaces\TypeInterface;
use Suffi\PHPMetric\Model\TypesCollection;
use Symfony\Component\Console\Output\OutputInterface;

class ConsolePrinter
{
    private OutputInterface $output;

    /**
     * ConsolePrinter constructor.
     * @param OutputInterface $output
     */
    public function __construct(OutputInterface $output)
    {
        $this->output = $output;
    }

    public function print(TypesCollection $typesCollection): void
    {
        // @todo sort

        $types = [];
        foreach ($typesCollection->getTypes() as $type) {
            $types[$type->getFileName()][] = $type;
        }
        foreach ($types as $fileName => $types) {
            $this->output->writeln('');
            $this->output->writeln("Файл " . $fileName . ':');
            /** @var TypeInterface $type */
            foreach ($types as $type) {
                $this->output->writeln("  Класс " . $type->getName() . ':');
            }
        }
    }
}
