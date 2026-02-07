<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class GuestLayout extends Component
{
    /**
     * Layout variant: 'default' or 'login' (login uses custom Minglanilla design).
     */
    public string $variant = 'default';

    /**
     * Create the component instance.
     */
    public function __construct(string $variant = 'default')
    {
        $this->variant = $variant;
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view($this->variant === 'login' ? 'layouts.guest-login' : 'layouts.guest');
    }
}
