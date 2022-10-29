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
use Throwable;

class EvalCodeRunner implements CodeRunnerContract
{
    public function run(string $code): string
    {
        ob_start();

        try {
            eval($code);
        } catch (Throwable $throwable) {
            ob_end_clean();

            return $throwable->getMessage().PHP_EOL.$throwable->getTraceAsString();
        }

        return (string) ob_get_clean();
    }
}
