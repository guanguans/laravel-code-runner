<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-code-runner.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelCodeRunner\ResultModifiers;

use Guanguans\LaravelCodeRunner\Contracts\ResultModifierContract;

class PrefixDateTimeResultModifier implements ResultModifierContract
{
    public function modify(string $result): string
    {
        return '<span class="text-primary">'.now()->format('Y-m-d H:i:s').'</span><br>'.$this->clean($result);
    }

    protected function clean(string $result): string
    {
        $result = preg_replace(
            /** @lang PhpRegExp */
            '#(?s)(<aside.*?</aside>)|Exit: {2}Ctrl\+D#ms',
            '$2',
            $result
        );

        return trim($result);
    }
}
