<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {   
        $user = User::where('email', $request->email)->first();
        if(!$user){
            return response()->json([
                'message' => 'user tidak ditemukan'
            ], 404);
        }
        if($user->role != 'user'){
            return response()->json([
                'message' => 'admin dilarang masuk' . $user->role
            ], 401);
        }
        return $next($request);
    }
}
