<?php

namespace App\Http\Middleware;

use Closure;
use App\helpers\AuthHelpers;

class CorsMiddleware
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
    if ($request->isMethod('OPTIONS')) {
      $response = Response::make();
    } else {
      $response = $next($request);
    }

    return $response
      ->header('Access-Control-Allow-Origin', '*')
      ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
      ->header('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With, Application, text')
      ->header('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
  }
}
