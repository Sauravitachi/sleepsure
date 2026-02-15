@extends('layouts.app')

@section('title', 'My Account')

@push('styles')
<style>
.account-page {font-family:'Inter', sans-serif;}
.account-hero {background: linear-gradient(135deg,#0d47a1,#1565c0); color:#fff; border-radius:16px; padding:28px; display:flex; align-items:center; gap:16px; box-shadow:0 12px 30px rgba(13,71,161,0.18);}
.account-hero .material-icons {font-size:38px;}
.stat-grid {display:grid; grid-template-columns:repeat(auto-fit,minmax(180px,1fr)); gap:12px; margin-top:16px;}
.stat-card {background:#fff; border:1px solid #e5e7eb; border-radius:12px; padding:14px; box-shadow:0 8px 22px rgba(0,0,0,0.04);}
.stat-label {color:#6b7280; font-size:13px;}
.stat-value {font-size:22px; font-weight:700; color:#0f172a;}
.section-card {background:#fff; border:1px solid #e5e7eb; border-radius:14px; padding:18px; box-shadow:0 8px 22px rgba(0,0,0,0.04); margin-top:16px;}
.info-row {display:flex; justify-content:space-between; gap:12px; padding:10px 0; border-bottom:1px solid #f1f5f9; font-size:14px; color:#0f172a;}
.info-row:last-child {border-bottom:none;}
.info-label {color:#6b7280; min-width:120px;}
.quick-links {display:grid; grid-template-columns:repeat(auto-fit,minmax(220px,1fr)); gap:12px; margin-top:8px;}
.quick-link {display:flex; align-items:center; gap:12px; border:1px solid #e5e7eb; border-radius:12px; padding:12px; text-decoration:none; color:#0f172a; background:#f8fafc; transition:background 0.2s,border-color 0.2s;}
.quick-link:hover {background:#eef2ff; border-color:#c7d2fe;}
.quick-link .material-icons {color:#1d4ed8;}
.order-list {margin-top:12px; display:grid; gap:10px;}
.order-row {border:1px solid #e5e7eb; border-radius:12px; padding:12px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;}
.badge-soft {display:inline-flex; align-items:center; gap:6px; padding:4px 10px; border-radius:999px; background:#f3f4f6; color:#475569; font-size:12px; font-weight:600;}
.status-pill {display:inline-flex; align-items:center; gap:6px; border-radius:20px; padding:6px 12px; font-weight:600; font-size:12px; text-transform:uppercase; letter-spacing:0.4px;}
.status-placed {background:#e8f0fe; color:#1a73e8;}
.status-processing {background:#fff4e5; color:#c47f00;}
.status-shipped {background:#e3f2fd; color:#0d47a1;}
.status-delivered {background:#e6f4ea; color:#0f9d58;}
.status-cancelled {background:#fdecea; color:#c62828;}
@media (max-width:768px){.account-hero{flex-direction:column; align-items:flex-start;}}
</style>
@endpush

@section('content')
<div class="container my-4 account-page">
    <div class="account-hero mb-3">
        <span class="material-icons">account_circle</span>
        <div>
            <div class="h4 mb-1">Hello, {{ $customer->customer_name ?? 'Customer' }}</div>
            <div class="small text-light">Manage your profile, orders, and preferences in one place.</div>
        </div>
    </div>

    <div class="stat-grid">
        <div class="stat-card">
            <div class="stat-label">Total Orders</div>
            <div class="stat-value">{{ $stats['total_orders'] }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">In Progress</div>
            <div class="stat-value">{{ $stats['in_progress'] }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Delivered</div>
            <div class="stat-value">{{ $stats['delivered'] }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">COD Pending</div>
            <div class="stat-value">{{ $stats['cod_pending'] }}</div>
        </div>
    </div>

    <div class="section-card">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <div class="fw-semibold">Profile Info</div>
            <a href="{{ route('orders.index') }}" class="text-primary" style="font-weight:600; font-size:13px;">View Orders</a>
        </div>
        <div class="info-row"><div class="info-label">Name</div><div>{{ $customer->customer_name }}</div></div>
        <div class="info-row"><div class="info-label">Email</div><div>{{ $customer->customer_email ?? 'Not set' }}</div></div>
        <div class="info-row"><div class="info-label">Mobile</div><div>{{ $customer->customer_mobile ?? 'Not set' }}</div></div>
        <div class="info-row"><div class="info-label">City</div><div>{{ $customer->city ?? 'Not set' }}</div></div>
    </div>

    <div class="section-card">
        <div class="fw-semibold mb-2">Quick Actions</div>
        <div class="quick-links">
            <a class="quick-link" href="{{ route('orders.index') }}"><span class="material-icons">assignment</span><div><div class="fw-semibold">My Orders</div><div class="text-muted" style="font-size:13px;">Track and view past orders</div></div></a>
            <a class="quick-link" href="{{ route('wishlist.index') }}"><span class="material-icons">favorite_border</span><div><div class="fw-semibold">Wishlist</div><div class="text-muted" style="font-size:13px;">Items you saved</div></div></a>
            <a class="quick-link" href="{{ route('cart.index') }}"><span class="material-icons">shopping_cart</span><div><div class="fw-semibold">Cart</div><div class="text-muted" style="font-size:13px;">Checkout your bag</div></div></a>
            <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                @csrf
                <button class="quick-link" type="submit" style="width:100%; text-align:left; background:none; border:none; padding:0;">
                    <span class="material-icons">logout</span>
                    <div>
                        <div class="fw-semibold">Logout</div>
                        <div class="text-muted" style="font-size:13px;">Sign out securely</div>
                    </div>
                </button>
            </form>
        </div>
    </div>

    <div class="section-card">
        <div class="fw-semibold mb-2">Recent Orders</div>
        @if($orders->isEmpty())
            <div class="text-muted">No orders yet. Start shopping to see them here.</div>
        @else
            <div class="order-list">
                @foreach($orders->take(3) as $order)
                    @php
                        $status = $order->status ?? 0;
                        $statusClass = match ($status) {
                            3 => 'status-shipped',
                            4 => 'status-delivered',
                            5 => 'status-cancelled',
                            2 => 'status-processing',
                            default => 'status-placed',
                        };
                        $placedDate = $order->created_at ? \Carbon\Carbon::parse($order->created_at)->format('d M Y') : ($order->date ?? '');
                        $payment = $order->payments->first();
                        $isCod = $payment && (($payment->payment_id ?? null) === 1 || str_contains(strtolower($payment->details), 'cash on delivery'));
                        $isPaid = !$isCod && ((float) ($order->due_amount ?? 0) <= 0 || (float) ($order->paid_amount ?? 0) >= (float) ($order->total_amount ?? 0));
                        $paymentLabel = $isPaid ? 'Paid' : ($isCod ? 'Cash on Delivery' : 'Payment Pending');
                    @endphp
                    <div class="order-row">
                        <div>
                            <div class="fw-semibold">Order {{ $order->order_id }}</div>
                            <div class="text-muted" style="font-size:13px;">Placed {{ $placedDate }}</div>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge-soft">{{ $paymentLabel }}</span>
                            <span class="status-pill {{ $statusClass }}">
                                <span class="material-icons" style="font-size:14px;">fiber_manual_record</span>
                                {{ $statusLabels[$status] ?? 'Placed' }}
                            </span>
                            <span class="badge-soft">₹{{ number_format((float) ($order->total_amount ?? 0), 2) }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
