<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-code-runner.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelCodeRunnerTests;

use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use DMS\PHPUnitExtensions\ArraySubset\ArraySubsetAsserts;
use Guanguans\LaravelCodeRunner\CodeHandlers\PrefixAutoloadFilesCodeHandler;
use Guanguans\LaravelCodeRunner\CodeRunners\ArtisanCodeRunner;
use Guanguans\LaravelCodeRunner\CodeRunnerServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Laravel\Tinker\TinkerServiceProvider;
use Livewire\LivewireServiceProvider;
use Spatie\Snapshots\MatchesSnapshots;

/**
 * @internal
 *
 * @coversNothing
 *
 * @small
 */
class TestCase extends \Orchestra\Testbench\TestCase
{
    use ArraySubsetAsserts;
    use MatchesSnapshots;

    /**
     * This method is called before the first test of this test class is run.
     */
    public static function setUpBeforeClass(): void {}

    /**
     * This method is called after the last test of this test class is run.
     */
    public static function tearDownAfterClass(): void {}

    /**
     * This method is called before each test.
     */
    protected function setUp(): void
    {
        parent::setUp();

        // \DG\BypassFinals::enable();

        Factory::guessFactoryNamesUsing(
            static fn ($modelName): string => 'Guanguans\\LaravelCodeRunner\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    /**
     * This method is called after each test.
     */
    protected function tearDown(): void
    {
        $this->finish();
        \Mockery::close();
    }

    /**
     * Run extra tear down code.
     */
    protected function finish(): void
    {
        // call more tear down methods
    }

    /**
     * @param mixed $app
     *
     * @return class-string[]
     */
    protected function getPackageProviders($app): array
    {
        return [
            IdeHelperServiceProvider::class,
            TinkerServiceProvider::class,
            LivewireServiceProvider::class,
            CodeRunnerServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        $_ENV['COMPOSER_VENDOR_DIR'] = __DIR__.'/../vendor';

        config([
            'code-runner.enabled' => true,
            'code-runner.route.middleware' => [],
            'code-runner.code_handlers' => array_merge(config('code-runner.code_handlers', []), [
                PrefixAutoloadFilesCodeHandler::class,
            ]),
            'code-runner.code_runner' => ArtisanCodeRunner::class,

            'database.default' => 'testing',
        ]);

        // $migration = include __DIR__.'/../database/migrations/create_skeleton_table.php.stub';
        // $migration->up();
    }
}
