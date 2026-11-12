<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Water;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        // auth()->user(): admin ählisini, adaty ulanyjy diňe öz sargytlaryny görýär
        $user = auth()->user();

        if ($user->isAdmin()) {
            $orders = Order::whereHas('water')->with(['user', 'water'])->latest()->paginate(15);
        } else {
            $orders = $user->orders()->whereHas('water')->with('water')->latest()->paginate(15);
        }

        return view('orders.index', compact('orders'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate(Order::validationRules());

        $order = DB::transaction(function () use ($validated) {
            $water = Water::lockForUpdate()->findOrFail($validated['water_id']);

            if ($water->stock < $validated['quantity']) {
                return null;
            }

            $order = auth()->user()->orders()->create([
                'water_id' => $water->id,
                'quantity' => $validated['quantity'],
                'total_price' => $water->price * $validated['quantity'],
                'delivery_address' => $validated['delivery_address'],
                'phone' => $validated['phone'],
                'notes' => $validated['notes'] ?? null,
            ]);

            $water->decrement('stock', $validated['quantity']);

            return $order;
        });

        if (! $order) {
            return back()
                ->withErrors(['quantity' => __('messages.insufficient_stock')])
                ->withInput();
        }

        return redirect()->route('orders.index')->with('success', __('messages.order_created'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:'.implode(',', Order::STATUSES),
        ]);

        $user = auth()->user();

        if (! $user->isAdmin()) {
            // Adaty ulanyjy diňe öz garaşylýan sargydyny ýatyryp biler
            abort_unless(
                $order->user_id === $user->id
                && $order->status === 'pending'
                && $validated['status'] === 'cancelled',
                403,
                __('messages.unauthorized')
            );
        }

        DB::transaction(function () use ($order, $validated) {
            $wasCancelled = $order->status === 'cancelled';

            // Ýatyrylanda ammara yzyna gaýtarýarys; ýatyrylandan täzeden açylanda alýarys
            if ($validated['status'] === 'cancelled' && ! $wasCancelled) {
                $order->water()->increment('stock', $order->quantity);
            } elseif ($wasCancelled && $validated['status'] !== 'cancelled') {
                $order->water()->decrement('stock', $order->quantity);
            }

            $order->update(['status' => $validated['status']]);
        });

        return redirect()->route('orders.index')->with('success', __('messages.order_updated'));
    }

    public function destroy(Order $order)
    {
        DB::transaction(function () use ($order) {
            if (! in_array($order->status, ['delivered', 'cancelled'], true)) {
                $order->water()->increment('stock', $order->quantity);
            }

            $order->delete();
        });

        return redirect()->route('orders.index')->with('success', __('messages.order_deleted'));
    }
}
