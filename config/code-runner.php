<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-code-runner.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

return [
    /**
     * By default this package will only run in local development.
     * Do not change this, unless you know what you are doing.
     */
    'enabled' => env('WEB_TINKER_ENABLED', 'local' === env('APP_ENV')),

    /**
     * @see https://github.com/highlightjs/highlight.js/tree/main/src/styles
     */
    'theme' => env('WEB_TINKER_THEME', 'github-dark'),

    'route' => [
        'domain' => null,
        'middleware' => Guanguans\LaravelCodeRunner\Http\Middleware\Authorize::class,
        'as' => 'code-runner.',
        'name' => 'code-runner.',
        'prefix' => '/code-runner',
    ],

    'code_runner' => Guanguans\LaravelCodeRunner\CodeRunners\WebTinkerCodeRunner::class,

    'result_modifier' => Guanguans\LaravelCodeRunner\ResultModifiers\PrefixDateTimeResultModifier::class,

    /*
     * If you want to fine-tune PsySH configuration specify
     * configuration file name, relative to the root of your
     * application directory.
     */
    'config_file' => env('WEB_TINKER_CONFIG_FILE'),
];
