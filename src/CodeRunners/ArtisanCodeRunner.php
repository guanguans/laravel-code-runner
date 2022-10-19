<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-web-tinker.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelWebTinker\CodeRunners;

use Guanguans\LaravelWebTinker\Contracts\CodeRunnerContract;
use Illuminate\Contracts\Console\Kernel;
use Symfony\Component\Console\Output\BufferedOutput;
use Throwable;

class ArtisanCodeRunner implements CodeRunnerContract
{
    protected Kernel $artisan;

    protected BufferedOutput $output;

    public function __construct(Kernel $artisan, BufferedOutput $output)
    {
        $this->artisan = $artisan;
        $this->output = $output;
    }

    public function run(string $code): string
    {
        try {
            /** @noinspection PhpParamsInspection */
            $this->artisan->call(
                'tinker',
                ['--execute' => $code],
                $this->output
            );
        } catch (Throwable $e) {
            return $e->getTraceAsString();
        }

        return $this->output->fetch();
    }
}
