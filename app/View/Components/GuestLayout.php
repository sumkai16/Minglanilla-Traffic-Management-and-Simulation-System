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
     * Page title for guest-facing layouts.
     */
    public string $title = '';

    /**
     * Create the component instance.
     */
    public function __construct(string $variant = 'default', string $title = '')
    {
        $this->variant = $variant;
        $this->title = $title;
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view($this->variant === 'login' ? 'layouts.guest-login' : 'layouts.guest');
    }
}
