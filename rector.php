<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-code-runner.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

use Rector\Caching\ValueObject\Storage\FileCacheStorage;
use Rector\CodeQuality\Rector\Array_\CallableThisArrayToAnonymousFunctionRector;
use Rector\CodeQuality\Rector\Class_\InlineConstructorDefaultToPropertyRector;
use Rector\CodeQuality\Rector\Expression\InlineIfToExplicitIfRector;
use Rector\CodeQuality\Rector\Identical\SimplifyBoolIdenticalTrueRector;
use Rector\CodeQuality\Rector\LogicalAnd\LogicalToBooleanRector;
use Rector\CodingStyle\Rector\Closure\StaticClosureRector;
use Rector\CodingStyle\Rector\Encapsed\EncapsedStringsToSprintfRector;
use Rector\CodingStyle\Rector\Encapsed\WrapEncapsedVariableInCurlyBracesRector;
use Rector\CodingStyle\Rector\Stmt\NewlineAfterStatementRector;
use Rector\Config\RectorConfig;
use Rector\Configuration\Option;
use Rector\DeadCode\Rector\Assign\RemoveUnusedVariableAssignRector;
use Rector\EarlyReturn\Rector\If_\ChangeAndIfToEarlyReturnRector;
use Rector\EarlyReturn\Rector\Return_\ReturnBinaryOrToEarlyReturnRector;
use Rector\Laravel\Set\LaravelLevelSetList;
use Rector\Laravel\Set\LaravelSetList;
use Rector\PHPUnit\Set\PHPUnitSetList;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;
use Rector\ValueObject\PhpVersion;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->bootstrapFiles([
        // __DIR__.'/vendor/autoload.php',
    ]);

    $rectorConfig->autoloadPaths([
        // __DIR__.'/vendor/autoload.php',
    ]);

    $rectorConfig->paths([
        // __DIR__.'/config',
        __DIR__.'/routes',
        __DIR__.'/src',
        __DIR__.'/tests',
        __DIR__.'/.php-cs-fixer.php',
        __DIR__.'/rector.php',
    ]);

    $rectorConfig->skip([
        // rules
        // CallableThisArrayToAnonymousFunctionRector::class,
        // InlineIfToExplicitIfRector::class,
        // LogicalToBooleanRector::class,
        // SimplifyBoolIdenticalTrueRector::class,
        // AddSeeTestAnnotationRector::class,
        // NormalizeNamespaceByPSR4ComposerAutoloadRector::class,
        // ChangeAndIfToEarlyReturnRector::class,
        // ReturnBinaryOrToEarlyReturnRector::class,
        EncapsedStringsToSprintfRector::class,
        // WrapEncapsedVariableInCurlyBracesRector::class,

        // optional rules
        // AddDefaultValueForUndefinedVariableRector::class,
        // RemoveUnusedVariableAssignRector::class,
        StaticClosureRector::class,
        NewlineAfterStatementRector::class,

        // paths
        '**/fixtures*',
        '**/fixtures/*',
        '**/Fixture*',
        '**/Fixture/*',
        '**/Source*',
        '**/Source/*',
        '**/Expected/*',
        '**/Expected*',
    ]);

    $rectorConfig->sets([
        LevelSetList::UP_TO_PHP_74,
        SetList::CODE_QUALITY,
        SetList::CODING_STYLE,
        SetList::DEAD_CODE,
        // SetList::GMAGICK_TO_IMAGICK,
        // SetList::MONOLOG_20,
        // SetList::MYSQL_TO_MYSQLI,
        SetList::NAMING,
        // SetList::PRIVATIZATION,
        SetList::TYPE_DECLARATION,
        SetList::EARLY_RETURN,

        // LaravelLevelSetList::UP_TO_LARAVEL_70,
        // LaravelSetList::ARRAY_STR_FUNCTIONS_TO_STATIC_CALL,
        // // LaravelSetList::LARAVEL_STATIC_TO_INJECTION,
        // LaravelSetList::LARAVEL_CODE_QUALITY,
        // LaravelSetList::LARAVEL_ARRAY_STR_FUNCTION_TO_STATIC_CALL,
        // LaravelSetList::LARAVEL_LEGACY_FACTORIES_TO_CLASSES,

        PHPUnitSetList::PHPUNIT_CODE_QUALITY,
    ]);

    $rectorConfig->disableParallel();
    $rectorConfig->importNames(false, false);
    $rectorConfig->phpstanConfig(__DIR__.'/phpstan.neon');
    // $rectorConfig->cacheClass(FileCacheStorage::class);
    // $rectorConfig->cacheDirectory(__DIR__.'/build/rector');
    // $rectorConfig->fileExtensions(['php']);
    // $rectorConfig->parameters()->set(Option::APPLY_AUTO_IMPORT_NAMES_ON_CHANGED_FILES_ONLY, true);
    // $rectorConfig->phpVersion(PhpVersion::PHP_80);
    // $rectorConfig->parallel();
    // $rectorConfig->indent(' ', 4);

    $rectorConfig->rules([
        InlineConstructorDefaultToPropertyRector::class,
    ]);
};
