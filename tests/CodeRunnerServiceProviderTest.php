<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-code-runner.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelCodeRunnerTests;

use Guanguans\LaravelCodeRunner\CodeRunnerServiceProvider;

it('will return a array to execute the `provides` method.', function (): void {
    expect(new CodeRunnerServiceProvider($this->app))
        ->provides()->toBeArray();
})->group(__DIR__, __FILE__);
