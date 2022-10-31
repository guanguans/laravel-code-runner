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

use Guanguans\LaravelCodeRunner\Contracts\CodeRunnerContract;
use Illuminate\Support\Env;
use InvalidArgumentException;
use RuntimeException;
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
                throw new RuntimeException('No PHP found, please configure the PHP binary.');
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
            throw new InvalidArgumentException(sprintf('PHP binary does not exist, or the PHP binary is not executable.: `%s`', $phpBinary));
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
        $preloadFilesCode = '';

        $autoloadFile = Env::get('VENDOR_DIR', base_path('vendor')).'/autoload.php';
        if (file_exists($autoloadFile)) {
            $preloadFilesCode = "require '$autoloadFile';".PHP_EOL;
        }

        $bootstrapFile = Env::get('BOOTSTRAP_FILE', base_path('bootstrap/app.php'));
        if (file_exists($bootstrapFile)) {
            $preloadFilesCode .= "require '$bootstrapFile';".PHP_EOL;
        }

        return $preloadFilesCode.$code;
    }
}
