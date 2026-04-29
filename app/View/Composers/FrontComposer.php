<?php

namespace App\View\Composers;

use App\Models\Category;
use Illuminate\View\View;

class FrontComposer
{
    public function compose(View $view): void
    {
        $view->with('navCategories', Category::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get());
    }
}
