<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckCompanyApproval
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // Allow Super Admin and users without companies (if any)
        if (!$user || $user->role === 'super_admin' || !$user->company) {
            return $next($request);
        }

        $company = $user->company;

        if ($company->status !== 'approved' || !$company->is_active) {
            // Allow access to the pending page itself and logout
            if ($request->routeIs('pending.approval') || $request->is('logout')) {
                return $next($request);
            }

            return redirect()->route('pending.approval');
        }

        return $next($request);
    }
}
