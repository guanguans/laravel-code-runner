<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-code-runner.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelCodeRunner\ResultHandlers;

class ClearResultHandler
{
    public function handle(string $result, callable $next): string
    {
        $result = preg_replace(
            /** @lang PhpRegExp */
            '#(?s)(<aside.*?</aside>)|Exit: {2}Ctrl\+D#ms',
            '$2',
            $result
        );

        return $next(trim($result));
    }
}
