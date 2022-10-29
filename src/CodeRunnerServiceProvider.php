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
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Console\AboutCommand;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use InvalidArgumentException;
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
            fn (): CodeRunnerContract => $this->make(config('code-runner.code_runner'))
        );

        $this->app->singleton(CodeRunner::class);
        $this->app->alias(CodeRunner::class, 'laravel-code-runner.code-runner');
    }

    public function packageBooted(): void
    {
        Livewire::component(
            'code-runner::livewire.code-runner',
            \Guanguans\LaravelCodeRunner\Http\Livewire\CodeRunner::class
        );

        Gate::define(
            'view-code-runner',
            static fn (?Authenticatable $authenticatable = null) => app()->environment('local')
        );

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
            CodeRunnerContract::class,
            CodeRunner::class,
            'laravel-code-runner.code-runner',
        ];
    }

    /**
     * @param string|array $abstract
     *
     * @return mixed
     *
     * @throws \InvalidArgumentException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function make($abstract, array $parameters = [])
    {
        if (! in_array(gettype($abstract), ['string', 'array'])) {
            throw new InvalidArgumentException(sprintf('Invalid argument type(string/array): %s.', gettype($abstract)));
        }

        if (is_string($abstract)) {
            return $this->app->make($abstract, $parameters);
        }

        if (isset($abstract['__class'])) {
            $parameters = Arr::except($abstract, '__class') + $parameters;
            /** @noinspection CallableParameterUseCaseInTypeContextInspection */
            $abstract = $abstract['__class'];

            return $this->make($abstract, $parameters);
        }

        if (isset($abstract['class'])) {
            $parameters = Arr::except($abstract, '__class') + $parameters;
            /** @noinspection CallableParameterUseCaseInTypeContextInspection */
            $abstract = $abstract['class'];

            return $this->make($abstract, $parameters);
        }

        throw new InvalidArgumentException('Argument must be an array containing a "class" or "__class" element.');
    }
}
