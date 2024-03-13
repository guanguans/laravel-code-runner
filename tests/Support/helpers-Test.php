<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-code-runner.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

use Guanguans\LaravelCodeRunner\CodeRunners\TinkerCodeRunner;

it('will throws a `InvalidArgumentException` with a `Invalid argument type` message to execute the `make` method.', function (): void {
    make($this->app->make(TinkerCodeRunner::class));
})->group(__DIR__, __FILE__)->throws(InvalidArgumentException::class, 'Invalid argument type(string/array): object.');

it('will throws a `InvalidArgumentException` with a `The argument of abstract must be an array containing` message to execute the `make` method.', function (): void {
    make([
        '___class' => TinkerCodeRunner::class,
    ]);
})->group(__DIR__, __FILE__)->throws(InvalidArgumentException::class, 'The argument of abstract must be an array containing a `__class` or `_class` or `class` element.');

it('will return a object to execute the `make` method.', function (): void {
    expect(make(TinkerCodeRunner::class))->toBeInstanceOf(TinkerCodeRunner::class)
        ->and(
            make([
                'class' => TinkerCodeRunner::class,
            ])
        )->toBeInstanceOf(TinkerCodeRunner::class)
        ->and(
            make([
                '_class' => TinkerCodeRunner::class,
            ])
        )->toBeInstanceOf(TinkerCodeRunner::class)
        ->and(
            make([
                '__class' => TinkerCodeRunner::class,
            ])
        )->toBeInstanceOf(TinkerCodeRunner::class);
})->group(__DIR__, __FILE__);
