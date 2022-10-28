<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-code-runner.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelCodeRunner;

use Closure;
use Guanguans\LaravelCodeRunner\Contracts\CodeModifierContract;
use Guanguans\LaravelCodeRunner\Contracts\CodeRunnerContract;
use Guanguans\LaravelCodeRunner\Contracts\ResultModifierContract;
use Guanguans\LaravelCodeRunner\Events\CodeRunnedEvent;
use Guanguans\LaravelCodeRunner\Events\CodeRunningEvent;
use Illuminate\Contracts\Events\Dispatcher;

class CodeRunner implements CodeRunnerContract
{
    protected CodeRunnerContract $codeRunner;
    protected CodeModifierContract $codeModifier;
    protected ResultModifierContract $resultModifier;
    protected Dispatcher $dispatcher;

    public function __construct(
        CodeRunnerContract $codeRunnerContract,
        CodeModifierContract $codeModifierContract,
        ResultModifierContract $resultModifierContract,
        Dispatcher $dispatcher
    ) {
        $this->codeRunner = $codeRunnerContract;
        $this->codeModifier = $codeModifierContract;
        $this->resultModifier = $resultModifierContract;
        $this->dispatcher = $dispatcher;
    }

    public function run(string $code): string
    {
        $modifiedCode = $this->codeModifier->modify($code);

        $this->fireCodeRunningEvent($modifiedCode);

        $result = $this->codeRunner->run($modifiedCode);

        $this->fireCodeRunnedEvent($result);

        return $this->resultModifier->modify($result);
    }

    public function listenCodeRunning(Closure $callback): void
    {
        $this->dispatcher->listen(CodeRunningEvent::class, $callback);
    }

    public function listenCodeRunned(Closure $callback): void
    {
        $this->dispatcher->listen(CodeRunnedEvent::class, $callback);
    }

    protected function fireCodeRunningEvent(string $code): void
    {
        $this->dispatcher->dispatch(new CodeRunningEvent($code));
    }

    protected function fireCodeRunnedEvent(string $result): void
    {
        $this->dispatcher->dispatch(new CodeRunnedEvent($result));
    }
}
