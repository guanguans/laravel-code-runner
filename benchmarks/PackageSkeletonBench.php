<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/package-skeleton.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\PackageSkeleton\Tests\Benchmark;

use Guanguans\PackageSkeleton\PackageSkeleton;

/**
 * @beforeMethods({"setUp"})
 * @warmup(2)
 * @revs(1000)
 * @iterations(15)
 */
final class PackageSkeletonBench
{
    /**
     * @var \Guanguans\PackageSkeleton\PackageSkeleton
     */
    private $packageSkeleton;

    public function setUp(): void
    {
        $this->packageSkeleton = new PackageSkeleton();
    }

    public function benchTest(): void
    {
        // $this->packageSkeleton->test();
        PackageSkeleton::test();
    }
}
