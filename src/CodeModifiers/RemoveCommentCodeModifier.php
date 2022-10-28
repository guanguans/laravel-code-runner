<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-code-runner.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelCodeRunner\CodeModifiers;

use Guanguans\LaravelCodeRunner\Contracts\CodeModifierContract;

class RemoveCommentCodeModifier implements CodeModifierContract
{
    public function modify(string $code): string
    {
        return collect(token_get_all("<?php\n".$code.'?>'))->reduce(
            /**
             * @param string|array<int, string> $token
             */
            function (string $carry, $token): string {
                if (is_string($token)) {
                    return $carry.$token;
                }

                $text = $this->ignoreCommentsAndPhpTags($token);

                return $carry.$text;
            },
            ''
        );
    }

    protected function ignoreCommentsAndPhpTags(array $token): string
    {
        [$id, $text] = $token;

        if (in_array($id, [T_COMMENT, T_DOC_COMMENT, T_OPEN_TAG, T_CLOSE_TAG], true)) {
            return '';
        }

        return $text;
    }
}
