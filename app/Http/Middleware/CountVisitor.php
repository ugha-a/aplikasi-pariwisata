<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Visit;

class CountVisitor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah session sudah punya flag kunjungan
        if (!session()->has('has_visited')) {
            Visit::create([
                'ip_address' => $request->ip(),
                'user_agent' => $request->header('User-Agent')
            ]);
            session(['has_visited' => true]);
        }

        return $next($request);
    }
}
