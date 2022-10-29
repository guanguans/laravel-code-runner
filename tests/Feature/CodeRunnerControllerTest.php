<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-code-runner.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelCodeRunnerTests\Feature;

use Illuminate\Support\Str;

it('will visit the `Code Runner` page.', function (): void {
    $this->get(config('code-runner.route.prefix'))
        ->assertOk()
        ->assertViewIs('code-runner::index');
})->group(__DIR__, __FILE__);

it('will request the `Code Runner` api.', function (): void {
    $this
        ->post($uri = Str::finish(config('code-runner.route.prefix'), '/').'run')
        ->assertInvalid();

    /** @noinspection PhpParamsInspection */
    $this
        ->post($uri, [
            'code' => "echo 'foo';",
        ])
        ->assertOk()
        ->assertSee('result');
})->group(__DIR__, __FILE__);
