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

use Guanguans\LaravelCodeRunner\CodeRunners\ArtisanCodeRunner;

it('will return a string to execute the `run` method.', function (): void {
    expect($this->app->make(ArtisanCodeRunner::class))
        ->run("echo 'foo';")->toStartWith('foo')
        ->run("echo 'foo'")->toStartWith('foo')
        ->run("echo 'foo")->not->toStartWith('foo')->toBeString();
})->group(__DIR__, __FILE__);
