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

use Guanguans\LaravelCodeRunner\CodeRunner;

it('will return a string to execute the `run` method.', function (): void {
    expect($this->app->make(CodeRunner::class))
        ->run("<?php echo 'foo';")->toContain('foo')
        ->run("<?php echo 'foo'")->toContain('foo')
        ->run("<?php echo 'foo")->toBeString();
})->group(__DIR__, __FILE__);

it('will no return to execute the `listenCodeRunning` method.', function (): void {
    expect($this->app->make(CodeRunner::class))
        ->listenCodeRunning(static function (): void {})->toBeNull();
})->group(__DIR__, __FILE__);

it('will no return to execute the `listenCodeRunned` method.', function (): void {
    expect($this->app->make(CodeRunner::class))
        ->listenCodeRunned(static function (): void {})->toBeNull();
})->group(__DIR__, __FILE__);
