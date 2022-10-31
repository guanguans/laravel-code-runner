<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-code-runner.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelCodeRunner\CodeRunners;

use Guanguans\LaravelCodeRunner\Contracts\CodeRunnerContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Application;
use Illuminate\Support\Collection;
use Illuminate\Support\Env;
use Laravel\Tinker\ClassAliasAutoloader;
use Psy\Configuration;
use Psy\ExecutionLoopClosure;
use Psy\Shell;
use Symfony\Component\Console\Output\BufferedOutput;

/**
 * This is modified from `https://github.com/spatie/laravel-web-tinker`.
 */
class TinkerCodeRunner implements CodeRunnerContract
{
    protected BufferedOutput $bufferedOutput;
    protected Shell $shell;

    public function __construct(BufferedOutput $bufferedOutput, ?string $configFile = null)
    {
        $this->bufferedOutput = $bufferedOutput;
        $this->shell = $this->createShell($bufferedOutput, $configFile);
    }

    public function run(string $code): string
    {
        $this->shell->addInput($code);

        $executionLoopClosure = new ExecutionLoopClosure($this->shell);

        $executionLoopClosure->execute();

        return $this->bufferedOutput->fetch();
    }

    protected function createShell(BufferedOutput $bufferedOutput, ?string $configFile = null): Shell
    {
        $configuration = new Configuration([
            'updateCheck' => 'never',
            'configFile' => $configFile,
        ]);
        $configuration->setHistoryFile(defined('PHP_WINDOWS_VERSION_BUILD') ? 'null' : '/dev/null');
        $configuration->getPresenter()->addCasters([
            Collection::class => 'Laravel\Tinker\TinkerCaster::castCollection',
            Model::class => 'Laravel\Tinker\TinkerCaster::castModel',
            Application::class => 'Laravel\Tinker\TinkerCaster::castApplication',
        ]);

        $shell = new Shell($configuration);
        $shell->setOutput($bufferedOutput);

        $composerClassMap = Env::get('COMPOSER_VENDOR_DIR', base_path('vendor'));
        $composerClassMap .= '/composer/autoload_classmap.php';
        if (file_exists($composerClassMap)) {
            ClassAliasAutoloader::register($shell, $composerClassMap);
        }

        return $shell;
    }
}
