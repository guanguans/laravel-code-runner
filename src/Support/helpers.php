<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-code-runner.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Arr;

if (! function_exists('make')) {
    /**
     * @psalm-suppress MissingReturnType
     *
     * @psalm-param string|array<string, mixed> $abstract
     *
     * @throws InvalidArgumentException
     * @throws BindingResolutionException
     */
    function make($abstract, array $parameters = [])
    {
        if (! in_array(gettype($abstract), ['string', 'array'], true)) {
            throw new InvalidArgumentException(sprintf('Invalid argument type(string/array): %s.', gettype($abstract)));
        }

        if (is_string($abstract)) {
            return app($abstract, $parameters);
        }

        $classes = ['__class', '_class', 'class'];
        foreach ($classes as $class) {
            if (! isset($abstract[$class])) {
                continue;
            }

            $parameters = Arr::except($abstract, $class) + $parameters;
            $abstract = $abstract[$class];

            return make($abstract, $parameters);
        }

        throw new InvalidArgumentException(sprintf('The argument of abstract must be an array containing a `%s` element.', implode('` or `', $classes)));
    }
}
