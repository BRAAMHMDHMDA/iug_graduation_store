<?php

namespace App\Http\Middleware;

use App\Models\Category;
use Closure;

class CheckCategory
{

    public function handle($request, Closure $next)
    {
        $count = Category::all()->count();
        if ($count==0)
        {
            session()->flash('error','First You Need to Add Some Categories');
            return redirect(route('categories.index'));
        }else return $next($request);
    }
}
