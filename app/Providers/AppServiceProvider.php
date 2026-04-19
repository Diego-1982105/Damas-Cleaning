<?php

namespace App\Providers;

use App\Models\Lead;
use App\Models\User;
use Dompdf\Dompdf;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        if (! class_exists(Dompdf::class)) {
            return;
        }

        // barryvdh/laravel-dompdf throws if `realpath(public)` is false; on some
        // hosts (e.g. release symlinks) the directory exists but realpath fails.
        // This appends after package providers so it replaces the package binding.
        $this->app->bind('dompdf', function ($app): Dompdf {
            $options = $app->make('dompdf.options');
            $dompdf = new Dompdf($options);

            $configured = $app['config']->get('dompdf.public_path');
            $public = ($configured !== null && $configured !== '')
                ? (string) $configured
                : base_path('public');

            $resolved = realpath($public);
            $basePath = $resolved !== false ? $resolved : $public;

            if (! is_dir($basePath)) {
                throw new \RuntimeException(
                    'Dompdf cannot use public base path (not a directory): '.$public
                );
            }

            $dompdf->setBasePath($basePath);

            return $dompdf;
        });
    }

    public function boot(): void
    {
        $this->configureDomPdfForDeployment();

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

    /**
     * DomPDF needs writable font metrics storage and a chroot under the running
     * app's base path. Use `storage/framework/...` so the same permissions as
     * Laravel's cache apply (avoids a separate `storage/fonts` setup on PaaS).
     */
    private function configureDomPdfForDeployment(): void
    {
        if (! class_exists(Dompdf::class)) {
            return;
        }

        $fontHome = storage_path('framework/dompdf-fonts');
        File::ensureDirectoryExists($fontHome);

        config([
            'dompdf.options.chroot' => base_path(),
            'dompdf.options.font_dir' => $fontHome,
            'dompdf.options.font_cache' => $fontHome,
        ]);
    }
}
