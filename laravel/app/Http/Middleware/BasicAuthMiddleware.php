<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;
use DB;
use Illuminate\Http\Response;

class BasicAuthMiddleware
{

    public function handle(Request $request, Closure $next)
    {
        if($request->has('apiKey'))
        {
            $apiKey = $request->apiKey;
            $result = DB::select("SELECT * FROM api_key WHERE value = ?", [$apiKey]);

            if($result)
            {
                return $next($request);
            } else {
                $response = new Response;
                $response->setStatusCode(401, 'Invalid Access Token');
                $response->header('WWW-Authenticate', 'Basic');

                return $response;
            }
        }
        $response = new Response;
        $response->setStatusCode(401, 'Invalid Access Token');
        $response->header('WWW-Authenticate', 'Basic');

        return $response;
    }
}
