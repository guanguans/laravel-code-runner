<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/package-skeleton.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\PackageSkeletonTests;

use DMS\PHPUnitExtensions\ArraySubset\ArraySubsetAsserts;
use Illuminate\Database\Eloquent\Factories\Factory;
use Mockery;

class TestCase extends \Orchestra\Testbench\TestCase
{
    use ArraySubsetAsserts;

    /**
     * This method is called before the first test of this test class is run.
     */
    public static function setUpBeforeClass(): void
    {
    }

    /**
     * This method is called after the last test of this test class is run.
     */
    public static function tearDownAfterClass(): void
    {
    }

    /**
     * This method is called before each test.
     */
    protected function setUp(): void
    {
        parent::setUp();

        // \DG\BypassFinals::enable();

        Factory::guessFactoryNamesUsing(
            static fn ($modelName): string => 'Guanguans\\PackageSkeleton\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    /**
     * This method is called after each test.
     */
    protected function tearDown(): void
    {
        $this->finish();
        Mockery::close();
    }

    /**
     * Run extra tear down code.
     */
    protected function finish(): void
    {
        // call more tear down methods
    }

    protected function getPackageProviders($app)
    {
        return [
            // SkeletonServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        config()->set('database.default', 'testing');

        // $migration = include __DIR__.'/../database/migrations/create_skeleton_table.php.stub';
        // $migration->up();
    }
}
