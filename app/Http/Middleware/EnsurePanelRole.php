<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\URL;

class EnsurePanelRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Determine user's role slug (from relationship or column)
        $roleSlug = $user->role_relation ? $user->role_relation->slug : $user->role;

        // Ensure consistency if 'admin' is stored but we want explicit check
        // Assuming role slugs are 'admin', 'editor', 'billing', 'user'

        // Get the requested panel role from URL parameters
        $requestedRole = $request->route('panel_role');

        // Check if the user is in the correct panel
        if ($requestedRole !== $roleSlug) {
            // Check if user is trying to access a restricted area OR just wrong URL
            // If user is Admin, they might be allowed to view strict URLs? 
            // The requirement says: "if its editor it should show in url as .../editor"
            // So we force redirect to their own role.

            // If the user is NOT an admin/editor/billing (i.e. 'user'), they shouldn't be here at all.
            if (!in_array($roleSlug, ['admin', 'editor', 'billing'])) {
                return redirect()->route('library.user'); // Or 403
            }

            // Redirect to the correct URL for THEIR role
            // We need to reconstruct the URL with their role slug
            // This is tricky if simpler route parameters are involved.
            // Using route() with current route name is safer.

            return redirect()->route($request->route()->getName(), array_merge(
                $request->route()->parameters(),
                ['panel_role' => $roleSlug]
            ));
        }

        // Set the default value for 'panel_role' for all generated URLs in this request
        URL::defaults(['panel_role' => $roleSlug]);

        // Remove the parameter from the route so it doesn't interfere with controller method signatures
        $request->route()->forgetParameter('panel_role');

        return $next($request);
    }
}
