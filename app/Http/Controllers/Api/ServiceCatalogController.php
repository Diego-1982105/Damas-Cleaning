<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\JsonResponse;

class ServiceCatalogController extends Controller
{
    /**
     * Catálogo público para la landing (lista de servicios y precios).
     */
    public function __invoke(): JsonResponse
    {
        $rows = Service::query()
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get(['id', 'name', 'price']);

        return response()->json([
            'data' => $rows,
        ]);
    }
}
