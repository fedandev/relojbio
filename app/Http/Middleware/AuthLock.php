<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AuthLock
{
    /**
     * The names of the cookies that should not be encrypted.
     *
     * @var array
     */
    protected $except = [
        //
    ];
    
    public function handle($request, Closure $next, $guard = null)
    {
        if(!auth()->user()){
           return $next($request);
        }
        
        // If the user does not have this feature enabled, then just return next.
        if (!$request->user()->hasLockoutTime()) {
            // Check if previous session was set, if so, remove it because we don't need it here.
            if (session('lock-expires-at')) {
                session()->forget('lock-expires-at');
            }
    
            return $next($request);
        }
    
        if ($lockExpiresAt = session('lock-expires-at')) {
            if ($lockExpiresAt < now()) {
                return redirect()->route('login.locked');
            }
        }
    
        session(['lock-expires-at' => now()->addMinutes($request->user()->getLockoutTime())]);
    
        return $next($request);
    }
}