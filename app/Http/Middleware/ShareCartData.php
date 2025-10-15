<?php

namespace App\Http\Middleware;

use App\Http\Resources\TransportResource;
use App\Repositories\CartRepository;
use App\Repositories\Contracts\CartRepositoryInterface;
use Closure;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

class ShareCartData
{
    public function __construct(private CartRepositoryInterface $cartRepository)
    {
    }

    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $items = $this->cartRepository->getCartItems();

            Inertia::share('cart', function () use ($items) {
                return [
                    'total' => $this->cartRepository->total(),
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
