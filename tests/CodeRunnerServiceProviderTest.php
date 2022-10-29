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

use Guanguans\LaravelCodeRunner\CodeRunners\TinkerCodeRunner;
use Guanguans\LaravelCodeRunner\CodeRunnerServiceProvider;
use InvalidArgumentException;

it('will return a array to execute the `provides` method.', function (): void {
    expect(new CodeRunnerServiceProvider($this->app))
        ->provides()->toBeArray();
})->group(__DIR__, __FILE__);

it('will throws a `InvalidArgumentException` with a `Invalid argument type` message to execute the `make` method.', function (): void {
    expect(new CodeRunnerServiceProvider($this->app))
        ->make($this->app->make(TinkerCodeRunner::class));
})->group(__DIR__, __FILE__)->throws(InvalidArgumentException::class, 'Invalid argument type(string/array): object.');

it('will throws a `InvalidArgumentException` with a `Argument must be an array containing` message to execute the `make` method.', function (): void {
    /** @noinspection PhpParamsInspection */
    expect(new CodeRunnerServiceProvider($this->app))
        ->make([
            '_class' => TinkerCodeRunner::class,
        ]);
})->group(__DIR__, __FILE__)->throws(InvalidArgumentException::class, 'Argument must be an array containing a "class" or "__class" element.');

it('will return a object to execute the `make` method.', function (): void {
    /** @noinspection PhpParamsInspection */
    expect(new CodeRunnerServiceProvider($this->app))
        ->make([
            'class' => TinkerCodeRunner::class,
        ])->toBeInstanceOf(TinkerCodeRunner::class)
        ->make([
            '__class' => TinkerCodeRunner::class,
        ])->toBeInstanceOf(TinkerCodeRunner::class);
})->group(__DIR__, __FILE__);
