<?php

namespace App\Http\Middleware;

use App\Models\Application;
use Closure;
use Illuminate\Http\Request;

class AuthApplication
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
        $bearerToken = $request->bearerToken();

        if (!isset($bearerToken) || is_null($bearerToken)) {
            $error['message'] = 'Forbiden'; 
            return response()->json($error, 403);
        }

        $application = Application::where('token', $bearerToken)->first();

        if (is_null($application)){
            $error['message']='Unauthorized - Aplication token is invalid';
            return response($error, 401);  
        }

        return $next($request->merge(['application_id' => $application['id']]));
    }
}
