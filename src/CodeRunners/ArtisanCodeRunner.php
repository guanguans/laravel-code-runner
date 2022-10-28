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
use Illuminate\Contracts\Console\Kernel;
use Symfony\Component\Console\Output\BufferedOutput;
use Throwable;

class ArtisanCodeRunner implements CodeRunnerContract
{
    protected Kernel $kernel;
    protected BufferedOutput $bufferedOutput;

    public function __construct(Kernel $kernel, BufferedOutput $bufferedOutput)
    {
        $this->kernel = $kernel;
        $this->bufferedOutput = $bufferedOutput;
    }

    public function run(string $code): string
    {
        try {
            /** @noinspection PhpParamsInspection */
            $this->kernel->call(
                'tinker',
                ['--execute' => $code],
                $this->bufferedOutput
            );
        } catch (Throwable $throwable) {
            return $throwable->getTraceAsString();
        }

        return $this->bufferedOutput->fetch();
    }
}
