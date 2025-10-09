<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Http\Controllers\Web\WebController;
use App\Models\Purchase;

class ExecutaDashboardMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $webController = new WebController();

        $recentPurchases = Purchase::where('status', 'approved')
            ->orderBy('id', 'desc')
            ->limit(1)
            ->get();

        foreach ($recentPurchases as $purchase) {
            $webController->api_simples($purchase->id);  
        }

        return $next($request);
    }
}
