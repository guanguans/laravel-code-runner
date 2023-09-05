<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-code-runner.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelCodeRunnerTests\Http\Middleware;

use Guanguans\LaravelCodeRunner\Http\Middleware\Authorize;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpKernel\Exception\HttpException;

it('will throws a `HttpException` to execute the `handle` method.', function (): void {
    config()->set('code-runner.enabled', false);

    expect($this->app->make(Authorize::class))
        ->handle($this->app->make(Request::class), static fn ($request) => app(Response::class))
        ->toBeInstanceOf(Response::class);
})->group(__DIR__, __FILE__)->throws(HttpException::class);

it('will return a `Response` to execute the `handle` method.', function (): void {
    Gate::shouldReceive('check')->once()->andReturnTrue();

    expect($this->app->make(Authorize::class))
        ->handle($this->app->make(Request::class), static fn ($request) => app(Response::class))
        ->toBeInstanceOf(Response::class);
})->group(__DIR__, __FILE__);
