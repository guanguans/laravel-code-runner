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
use Laravel\Tinker\ClassAliasAutoloader;
use Psy\Configuration;
use Psy\ExecutionLoopClosure;
use Psy\Shell;
use Symfony\Component\Console\Output\BufferedOutput;

/**
 * This is modified from `https://github.com/spatie/laravel-web-tinker`.
 */
class WebTinkerCodeRunner implements CodeRunnerContract
{
    protected BufferedOutput $bufferedOutput;

    protected Shell $shell;

    public function __construct()
    {
        $this->bufferedOutput = new BufferedOutput();

        $this->shell = $this->createShell($this->bufferedOutput);
    }

    public function run(string $code): string
    {
        $code = $this->removeComments($code);

        $this->shell->addInput($code);

        $closure = new ExecutionLoopClosure($this->shell);

        $closure->execute();

        return $this->bufferedOutput->fetch();
    }

    protected function createShell(BufferedOutput $bufferedOutput): Shell
    {
        $configuration = new Configuration([
            'updateCheck' => 'never',
            'configFile' => null !== config('code-runner.config_file') ? base_path(config('code-runner.config_file')) : null,
        ]);

        $configuration->setHistoryFile(defined('PHP_WINDOWS_VERSION_BUILD') ? 'null' : '/dev/null');

        $configuration->getPresenter()->addCasters([
            Collection::class => 'Laravel\Tinker\TinkerCaster::castCollection',
            Model::class => 'Laravel\Tinker\TinkerCaster::castModel',
            Application::class => 'Laravel\Tinker\TinkerCaster::castApplication',
        ]);

        $shell = new Shell($configuration);

        $shell->setOutput($bufferedOutput);

        $composerClassMap = base_path('vendor/composer/autoload_classmap.php');

        if (file_exists($composerClassMap)) {
            ClassAliasAutoloader::register($shell, $composerClassMap);
        }

        return $shell;
    }

    public function removeComments(string $code): string
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

        if (T_COMMENT === $id) {
            return '';
        }

        if (T_DOC_COMMENT === $id) {
            return '';
        }

        if (T_OPEN_TAG === $id) {
            return '';
        }

        if (T_CLOSE_TAG === $id) {
            return '';
        }

        return $text;
    }
}
