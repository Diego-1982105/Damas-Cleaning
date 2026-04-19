<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Http\JsonResponse;

class NotificationController extends Controller
{
    /** Mark all unseen leads as seen. */
    public function markAllSeen(): JsonResponse
    {
        Lead::unseen()->update(['seen_at' => now()]);

        return response()->json(['ok' => true]);
    }
}
