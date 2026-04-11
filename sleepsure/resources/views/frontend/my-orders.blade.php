@extends('layouts.app')

@section('title', 'My Orders')

@push('styles')
<style>
.my-orders-page {font-family: 'Inter', sans-serif;}
.my-orders-hero {background: linear-gradient(120deg, #0d47a1, #1e88e5); color: #fff; border-radius: 16px; padding: 28px; display: flex; align-items: center; gap: 16px; box-shadow: 0 12px 32px rgba(13,71,161,0.18);}
.my-orders-hero .material-icons {font-size: 36px;}
.order-card {border: 1px solid #e5e7eb; border-radius: 14px; padding: 16px; margin-bottom: 18px; box-shadow: 0 6px 18px rgba(0,0,0,0.05);}
.order-card .card-top {display: flex; justify-content: space-between; gap: 12px; align-items: center; flex-wrap: wrap;}
.status-pill {display: inline-flex; align-items: center; gap: 6px; border-radius: 20px; padding: 6px 12px; font-weight: 600; font-size: 12px; text-transform: uppercase; letter-spacing: 0.4px;}
.status-placed {background: #e8f0fe; color: #1a73e8;}
.status-processing {background: #fff4e5; color: #c47f00;}
.status-shipped {background: #e3f2fd; color: #0d47a1;}
.status-delivered {background: #e6f4ea; color: #0f9d58;}
.status-cancelled {background: #fdecea; color: #c62828;}
.order-meta {color: #6b7280; font-size: 13px; display: flex; gap: 12px; flex-wrap: wrap;}
.order-total {font-weight: 700; font-size: 16px; color: #111827;}
.order-items {margin-top: 14px; border-top: 1px dashed #e5e7eb; padding-top: 12px; display: grid; gap: 10px;}
.order-item {display: grid; grid-template-columns: 64px 1fr auto; gap: 12px; align-items: center;}
.order-item img {width: 64px; height: 64px; object-fit: cover; border-radius: 10px; border: 1px solid #f1f3f5; background: #f8fafc;}
.item-title {font-weight: 600; color: #111827;}
.item-meta {font-size: 12px; color: #6b7280; display: flex; gap: 10px; flex-wrap: wrap;}
.badge-soft {display: inline-block; padding: 4px 8px; border-radius: 10px; font-size: 11px; background: #f3f4f6; color: #4b5563;}
.card-footer {margin-top: 10px; display: flex; justify-content: space-between; flex-wrap: wrap; gap: 10px; align-items: center;}
.action-links a {font-weight: 600; font-size: 13px; text-decoration: none; color: #1a73e8; display: inline-flex; align-items: center; gap: 6px;}
.empty-state {text-align: center; padding: 56px 20px; border: 1px dashed #cbd5e1; border-radius: 14px; background: #f8fafc;}
.empty-state .material-icons {font-size: 48px; color: #9ca3af;}
@media (max-width: 768px) {
    .my-orders-hero {flex-direction: column; align-items: flex-start;}
    .order-item {grid-template-columns: 56px 1fr; grid-template-areas: 'thumb info' 'thumb meta';}
    .order-item img {grid-area: thumb;}
    .item-title {grid-area: info;}
    .item-meta {grid-area: meta;}
}
</style>
@endpush

@section('content')
<div class="container my-4 my-orders-page">
    <div class="my-orders-hero mb-4">
        <span class="material-icons">assignment</span>
        <div>
            <div class="h4 mb-1">My Orders</div>
            <div class="small text-light">Track purchases, check status, and view items you've ordered.</div>
        </div>
    </div>

    @if($orders->isEmpty())
        <div class="empty-state">
            <span class="material-icons d-block mb-2">inventory_2</span>
            <div class="h5 mb-2">You haven't placed any orders yet</div>
            <p class="text-muted mb-3">Browse our collections and start your first purchase.</p>
            <a href="{{ route('home') }}" class="btn btn-primary">Start Shopping</a>
        </div>
    @else
        @foreach($orders as $order)
            @php
                $status = $order->status ?? 0;
                $statusText = $statusLabels[$status] ?? 'Placed';
                $statusClass = match ($status) {
                    3 => 'status-shipped',
                    4 => 'status-delivered',
                    5 => 'status-cancelled',
                    2 => 'status-processing',
                    default => 'status-placed',
                };
                $placedDate = $order->created_at ? \Carbon\Carbon::parse($order->created_at)->format('d M Y') : ($order->date ?? '');
                $paymentDetails = $order->payments->first();
                $isCod = $paymentDetails && (
                    ($paymentDetails->payment_id ?? null) === 1 ||
                    str_contains(strtolower($paymentDetails->details), 'cash on delivery')
                );
                $isPaid = !$isCod && (
                    (!is_null($order->due_amount) && (float) $order->due_amount <= 0) ||
                    (!is_null($order->total_amount) && (float) $order->paid_amount >= (float) $order->total_amount)
                );
                $paymentLabel = $isPaid
                    ? 'Paid'
                    : ($isCod
                        ? 'Cash on Delivery (Pay at delivery)'
                        : ($paymentDetails->details ?? 'Payment Pending'));
            @endphp
            <div class="order-card">
                <div class="card-top">
                    <div>
                        <div class="fw-semibold">Order ID: {{ $order->order_id }}</div>
                        <div class="order-meta">
                            @if($placedDate)<span>Placed on {{ $placedDate }}</span>@endif
                            <span>{{ $paymentLabel }}</span>
                            @if($order->delivery && $order->delivery->details)
                                <span>Delivery: {{ $order->delivery->details }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="order-total">₹{{ number_format((float) ($order->total_amount ?? 0), 2) }}</div>
                        <span class="status-pill {{ $statusClass }}">
                            <span class="material-icons" style="font-size:14px;">fiber_manual_record</span>
                            {{ $statusText }}
                        </span>
                    </div>
                </div>

                <div class="order-items">
                    @foreach($order->orderDetails as $item)
                        @php
                            $product = $item->product;
                            $variantLabel = $item->variant?->variant_name;
                            $thumb = $product?->image_thumb ? asset($product->image_thumb) : 'https://via.placeholder.com/80x80?text=Product';
                        @endphp
                        <div class="order-item">
                            <img src="{{ $thumb }}" alt="{{ $product->product_name ?? 'Product' }}">
                            <div>
                                <div class="item-title">{{ $product->product_name ?? 'Product' }}</div>
                                <div class="item-meta">
                                    <span class="badge-soft">Qty: {{ $item->quantity }}</span>
                                    <span class="badge-soft">₹{{ number_format((float) $item->total_price, 2) }}</span>
                                    @if($variantLabel)
                                        <span class="badge-soft">Variant: {{ $variantLabel }}</span>
                                    @endif
                                    @if($product?->categoryDetails?->category_name)
                                        <span>{{ $product->categoryDetails->category_name }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="text-end" style="font-weight:700; color:#111827;">₹{{ number_format((float) ($item->rate * $item->quantity), 2) }}</div>
                        </div>
                    @endforeach
                </div>

                <div class="card-footer">
                    <div class="text-muted" style="font-size:13px;">Need help? Contact support with your Order ID.</div>
                    <div class="action-links">
                        <a href="{{ route('order.details', $order->order_id) }}">
                            <span class="material-icons" style="font-size:16px;">visibility</span> View Details
                        </a>
                        <a href="{{ route('order.invoice', $order->order_id) }}" target="_blank">
                            <span class="material-icons" style="font-size:16px;">receipt</span> Invoice
                        </a>
                        <a href="{{ route('contact.index') }}">
                            <span class="material-icons" style="font-size:16px;">support_agent</span> Support
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection
