<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-code-runner.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

use Guanguans\LaravelCodeRunner\CodeHandlers\RemoveTokensCodeHandler;
use Guanguans\LaravelCodeRunner\CodeRunners\TinkerCodeRunner;
use Guanguans\LaravelCodeRunner\Http\Middleware\Authorize;
use Guanguans\LaravelCodeRunner\ResultHandlers\ClearResultHandler;
use Guanguans\LaravelCodeRunner\ResultHandlers\PrefixDateTimeResultHandler;

/**
 * This file is part of the guanguans/laravel-code-runner.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

return [
    'enabled' => env('CODE_RUNNER_ENABLED', 'local' === env('APP_ENV')),

    /**
     * @see https://github.com/highlightjs/highlight.js/tree/main/src/styles
     */
    'theme' => env('CODE_RUNNER_THEME', 'github-dark'),

    'route' => [
        'domain' => null,
        'middleware' => [
            'web',
            Authorize::class,
        ],
        'name' => 'code-runner.',
        'as' => 'code-runner.',
        'prefix' => '/code-runner',
    ],

    'code_runner' => TinkerCodeRunner::class,

    'code_handlers' => [
        sprintf(
            '%s:%s,%s,%s,%s',
            RemoveTokensCodeHandler::class,
            \T_COMMENT,
            \T_DOC_COMMENT,
            \T_OPEN_TAG,
            \T_CLOSE_TAG
        ),
        // Guanguans\LaravelCodeRunner\CodeHandlers\PrefixAutoloadFilesCodeHandler::class,
    ],

    'result_handlers' => [
        ClearResultHandler::class,
        PrefixDateTimeResultHandler::class,
    ],
];
