<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-web-tinker.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

it('to be string', function ($movie): void {
    expect($movie)->toBeString();
})->group(__DIR__, __FILE__)->with('movies');
