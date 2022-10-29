<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-code-runner.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelCodeRunnerTests\Console\Commands;

use Guanguans\LaravelCodeRunner\Console\Commands\InstallCommand;

use function Pest\Laravel\artisan;

it('will install all of the `Code Runner` resources.', function (): void {
    artisan(InstallCommand::class)
        ->expectsOutput('Publishing `Code Runner` resources...')
        ->expectsOutput('`Code Runner` installed successfully.')
        ->assertSuccessful();
})->group(__DIR__, __FILE__);
