<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Api\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\Auth;


class Admin
{
    use ApiResponseTrait;

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        if($user->status != 'admin')
        {
            return $this->ApiResponse(null,['error' => 'You do not have permission to access this endpoint'],403);
        }
        return $next($request);
    }
}