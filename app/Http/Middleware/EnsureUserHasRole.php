<?php

namespace App\Http\Middleware;

use App\Enums\Role;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    // Usage dans les routes : ->middleware('role:editeur,admin')
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // 'admin' (texte) -> Role::Admin (enum)
        $rolesAutorises = array_map(Role::from(...), $roles);

        abort_unless(
            $request->user()?->hasRole(...$rolesAutorises),
            403,
            "Vous n'avez pas les droits pour accéder à cette page."
        );

        // Le vigile laisse passer : on continue vers le contrôleur
        return $next($request);
    }
}