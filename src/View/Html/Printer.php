<?php

declare(strict_types=1);

namespace Suffi\PHPMetric\View\Html;

use Suffi\PHPMetric\Metric\MeasuredCollection;
use Suffi\PHPMetric\Model\TypesCollection;
use Symfony\Component\Console\Output\OutputInterface;

class Printer
{
    private OutputInterface $output;

    /**
     * ConsolePrinter constructor.
     *
     * @param OutputInterface $output
     */
    public function __construct(OutputInterface $output)
    {
        $this->output = $output;
    }

    /**
     * @param  MeasuredCollection $measuredCollection
     * @param  string             $filename
     * @param  mixed[]            $tree
     * @throws \Throwable
     */
    public function print(MeasuredCollection $measuredCollection, string $filename, array $tree = []): void
    {
        $fileMeasureds = [];
        foreach ($measuredCollection->getAll() as $type) {
            $fileMeasureds[$type->getType()->getFileName()][] = $type;
        }

        $data = [
            'measuredCollection' => $measuredCollection,
            'fileMeasureds' => $fileMeasureds,
            'tree' => $tree
        ];

        ob_start();
        ob_implicit_flush(0);
        extract($data, EXTR_OVERWRITE);
        try {
            include 'Template/list.dist.php';
            $content = ob_get_clean();
        } catch (\Exception $e) {
            ob_clean();
            throw $e;
        } catch (\Throwable $e) {
            ob_clean();
            throw $e;
        }

        $filename = 'MetricReport/' . $filename . '.html';
        file_put_contents($filename, $content);

        $this->output->writeln("Записан файл " . $filename);
    }
}
