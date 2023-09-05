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

use Guanguans\LaravelCodeRunner\CodeRunners\PHPBinaryCodeRunner;

use function Pest\Faker\faker;

it('will throws a `InvalidArgumentException` to execute the `__construct` method.', static function (): void {
    new PHPBinaryCodeRunner(faker()->url());
})->group(__DIR__, __FILE__)->throws(\InvalidArgumentException::class, 'PHP binary does not exist, or the PHP binary is not executable.: ');

it('will return a string to execute the `run` method.', function (): void {
    expect($this->app->make(PHPBinaryCodeRunner::class))
        ->run("echo 'foo';")->toBe('foo')
        ->run("echo 'foo'")->not->toBe('foo')->toBeString()
        ->run("echo 'foo")->not->toBe('foo')->toBeString();
})->group(__DIR__, __FILE__);
