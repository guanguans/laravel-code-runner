<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-code-runner.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

Route::group(
    ['namespace' => 'Guanguans\LaravelCodeRunner\Http\Controllers'] + config('code-runner.route'),
    static function (Router $router): void {
        Route::get('/', 'CodeRunnerController@index');
        Route::post('/run', 'CodeRunnerController@run')->name('run');
    }
);
