<?php

namespace PhpGitHooks\Infrastructure\PhpUnit;

use PhpGitHooks\Infrastructure\Common\ProcessBuilderInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\ProcessBuilder;

/**
 * Class PhpUnitProcessBuilder.
 */
class PhpUnitProcessBuilder implements ProcessBuilderInterface
{
    /**
     * @return ProcessBuilder
     */
    public function getProcessBuilder()
    {
        $path = __DIR__.'/../../../../../../../bin/phpunit';
        $params = array('php', $path, getcwd());

        if (file_exists($path.'/app/phpunit.xml')
            || file_exists($path.'/app/phpunit.xml.dist')) {
            $params[] = '-c app';
        }

        return new ProcessBuilder($params);
    }

    /**
     * @param Process         $process
     * @param OutputInterface $outputInterface
     *
     * @return int
     */
    public function executeProcess(Process $process, OutputInterface $outputInterface)
    {
        return $process->run(function ($type, $buffer) use ($outputInterface) {
            $type;
            $outputInterface->write($buffer);
        });
    }
}
