@extends('layouts.app')

@section('title', __('messages.orders_title').' — '.__('messages.brand'))

@section('content')
@php($isAdmin = auth()->user()->isAdmin())

<div class="head">
    <div>
        <h1 class="page-title">📦 {{ $isAdmin ? __('messages.orders_title') : __('messages.my_orders_title') }}</h1>
    </div>
    <a href="{{ route('waters.index') }}" class="btn btn-primary">💧 {{ __('messages.nav_catalog') }}</a>
</div>

<div class="glass pad-sm">
    @if($orders->isEmpty())
        <p class="center muted" style="padding:30px">{{ __('messages.no_orders') }}</p>
    @else
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        @if($isAdmin)<th>{{ __('messages.customer') }}</th>@endif
                        <th>{{ __('messages.product') }}</th>
                        <th>{{ __('messages.quantity') }}</th>
                        <th>{{ __('messages.total') }}</th>
                        <th>{{ __('messages.phone') }} / {{ __('messages.delivery_address') }}</th>
                        <th>{{ __('messages.status') }}</th>
                        <th class="right">{{ __('messages.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td><strong>#{{ $order->id }}</strong><small>{{ $order->created_at->format('d.m.Y H:i') }}</small></td>
                            @if($isAdmin)
                                <td><strong>{{ $order->user->name ?? '—' }}</strong><small>{{ $order->user->email ?? '' }}</small></td>
                            @endif
                            <td><strong>{{ $order->water->name }}</strong></td>
                            <td>{{ $order->quantity }}</td>
                            <td><strong>{{ $order->formatted_total }}</strong></td>
                            <td>📞 {{ $order->phone }}<small>📍 {{ $order->delivery_address }}</small></td>
                            <td>
                                @if($isAdmin)
                                    <form method="POST" action="{{ route('orders.status', $order) }}">
                                        @csrf @method('PUT')
                                        <select name="status" class="input" style="padding:6px 10px" onchange="this.form.submit()">
                                            @foreach(\App\Models\Order::STATUSES as $st)
                                                <option value="{{ $st }}" @selected($order->status === $st)>{{ __('messages.status_'.$st) }}</option>
                                            @endforeach
                                        </select>
                                    </form>
                                @else
                                    <span class="badge badge-{{ $order->status }}">{{ $order->status_badge }} {{ __('messages.status_'.$order->status) }}</span>
                                @endif
                            </td>
                            <td class="right">
                                @if($isAdmin)
                                    <form method="POST" action="{{ route('orders.destroy', $order) }}" onsubmit="return confirm({{ Js::from(__('messages.confirm_delete')) }})">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">🗑️</button>
                                    </form>
                                @elseif($order->status === 'pending')
                                    <form method="POST" action="{{ route('orders.status', $order) }}">
                                        @csrf @method('PUT')
                                        <input type="hidden" name="status" value="cancelled">
                                        <button type="submit" class="btn btn-danger btn-sm">{{ __('messages.cancel_order') }}</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $orders->links() }}
    @endif
</div>
@endsection
