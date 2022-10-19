<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/laravel-code-runner.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelCodeRunner\Http\Livewire;

use Illuminate\View\View;
use Livewire\Component;

class CodeRunner extends Component
{
    public function render(): View
    {
        return view('code-runner::livewire.code-runner')
            // ->layout('code-runner::layouts.app')
            // ->slot('main')
        ;
    }
}
