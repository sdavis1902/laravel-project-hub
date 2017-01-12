<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;
use App\Models\Project;

class GlobalViewShare
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
		$projects = Project::where('status', '=', 'Active')->get();
		\View::share('menu_projects', $projects);

        return $next($request);
    }
}
