<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-code-runner.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelCodeRunnerTests\CodeRunners;

use Guanguans\LaravelCodeRunner\CodeRunners\EvalCodeRunner;

it('will return a string to run the `run` method.', function (): void {
    expect(new EvalCodeRunner())
        ->run('echo 1;')->toBe('1')
        ->run('echo 1')->toBeString();
})->group(__DIR__, __FILE__);
