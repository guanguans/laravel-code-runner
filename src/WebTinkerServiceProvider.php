<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-web-tinker.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelWebTinker;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class WebTinkerServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-web-tinker')
            ->hasConfigFile()
            ->hasTranslations()
            ->hasViews();
    }
}
