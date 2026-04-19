<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\ClientController as AdminClientController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\InvoiceController as AdminInvoiceController;
use App\Http\Controllers\Admin\LeadController as AdminLeadController;
use App\Http\Controllers\Admin\NotificationController as AdminNotificationController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\SiteSectionController as AdminSiteSectionController;
use App\Http\Controllers\Api\ServiceCatalogController;
use App\Http\Controllers\LeadController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('app');
});

Route::get('/privacy-policy', fn () => view('legal.privacy-policy'))->name('privacy-policy');
Route::get('/terms-of-service', fn () => view('legal.terms-of-service'))->name('terms-of-service');

Route::post('/leads', [LeadController::class, 'store'])->name('leads.store');

Route::get('/api/services', ServiceCatalogController::class)->name('api.services');

// /login y /admin/* devuelven 404 — el panel vive en la ruta configurada en ADMIN_PREFIX.
Route::get('/login', fn () => abort(404))->name('login');
Route::get('/admin/{any?}', fn () => abort(404))->where('any', '.*');

Route::prefix(env('ADMIN_PREFIX', 'dc-staff'))->name('admin.')->group(function (): void {
    Route::middleware(['guest', 'throttle:5,1'])->group(function (): void {
        Route::get('login', [AdminAuthController::class, 'create'])->name('login');
        Route::post('login', [AdminAuthController::class, 'store'])->name('login.store');
    });

    Route::middleware(['auth', 'admin'])->group(function (): void {
        // Always accessible to any admin user
        Route::post('logout', [AdminAuthController::class, 'destroy'])->name('logout');
        Route::post('notifications/seen', [AdminNotificationController::class, 'markAllSeen'])->name('notifications.seen');
        Route::get('/', AdminDashboardController::class)->name('dashboard');

        // Clients
        Route::middleware('can:manage_clients')->group(function (): void {
            Route::patch('clientes/{client}/toggle-active', [AdminClientController::class, 'toggleActive'])->name('clientes.toggle-active');
            Route::resource('clientes', AdminClientController::class)->except(['show'])->parameters(['clientes' => 'client']);
        });

        // Invoices
        Route::middleware('can:manage_invoices')->group(function (): void {
            Route::get('facturas/{invoice}/pdf/preview', [AdminInvoiceController::class, 'pdfPreview'])->name('facturas.pdf.preview');
            Route::post('facturas/{invoice}/pdf/email', [AdminInvoiceController::class, 'emailPdf'])->name('facturas.pdf.email');
            Route::get('facturas/{invoice}/pdf', [AdminInvoiceController::class, 'pdf'])->name('facturas.pdf');
            Route::resource('facturas', AdminInvoiceController::class)->parameters(['facturas' => 'invoice']);
        });

        // Leads / Quote requests
        Route::middleware('can:manage_leads')->group(function (): void {
            Route::get('estimaciones', [AdminLeadController::class, 'index'])->name('leads.index');
            Route::get('estimaciones/{lead}', [AdminLeadController::class, 'show'])->name('leads.show');
            Route::patch('estimaciones/{lead}', [AdminLeadController::class, 'update'])->name('leads.update');
        });

        // Configuration
        Route::prefix('configuracion')->name('configuracion.')->group(function (): void {
            Route::middleware('can:manage_services')->group(function (): void {
                Route::resource('servicios', AdminServiceController::class)->except(['show'])->parameters(['servicios' => 'service']);
            });
            Route::middleware('can:manage_site_sections')->group(function (): void {
                Route::get('secciones', [AdminSiteSectionController::class, 'index'])->name('secciones.index');
                Route::patch('secciones/{section}', [AdminSiteSectionController::class, 'update'])->name('secciones.update');
            });
        });

        // Team management — owner only (unchanged)
        Route::middleware('owner')->group(function (): void {
            Route::patch('usuarios/{user}/toggle-active', [AdminUserController::class, 'toggleActive'])->name('usuarios.toggle-active');
            Route::resource('usuarios', AdminUserController::class)->except(['show'])->parameters(['usuarios' => 'user']);
        });
    });
});
