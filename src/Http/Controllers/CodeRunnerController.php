<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-code-runner.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelCodeRunner\Http\Controllers;

use Guanguans\LaravelCodeRunner\Contracts\CodeRunnerContract;
use Guanguans\LaravelCodeRunner\Contracts\ResultModifierContract;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CodeRunnerController extends Controller
{
    /**
     * @psalm-suppress LessSpecificReturnStatement
     * @psalm-suppress PossiblyInvalidCast
     */
    public function index(UrlGenerator $urlGenerator): View
    {
        return view('code-runner::index', [
            'theme' => config('code-runner.theme'),
            'path' => $urlGenerator->to(
                Str::finish(config('code-runner.route.prefix'), '/').'run'
            ),
        ]);
    }

    public function run(
        Request $request,
        CodeRunnerContract $codeRunnerContract,
        ResultModifierContract $resultModifierContract
    ): JsonResponse {
        $validated = $request->validate([
            'code' => 'required|string',
        ]);

        $result = $codeRunnerContract->run($validated['code']);

        return response()->json([
            'result' => $resultModifierContract->modify($result),
        ]);
    }
}
