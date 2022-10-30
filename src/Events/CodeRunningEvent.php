<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-code-runner.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelCodeRunner\Events;

use Guanguans\LaravelCodeRunner\Contracts\CodeRunnerContract;

class CodeRunningEvent
{
    public string $code;
    public CodeRunnerContract $runnerContract;

    public function __construct(string $code, CodeRunnerContract $runnerContract)
    {
        $this->code = $code;
        $this->runnerContract = $runnerContract;
    }
}
