<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-code-runner.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelCodeRunner\Events;

class CodeRunnedEvent
{
    public string $result;

    public function __construct(string $result)
    {
        $this->result = $result;
    }
}