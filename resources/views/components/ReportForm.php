<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ReportForm extends Component
{
    public string $action;

    public function __construct(string $action = '')
    {
        $this->action = $action ?: route('report.store');
    }

    public function render(): View|Closure|string
    {
        return view('components.report-form');
    }
}