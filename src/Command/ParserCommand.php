<?php

declare(strict_types=1);

namespace Suffi\PHPMetric\Command;

use PhpParser\NodeVisitor\NameResolver;
use Suffi\PHPMetric\Metric\Classes\Measurer;
use Suffi\PHPMetric\Parser\NodeVisitor;
use Suffi\PHPMetric\View\Html\Printer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;

class ParserCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'parse';

    protected function configure()
    {
        $this
            //  ->addArgument('config', InputArgument::REQUIRED)
            ->addArgument('path', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $path = $input->getArgument('path');

        [$typesCollection, $tree] = $this->load($output, $path, 'tests');

        if (!$typesCollection) {
            return 0;
        }

        //$printer = new ConsolePrinter($output);
        $printer = new Printer($output);
        $measure = new Measurer();
        $measuredCollection = $measure->measureTypes($typesCollection);
        $measure = new \Suffi\PHPMetric\Metric\Extend\Measurer();
        $measuredCollection = $measure->measure($measuredCollection);
        $printer->print($measuredCollection, 'index', $tree);
        return 0;
    }

    /**
     * @param  OutputInterface $output
     * @param  string          $path
     * @param  mixed $exclude
     * @return array|bool
     */
    private function load(OutputInterface $output, string $path, $exclude)
    {
        $output->writeln("Сканируется папка " . $path);

        $finder = new Finder();
        $finder->directories()
            ->in($path)
            ->sortByName(true);

        $tree = [];
        foreach ($finder as $file) {
            $tree[$file->getRelativePathname()] = [];
        }

        $finder = new Finder();

        $finder->files()
            ->in($path)
            ->name('/\.php$/')
            ->exclude($exclude)
            ->sortByName(true);

        $parser = (new \PhpParser\ParserFactory())->create(\PhpParser\ParserFactory::PREFER_PHP7);

        $traverser = new \PhpParser\NodeTraverser();

        $visitor = new NodeVisitor();
        $traverser->addVisitor(new NameResolver(null, ['replaceNodes' => true]));
        $traverser->addVisitor($visitor);

        foreach ($finder as $file) {
            $absoluteFilePath = $file->getRealPath();
            $fileNameWithExtension = $file->getRelativePathname();
            $tree[$file->getRelativePath()][] = $file->getRelativePathname();

            try {
                $visitor->setFile($fileNameWithExtension);
                $ast = $parser->parse(file_get_contents($absoluteFilePath));

                $ast = $traverser->traverse($ast);
            } catch (\Error $error) {
                $output->writeln("Parse error: {$error->getMessage()}");
                return false;
            }
        }

        $typesCollection = $visitor->getTypes();

        return [$typesCollection, $tree];
    }
}
