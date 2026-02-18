<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ReportForm extends Component
{
    public bool $isModal;

    public function __construct(bool $isModal = false)
    {
        $this->isModal = $isModal;
    }

    public function render(): View|Closure|string
    {
        return view('components.report-form');
    }
}