<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/package-skeleton.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\PackageSkeleton;

use UpdateHelper\UpdateHelperInterface;

class UpdateHelper implements UpdateHelperInterface
{
    public function check(\UpdateHelper\UpdateHelper $updateHelper): void
    {
        $updateHelper->write('Package update checking...');
        $updateHelper->write('Package update checking done.');
    }
}
