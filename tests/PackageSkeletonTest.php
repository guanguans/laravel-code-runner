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

use Guanguans\PackageSkeleton\PackageSkeleton;

final class PackageSkeletonTest extends TestCase
{
    public function testTest(): void
    {
        $this->assertTrue(PackageSkeleton::test());
    }
}
