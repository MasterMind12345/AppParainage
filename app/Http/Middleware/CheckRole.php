<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        if ($request->user()->role !== $role && !$request->user()->isDelegue()) {
            abort(403, 'Accès non autorisé');
        }
        
        return $next($request);
    }
}