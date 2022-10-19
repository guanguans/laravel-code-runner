<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-web-tinker.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelWebTinker\Http\Controllers;

use Guanguans\LaravelWebTinker\Contracts\CodeRunnerContract;
use Guanguans\LaravelWebTinker\Contracts\ResultModifierContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class TinkerController extends Controller
{
    /**
     * @psalm-suppress LessSpecificReturnStatement
     */
    public function index(): View
    {
        return view('web-tinker::tinker', [
            'theme' => config('web-tinker.theme'),
        ]);
    }

    public function run(Request $request, CodeRunnerContract $codeRunnerContract, ResultModifierContract $resultModifierContract): JsonResponse
    {
        $validated = $request->validate([
            'code' => 'required|string',
        ]);

        $result = $codeRunnerContract->run($validated['code']);

        return response()->json([
            'result' => $resultModifierContract->modify($result),
        ]);
    }
}
