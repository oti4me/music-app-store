<?php

namespace App\Http\Middleware;

use Closure;
use App\helpers\AuthHelpers;

class APIAuthMiddleware
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
    $request->headers->set('Accept', 'application/json');
    $token = $request->header("Authorization");

    if (!$data = AuthHelpers::jwtDecode($token)) {
      return response()->json(['message' => 'Unauthenticated'], 401);
    }

    $request->userId = $data->sub;

    return $next($request);
  }
}
