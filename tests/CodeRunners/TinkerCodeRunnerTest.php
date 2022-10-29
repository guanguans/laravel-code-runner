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

use Guanguans\LaravelCodeRunner\CodeRunners\TinkerCodeRunner;

it('will return a string to execute the `run` method.', function (): void {
    expect($this->app->make(TinkerCodeRunner::class))
        ->run("echo 'foo';")->toContain('foo')
        ->run("echo 'foo'")->toContain('foo')
        ->run("echo 'foo")->not->toContain('foo')->toBeString();
})->group(__DIR__, __FILE__)->skip(__FILE__);
