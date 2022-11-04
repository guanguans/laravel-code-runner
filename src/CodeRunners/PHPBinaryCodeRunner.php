<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-code-runner.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelCodeRunner\CodeRunners;

use Guanguans\LaravelCodeRunner\CodeHandlers\PrefixAutoloadFilesCodeHandler;
use Guanguans\LaravelCodeRunner\Contracts\CodeRunnerContract;
use Symfony\Component\Process\PhpExecutableFinder;
use Symfony\Component\Process\Process;

class PHPBinaryCodeRunner implements CodeRunnerContract
{
    protected string $phpBinary;
    protected string $workingDirectory;
    protected ?float $timeout;

    public function __construct(?string $phpBinary = null, ?string $workingDirectory = null, ?float $timeout = null)
    {
        if (null !== $phpBinary) {
            $this->setPhpBinary($phpBinary);
        } else {
            /** @noinspection CallableParameterUseCaseInTypeContextInspection */
            $phpBinary = (new PhpExecutableFinder())->find(false);
            if (! $phpBinary) {
                throw new \RuntimeException('No PHP found, please configure the PHP binary.');
            }

            $this->setPhpBinary($phpBinary);
        }

        $this->setWorkingDirectory($workingDirectory ?? base_path());
        $this->setTimeout($timeout);
    }

    public function run(string $code): string
    {
        $process = (new Process([
            $this->phpBinary,
            '-r',
            $this->prefixAutoloadFilesCode($code),
        ]))
            ->setWorkingDirectory($this->workingDirectory)
            ->setTimeout($this->timeout);

        $process->run();

        return $process->getOutput();
    }

    public function setPhpBinary(string $phpBinary): void
    {
        if (! file_exists($phpBinary) || ! is_executable($phpBinary) || is_dir($phpBinary)) {
            throw new \InvalidArgumentException(sprintf('PHP binary does not exist, or the PHP binary is not executable.: `%s`', $phpBinary));
        }

        $this->phpBinary = realpath($phpBinary);
    }

    public function setWorkingDirectory(string $workingDirectory): void
    {
        $this->workingDirectory = realpath($workingDirectory);
    }

    public function setTimeout(?float $timeout): void
    {
        $this->timeout = $timeout;
    }

    protected function prefixAutoloadFilesCode(string $code): string
    {
        return (new PrefixAutoloadFilesCodeHandler())
            ->handle($code, static fn (string $handledCode): string => $handledCode);
    }
}
