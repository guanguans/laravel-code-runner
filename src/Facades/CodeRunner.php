<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-code-runner.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelCodeRunner\Facades;

use Illuminate\Support\Facades\Facade;

class CodeRunner extends Facade
{
    /**
     * {@inheritdoc}
     */
    protected static function getFacadeAccessor(): string
    {
        return \Guanguans\LaravelCodeRunner\CodeRunner::class;
    }
}
