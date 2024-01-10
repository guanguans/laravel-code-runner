<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-code-runner.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelCodeRunner\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Authorize
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response
     *
     * @throws HttpException
     */
    public function handle(Request $request, callable $next): Response
    {
        abort_if($this->deniedToUseCodeRunner(), 403, 'Denied to use `Code Runner`');

        return $next($request);
    }

    protected function allowedToUseCodeRunner(): bool
    {
        if (! config('code-runner.enabled')) {
            return false;
        }

        return Gate::check('view-code-runner');
    }

    protected function deniedToUseCodeRunner(): bool
    {
        return ! $this->allowedToUseCodeRunner();
    }
}
