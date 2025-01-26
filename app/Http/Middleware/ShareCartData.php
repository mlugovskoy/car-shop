<?php

namespace App\Http\Middleware;

use App\Http\Resources\TransportResource;
use App\Services\CartService;
use Closure;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

class ShareCartData
{
    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $items = $this->cartService->getCartItems();

            Inertia::share('cart', function () use ($items) {
                return [
                    'total' => $this->cartService->total(),
                    'count' => $items->count(),
                    'items' => TransportResource::collection($items->pluck('transport')),
                ];
            });
        } else {
            Inertia::share('cart', [
                'total' => 0,
                'count' => 0,
                'items' => [],
            ]);
        }

        return $next($request);
    }
}
