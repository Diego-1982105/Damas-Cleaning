<?php

namespace App\Providers;

use App\Models\Lead;
use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Paginator::useTailwind();

        // Register a Gate for every granular permission key.
        foreach (array_keys(User::permissionLabels()) as $permission) {
            Gate::define($permission, fn (User $user) => $user->hasPermission($permission));
        }

        // Share unseen-lead notifications with every admin layout view.
        View::composer('layouts.admin', function (\Illuminate\View\View $view) {
            if (! Auth::check()) {
                $view->with(['unseenLeadsCount' => 0, 'unseenLeads' => collect()]);

                return;
            }

            $unseen = Lead::unseen()
                ->orderByDesc('created_at')
                ->limit(8)
                ->get(['id', 'name', 'service_type', 'created_at']);

            $view->with([
                'unseenLeadsCount' => $unseen->count(),
                'unseenLeads' => $unseen,
            ]);
        });
    }
}
