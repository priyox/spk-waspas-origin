<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Menu;

class CheckMenuAccess
{
    public function handle(Request $request, Closure $next)
    {
        // Bypass untuk Super Admin
        if (auth()->check() && auth()->user()->hasRole('Super Admin')) {
            return $next($request);
        }

        // Ambil nama route yang diakses
        $routeName = $request->route()->getName();

        // Jika route tidak punya nama → lewati
        if (!$routeName) {
            return $next($request);
        }

        // Ambil menu berdasarkan route
        $menu = Menu::where('route', $routeName)
            ->where('is_active', true)
            ->first();

        // Jika route tidak terdaftar sebagai menu → izinkan
        if (!$menu) {
            return $next($request);
        }

        if ($menu->permission_name) {
            if (!auth()->user()->hasPermissionTo($menu->permission_name)) {
                abort(403, 'Anda tidak memiliki hak akses (permission) untuk menu ini.');
            }
            return $next($request);
        }

        // Jika tidak ada permission khusus, fallback ke Role check
        // Ambil role user
        $roleIds = auth()->user()->roles->pluck('id');

        // Cek apakah menu punya role user
        $hasAccess = $menu->roles()
            ->whereIn('roles.id', $roleIds)
            ->exists();

        if (!$hasAccess) {
            abort(403, 'Anda tidak memiliki akses role ke menu ini');
        }

        return $next($request);
    }
}
