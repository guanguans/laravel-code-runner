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

use Guanguans\LaravelCodeRunner\Contracts\CodeRunnerContract;
use Guanguans\LaravelCodeRunner\Events\CodeRunnedEvent;
use Guanguans\LaravelCodeRunner\Events\CodeRunningEvent;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Pipeline\Pipeline;

class CodeRunner implements CodeRunnerContract
{
    protected CodeRunnerContract $codeRunner;
    protected Pipeline $pipeline;
    protected Repository $configRepository;
    protected Dispatcher $dispatcher;

    public function __construct(
        CodeRunnerContract $codeRunnerContract,
        Pipeline $pipeline,
        Repository $configRepository,
        Dispatcher $dispatcher
    ) {
        $this->codeRunner = $codeRunnerContract;
        $this->pipeline = $pipeline;
        $this->configRepository = $configRepository;
        $this->dispatcher = $dispatcher;
    }

    public function run(string $code): string
    {
        $modifiedCode = (clone $this->pipeline)
            ->send($code)
            ->through($this->configRepository->get('code-runner.code_handlers'))
            ->thenReturn();

        $this->fireCodeRunningEvent($modifiedCode, $this->codeRunner);

        $result = $this->codeRunner->run($modifiedCode);

        $this->fireCodeRunnedEvent($result, $this->codeRunner);

        return (clone $this->pipeline)
            ->send($result)
            ->through($this->configRepository->get('code-runner.result_handlers'))
            ->thenReturn();
    }

    public function listenCodeRunning(callable $callback): void
    {
        $this->dispatcher->listen(CodeRunningEvent::class, $callback);
    }

    public function listenCodeRunned(callable $callback): void
    {
        $this->dispatcher->listen(CodeRunnedEvent::class, $callback);
    }

    protected function fireCodeRunningEvent(string $code, CodeRunnerContract $codeRunnerContract): void
    {
        $this->dispatcher->dispatch(new CodeRunningEvent($code, $codeRunnerContract));
    }

    protected function fireCodeRunnedEvent(string $result, CodeRunnerContract $codeRunnerContract): void
    {
        $this->dispatcher->dispatch(new CodeRunnedEvent($result, $codeRunnerContract));
    }
}
