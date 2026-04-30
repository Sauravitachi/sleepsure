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

/* Modal Styles */
.modal-content {
    border-radius: 20px;
    border: none;
    overflow: hidden;
}
.modal-header {
    background: linear-gradient(135deg, #0d47a1, #1565c0);
    color: white;
    padding: 20px 24px;
    border-bottom: none;
}
.modal-header .modal-title {
    font-weight: 600;
    font-size: 20px;
}
.modal-header .btn-close {
    filter: brightness(0) invert(1);
    opacity: 0.8;
}
.modal-header .btn-close:hover {
    opacity: 1;
}
.modal-body {
    padding: 24px;
    background: #f8fafc;
}
.modal-footer {
    padding: 16px 24px;
    background: white;
    border-top: 1px solid #e5e7eb;
}
.form-label {
    font-weight: 600;
    font-size: 13px;
    color: #0f172a;
    margin-bottom: 6px;
}
.form-control {
    border-radius: 10px;
    border: 1px solid #e2e8f0;
    padding: 10px 14px;
    font-size: 14px;
    transition: all 0.2s;
}
.form-control:focus {
    border-color: #0d47a1;
    box-shadow: 0 0 0 3px rgba(13,71,161,0.1);
}
.btn-primary {
    background: linear-gradient(135deg, #0d47a1, #1565c0);
    border: none;
    border-radius: 10px;
    padding: 8px 20px;
    font-weight: 500;
}
.btn-primary:hover {
    background: linear-gradient(135deg, #0b3d8a, #1155a0);
    transform: translateY(-1px);
}
.btn-secondary {
    background: #f1f5f9;
    border: 1px solid #e2e8f0;
    color: #475569;
    border-radius: 10px;
    padding: 8px 20px;
    font-weight: 500;
}
.btn-secondary:hover {
    background: #e2e8f0;
    color: #0f172a;
}
.edit-profile-btn {
    background: linear-gradient(135deg, #0d47a1, #1565c0);
    color: white;
    border: none;
    border-radius: 10px;
    padding: 6px 16px;
    font-size: 13px;
    font-weight: 500;
    transition: all 0.2s;
}
.edit-profile-btn:hover {
    transform: translateY(-1px);
    background: linear-gradient(135deg, #0b3d8a, #1155a0);
    color: white;
}
.text-danger {
    font-size: 12px;
    margin-top: 4px;
    display: block;
}
.alert {
    border-radius: 12px;
    border: none;
    padding: 12px 20px;
}
.alert-success {
    background: #e6f4ea;
    color: #0f9d58;
}
.alert-danger {
    background: #fdecea;
    color: #c62828;
}
@media (max-width:768px){
    .account-hero{flex-direction:column; align-items:flex-start;}
    .modal-body {
        padding: 16px;
    }
}
</style>
@endpush

@section('content')
<div class="container my-4 account-page">
    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
            <span class="material-icons" style="font-size:16px; vertical-align:middle;">check_circle</span>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
            <span class="material-icons" style="font-size:16px; vertical-align:middle;">error</span>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

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
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="fw-semibold fs-5">Profile Information</div>
            <button type="button" class="edit-profile-btn" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                <span class="material-icons" style="font-size:16px;">edit</span> Edit Profile
            </button>
        </div>
        <div class="info-row"><div class="info-label">Full Name</div><div class="fw-medium">{{ $customer->customer_name }}</div></div>
        <div class="info-row"><div class="info-label">Email Address</div><div>{{ $customer->customer_email ?? 'Not set' }}</div></div>
        <div class="info-row"><div class="info-label">Mobile Number</div><div>{{ $customer->customer_mobile ?? 'Not set' }}</div></div>
        <div class="info-row"><div class="info-label">City</div><div>{{ $customer->city ?? 'Not set' }}</div></div>
    </div>

    <div class="section-card">
        <div class="fw-semibold mb-2">Quick Actions</div>
        <div class="quick-links">
            <a class="quick-link" href="{{ route('orders.index') }}">
                <span class="material-icons">assignment</span>
                <div>
                    <div class="fw-semibold">My Orders</div>
                    <div class="text-muted" style="font-size:13px;">Track and view past orders</div>
                </div>
            </a>
            <a class="quick-link" href="{{ route('wishlist.index') }}">
                <span class="material-icons">favorite_border</span>
                <div>
                    <div class="fw-semibold">Wishlist</div>
                    <div class="text-muted" style="font-size:13px;">Items you saved</div>
                </div>
            </a>
            <a class="quick-link" href="{{ route('cart.index') }}">
                <span class="material-icons">shopping_cart</span>
                <div>
                    <div class="fw-semibold">Cart</div>
                    <div class="text-muted" style="font-size:13px;">Checkout your bag</div>
                </div>
            </a>
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
                            <div class="fw-semibold">Order #{{ $order->order_id }}</div>
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

<!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('account.updateProfile') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalLabel">
                        <span class="material-icons" style="font-size:20px; vertical-align:middle;">person</span>
                        Edit Your Profile
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="customer_name" class="form-control @error('customer_name') is-invalid @enderror" 
                               value="{{ old('customer_name', $customer->customer_name) }}" required>
                        @error('customer_name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Email Address <span class="text-danger">*</span></label>
                        <input type="email" name="customer_email" class="form-control @error('customer_email') is-invalid @enderror" 
                               value="{{ old('customer_email', $customer->customer_email) }}" required>
                        @error('customer_email') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Mobile Number</label>
                        <input type="text" name="customer_mobile" class="form-control @error('customer_mobile') is-invalid @enderror" 
                               value="{{ old('customer_mobile', $customer->customer_mobile) }}" placeholder="Enter 10 digit mobile number">
                        @error('customer_mobile') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="alert alert-info mt-3" style="background:#e8f0fe; color:#1a73e8; font-size:12px; padding:10px;">
                        <span class="material-icons" style="font-size:14px;">info</span>
                        Your email and mobile number will be used for order updates and communication.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <span class="material-icons" style="font-size:16px;">close</span> Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <span class="material-icons" style="font-size:16px;">save</span> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection