<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-code-runner.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelCodeRunner\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'code-runner:install {--f|force : Overwrite any existing files}';

    /**
     * @var string
     */
    protected $description = 'Install all of the `Code Runner` resources.';

    public function handle(): void
    {
        $this->comment('Publishing `Code Runner` resources...');

        /** @noinspection PhpParamsInspection */
        $this->call('vendor:publish', [
            '--tag' => [
                'code-runner-assets',
                'code-runner-translations',
                // 'code-runner-views',
            ],
            '--force' => $this->option('force'),
        ]);

        $this->info('`Code Runner` installed successfully.');
    }
}
