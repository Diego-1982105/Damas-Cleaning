<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSection;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class SiteSectionController extends Controller
{
    public function index(): View
    {
        $sections = SiteSection::orderBy('sort_order')->get();

        return view('admin.configuracion.secciones', compact('sections'));
    }

    public function update(SiteSection $section): JsonResponse
    {
        $section->update(['enabled' => ! $section->enabled]);

        return response()->json([
            'key'     => $section->key,
            'enabled' => $section->enabled,
        ]);
    }
}
