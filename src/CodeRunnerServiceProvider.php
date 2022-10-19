<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-code-runner.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelCodeRunner;

use Guanguans\LaravelCodeRunner\Console\Commands\InstallCommand;
use Guanguans\LaravelCodeRunner\Contracts\CodeRunnerContract;
use Guanguans\LaravelCodeRunner\Contracts\ResultModifierContract;
use Guanguans\LaravelCodeRunner\Http\Livewire\CodeRunner;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Console\AboutCommand;
use Illuminate\Support\Facades\Gate;
use Livewire\Livewire;
use Livewire\LivewireServiceProvider;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class CodeRunnerServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-code-runner')
            ->hasConfigFile()
            ->hasViews()
            ->hasTranslations()
            ->hasAssets()
            ->hasRoute('web')
            ->hasCommand(InstallCommand::class);
    }

    public function registeringPackage(): void
    {
        $this->app->register(LivewireServiceProvider::class);
    }

    public function packageRegistered(): void
    {
        $this->app->bind(CodeRunnerContract::class, config('code-runner.code_runner'));
        $this->app->alias(CodeRunnerContract::class, 'laravel-code-runner.code-runner');

        $this->app->bind(ResultModifierContract::class, config('code-runner.result_modifier'));
        $this->app->alias(ResultModifierContract::class, 'laravel-code-runner.result-modifier');
    }

    public function packageBooted(): void
    {
        Livewire::component('code-runner::livewire.code-runner', CodeRunner::class);

        Gate::define('view-code-runner', static fn (?Authenticatable $authenticatable = null) => app()->environment('local'));

        if (class_exists(AboutCommand::class)) {
            AboutCommand::add(
                'Laravel Code Runner',
                [
                    'Author' => 'guanguans',
                    'Homepage' => 'https://github.com/guanguans/laravel-code-runner',
                    'License' => 'MIT',
                ]
            );
        }
    }

    public function provides(): array
    {
        return [
            CodeRunnerContract::class, 'laravel-code-runner.code-runner',
            ResultModifierContract::class, 'laravel-code-runner.result-modifier',
        ];
    }
}
