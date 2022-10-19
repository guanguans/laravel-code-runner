<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/package-skeleton.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\PackageSkeletonTests;

use Closure;
use Pest\Expectation;

uses(TestCase::class)
    ->beforeEach(function (): void {
    })
    ->in(__DIR__);

expect()->extend('assert', function (Closure $assertions): Expectation {
    $assertions($this->value);

    return $this;
});

expect()->extend('between', function (int $min, int $max): Expectation {
    expect($this->value)
        ->toBeGreaterThanOrEqual($min)
        ->toBeLessThanOrEqual($max);

    return $this;
});
