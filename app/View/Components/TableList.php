<?php

namespace App\View\Components;

use App\Models\Article;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TableList extends Component
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
        // return view('components.table-list', ['list' => Article::all()->sortBy('sort')]);
        return view('components.table-list', ['list' => Article::where('id', '>', 0)->orderBy('sort')->paginate(5)]);
    }
}