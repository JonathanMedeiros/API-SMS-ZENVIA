<?php

namespace App\Http\Middleware;

use App\Models\Application;
use Closure;
use Illuminate\Http\Request;

class verifyStatusApplication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $application_id = $request->input('application_id');
        $application = Application::find($application_id);

        if (!$application->active){
            $error['message']='Unauthorized - Service disabled';
            return response($error, 401);  
        }

        return $next($request);
    }
}
