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

use Composer\InstalledVersions;
use Guanguans\LaravelCodeRunner\Commands\InstallCommand;
use Guanguans\LaravelCodeRunner\Contracts\CodeRunnerContract;
use Guanguans\LaravelCodeRunner\Http\Livewire\CodeRunner;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Console\AboutCommand;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
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
            ->hasRoute('code-runner')
            ->hasCommand(InstallCommand::class);
    }

    public function registeringPackage(): void
    {
        $this->app->register(LivewireServiceProvider::class);
    }

    public function packageRegistered(): void
    {
        $this->app->bind(
            CodeRunnerContract::class,
            static fn (): CodeRunnerContract => make(config('code-runner.code_runner'))
        );

        $this->app->singleton(CodeRunner::class);
        $this->app->alias(CodeRunner::class, 'laravel-code-runner.code-runner');
    }

    public function packageBooted(): void
    {
        Livewire::component(
            'code-runner::livewire.code-runner',
            CodeRunner::class
        );

        if (! Gate::has($ability = 'view-code-runner')) {
            Gate::define(
                $ability,
                fn (?Authenticatable $authenticatable = null) => $this->app->environment('local')
            );
        }

        $this->addSectionToAboutCommand();
    }

    /**
     * @return string[]
     */
    public function provides(): array
    {
        return [
            CodeRunnerContract::class,
            CodeRunner::class,
            'laravel-code-runner.code-runner',
        ];
    }

    /**
     * @throws \JsonException
     */
    protected function addSectionToAboutCommand(): void
    {
        if (! class_exists(InstalledVersions::class)) {
            return;
        }

        if (! class_exists(AboutCommand::class)) {
            return;
        }

        AboutCommand::add('Laravel Code Runner', function (): array {
            $fullPackageName = "guanguans/{$this->package->name}";

            $installedVersions = collect(InstalledVersions::getAllRawData())
                ->pluck('versions')
                ->first(static fn (array $installedVersions): bool => isset($installedVersions[$fullPackageName]), []);

            $composerJson = json_decode(
                file_get_contents(base_path("vendor/{$fullPackageName}/composer.json")),
                true,
                512,
                JSON_THROW_ON_ERROR
            );

            return collect(($installedVersions[$fullPackageName] ?? []) + $composerJson)
                ->except([
                    'install_path',
                    'readme',
                    'reference',
                ])
                ->filter(static fn ($value): bool => \is_string($value) && $value)
                ->mapWithKeys(static fn ($value, $key): array => [Str::headline($key) => $value])
                ->toArray();
        });
    }
}
