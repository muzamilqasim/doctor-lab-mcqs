<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Captcha extends Component
{
    /**
     * Create a new component instance.
     */

    public $path;

    public function __construct($path = null)
    {
        $this->path = $path;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        if ($this->path) {
            return view($this->path.'.captcha');
        }
        return view('components.captcha');
    }
}
