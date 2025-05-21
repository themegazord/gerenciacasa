<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AppBrand extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return <<<'HTML'
                <a href="/" wire:navigate>
                    <!-- Hidden when collapsed -->
                    <div {{ $attributes->class(["hidden-when-collapsed"]) }}>
                        <div class="flex items-center gap-2 w-fit">
                            <img src="{{ asset('logo_cinza.png') }}" alt="Logo da empresa" class="w-[150px] h-[75px] sm:w-[250px] sm:h-[125px] my-[-2rem]">
                        </div>
                    </div>

                    <!-- Display when collapsed -->
                    <div class="display-when-collapsed hidden mx-5 mt-5 mb-1 h-[28px]">
                        <x-icon name="o-home" class="w-6 -mb-1.5 text-purple-500" />
                    </div>
                </a>
            HTML;
    }
}
