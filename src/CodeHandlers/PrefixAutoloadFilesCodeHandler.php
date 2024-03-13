<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-code-runner.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelCodeRunner\CodeHandlers;

use Illuminate\Support\Env;

class PrefixAutoloadFilesCodeHandler
{
    public function handle(string $code, callable $next): string
    {
        $preloadFilesCode = '';

        // $autoloadFile = Env::get('VENDOR_DIR', base_path('vendor')).'/autoload.php';
        $autoloadFile = ($_ENV['VENDOR_DIR'] ?? base_path('vendor')).'/autoload.php';
        if (file_exists($autoloadFile)) {
            $preloadFilesCode = "require '{$autoloadFile}';".PHP_EOL;
        }

        // $bootstrapFile = Env::get('BOOTSTRAP_FILE', base_path('bootstrap/app.php'));
        $bootstrapFile = ($_ENV['BOOTSTRAP_FILE'] ?? base_path('vendor')).'/bootstrap/app.php';
        if (file_exists($bootstrapFile)) {
            $preloadFilesCode .= "require '{$bootstrapFile}';".PHP_EOL;
        }

        return $next($preloadFilesCode.$code);
    }
}
