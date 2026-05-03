@extends('layouts.app')

@section('title', 'Order Details - ' . $order->order_id)

@push('styles')
<style>
.order-details-page {font-family: 'Inter', sans-serif;}
.order-header {background: linear-gradient(120deg, #0d47a1, #1e88e5); color: #fff; border-radius: 16px; padding: 28px; margin-bottom: 24px;}
.order-info-grid {display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 30px;}
.info-card {background: #f8fafc; border-radius: 12px; padding: 18px; border: 1px solid #e5e7eb;}
.info-card h5 {font-size: 14px; font-weight: 600; color: #1e293b; margin-bottom: 12px; border-bottom: 2px solid #e2e8f0; padding-bottom: 8px;}
.info-card p {margin-bottom: 6px; font-size: 14px; color: #334155;}
.info-card .label {font-weight: 600; color: #475569; width: 100px; display: inline-block;}
.order-items-table {width: 100%; border-collapse: collapse; margin-bottom: 24px;}
.order-items-table th {background: #f1f5f9; padding: 12px; text-align: left; font-weight: 600; color: #1e293b; border-bottom: 2px solid #e2e8f0;}
.order-items-table td {padding: 12px; border-bottom: 1px solid #e5e7eb; vertical-align: top;}
.order-items-table .product-img {width: 60px; height: 60px; object-fit: cover; border-radius: 8px;}
.totals-section {background: #f8fafc; border-radius: 12px; padding: 20px; max-width: 350px; margin-left: auto;}
.totals-row {display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #e2e8f0;}
.totals-row.grand-total {font-weight: 700; font-size: 18px; border-bottom: none; padding-top: 12px;}
.status-timeline {display: flex; align-items: center; justify-content: space-between; margin: 30px 0; position: relative;}
.timeline-step {text-align: center; flex: 1; position: relative; z-index: 1;}
.timeline-step .step-icon {width: 40px; height: 40px; background: #e2e8f0; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 8px; color: #64748b;}
.timeline-step.completed .step-icon {background: #0d47a1; color: white;}
.timeline-step.active .step-icon {background: #1e88e5; color: white; box-shadow: 0 0 0 4px rgba(30,136,229,0.2);}
.timeline-step .step-label {font-size: 12px; font-weight: 500; color: #64748b;}
.timeline-step.completed .step-label {color: #0d47a1; font-weight: 600;}
.timeline-line {position: absolute; top: 20px; left: 0; right: 0; height: 2px; background: #e2e8f0; z-index: 0;}
.action-buttons {display: flex; gap: 12px; justify-content: flex-end; margin-top: 24px;}
.btn-outline {padding: 10px 20px; border-radius: 8px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; border: 1px solid #cbd5e1; background: white; color: #333;}
.btn-outline:hover {background: #f1f5f9;}
.btn-primary {background: #0d47a1; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px; border: none;}
.btn-primary:hover {background: #1565c0;}
.status-pill {display: inline-flex; align-items: center; gap: 6px; border-radius: 20px; padding: 6px 12px; font-weight: 600; font-size: 12px; text-transform: uppercase; letter-spacing: 0.4px;}
.status-placed {background: #e8f0fe; color: #1a73e8;}
.status-processing {background: #fff4e5; color: #c47f00;}
.status-shipped {background: #e3f2fd; color: #0d47a1;}
.status-delivered {background: #e6f4ea; color: #0f9d58;}
.status-cancelled {background: #fdecea; color: #c62828;}
@media (max-width: 768px) {
    .order-info-grid {grid-template-columns: 1fr;}
    .order-items-table {display: block; overflow-x: auto;}
    .status-timeline {flex-direction: column; gap: 16px; align-items: flex-start;}
    .timeline-line {display: none;}
    .timeline-step {display: flex; gap: 12px; align-items: center; width: 100%;}
    .timeline-step .step-icon {margin: 0;}
    .totals-section {max-width: 100%;}
    .action-buttons {flex-wrap: wrap; justify-content: center;}
}
</style>
@endpush

@section('content')
<div class="container my-4 order-details-page">
    <!-- Order Header -->
    <div class="order-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <div class="h4 mb-1">Order Details</div>
                <div class="small text-light">Order ID: {{ $order->order_id }}</div>
            </div>
            <div>
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
                @endphp
                <span class="status-pill {{ $statusClass }}">
                    <span class="material-icons" style="font-size:14px;">fiber_manual_record</span>
                    {{ $statusText }}
                </span>
            </div>
        </div>
    </div>

    <!-- Order Status Timeline -->
    <div class="status-timeline">
        <div class="timeline-line"></div>
        @php
            $statuses = [
                1 => ['label' => 'Placed', 'date' => $order->created_at],
                2 => ['label' => 'Processing', 'date' => null],
                3 => ['label' => 'Shipped', 'date' => null],
                4 => ['label' => 'Delivered', 'date' => null],
            ];
            $currentStatus = $order->status ?? 1;
        @endphp
        @foreach($statuses as $key => $step)
            @php
                $isCompleted = $currentStatus >= $key;
                $isActive = $currentStatus == $key;
            @endphp
            <div class="timeline-step {{ $isCompleted ? 'completed' : '' }} {{ $isActive ? 'active' : '' }}">
                <div class="step-icon">
                    <span class="material-icons" style="font-size:20px;">
                        @if($key == 1) check_circle
                        @elseif($key == 2) settings
                        @elseif($key == 3) local_shipping
                        @else check_circle
                        @endif
                    </span>
                </div>
                <div class="step-label">{{ $step['label'] }}</div>
                @if($step['date'] && $isCompleted)
                    <div class="step-date" style="font-size:10px; color:#94a3b8;">
                        {{ \Carbon\Carbon::parse($step['date'])->format('d M Y') }}
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    <!-- Order Information Grid -->
    <div class="order-info-grid">
        <!-- Shipping Information -->
        <div class="info-card">
            <h5>Shipping Address</h5>
            @php
                $shipping = $order->shippingInfo;
            @endphp
            @if($shipping)
                <p><strong>{{ $shipping->customer_name ?? '' }}</strong></p>
                <p>{{ $shipping->customer_address_1 ?? '' }}</p>
                @if($shipping->customer_address_2)
                    <p>{{ $shipping->customer_address_2 }}</p>
                @endif
                <p>{{ $shipping->city ?? '' }}, {{ $shipping->state ?? '' }}</p>
                <p>{{ $shipping->country ?? '' }} - {{ $shipping->zip ?? '' }}</p>
                <p>Phone: {{ $shipping->customer_mobile ?? '' }}</p>
                <p>Email: {{ $shipping->customer_email ?? '' }}</p>
            @else
                <p>Shipping information not available</p>
            @endif
        </div>

        <!-- Payment Information -->
        <div class="info-card">
            <h5>Payment Information</h5>
            @php
                $payment = $order->payments->first();
                $isCod = $payment && (
                    ($payment->payment_id ?? null) === 1 ||
                    str_contains(strtolower($payment->details ?? ''), 'cash on delivery')
                );
                $isPaid = !$isCod && (
                    (!is_null($order->due_amount) && (float) $order->due_amount <= 0) ||
                    (!is_null($order->total_amount) && (float) $order->paid_amount >= (float) $order->total_amount)
                );
            @endphp
            <p><span class="label">Method:</span> {{ $isCod ? 'Cash on Delivery' : ($payment->details ?? 'Not specified') }}</p>
            <p><span class="label">Status:</span> {{ $isPaid ? 'Paid' : ($isCod ? 'Pending (Pay at delivery)' : 'Pending') }}</p>
            <p><span class="label">Total Amount:</span> ₹{{ number_format((float) ($order->total_amount ?? 0), 2) }}</p>
            @if($order->paid_amount > 0)
                <p><span class="label">Paid:</span> ₹{{ number_format((float) $order->paid_amount, 2) }}</p>
            @endif
            @if($order->due_amount > 0)
                <p><span class="label">Due:</span> ₹{{ number_format((float) $order->due_amount, 2) }}</p>
            @endif
        </div>

        <!-- Delivery Information -->
        <div class="info-card">
            <h5>Delivery Information</h5>
            @php
                $delivery = $order->delivery;
            @endphp
            @if($delivery)
                <p><span class="label">Method:</span> {{ $delivery->details ?? 'Standard Delivery' }}</p>
                <p><span class="label">Status:</span> 
                    @if($order->status == 4)
                        Delivered
                    @elseif($order->status == 3)
                        Shipped
                    @elseif($order->status == 2)
                        Processing
                    @else
                        Pending
                    @endif
                </p>
                @if($order->order_notes)
                    <p><span class="label">Notes:</span> {{ $order->order_notes }}</p>
                @endif
            @else
                <p>Delivery information not available</p>
            @endif
        </div>
    </div>

    <!-- Order Items Table -->
    <div style="overflow-x: auto;">
        <table class="order-items-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Variant</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderDetails as $item)
                    @php
                        $product = $item->product;
                        $thumb = $product?->image_thumb ? ($baseUrl . $product->image_thumb) : ($baseUrl . '/my-assets/image/product.png');
                    @endphp
                    <tr>
                        <td>
                            <div style="display: flex; gap: 12px; align-items: center;">
                                <img src="{{ $thumb }}" alt="{{ $product->product_name ?? 'Product' }}" class="product-img">
                                <div>
                                    <div style="font-weight: 600;">{{ $product->product_name ?? 'Product' }}</div>
                                    @if($product?->categoryDetails?->category_name)
                                        <div style="font-size: 11px; color: #94a3b8;">{{ $product->categoryDetails->category_name }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <td>{{ $item->variant?->variant_name ?? 'Standard' }}</div>
                        <td>{{ $item->quantity }}</div>
                        <td>₹{{ number_format((float) $item->rate, 2) }}</div>
                        <td style="font-weight: 600;">₹{{ number_format((float) $item->total_price, 2) }}</div>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Totals Section -->
    <div class="totals-section">
        <div class="totals-row">
            <span>Subtotal</span>
            <span>₹{{ number_format($subtotal, 2) }}</span>
        </div>
        
        @if($order->order_discount > 0)
        <div class="totals-row">
            <span>Discount</span>
            <span>-₹{{ number_format($order->order_discount, 2) }}</span>
        </div>
        @endif
        
        @foreach($order->taxSummaries as $tax)
        <div class="totals-row">
            <span>Tax ({{ $tax->tax?->tax_name ?? $tax->tax_id ?? 'GST' }})</span>
            <span>₹{{ number_format($tax->tax_amount, 2) }}</span>
        </div>
        @endforeach
        
        @if($order->service_charge > 0)
        <div class="totals-row">
            <span>Service Charge</span>
            <span>₹{{ number_format($order->service_charge, 2) }}</span>
        </div>
        @endif
        
        <div class="totals-row grand-total">
            <span>Grand Total</span>
            <span>₹{{ number_format($totalAmount, 2) }}</span>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="action-buttons">
        <a href="{{ route('orders.index') }}" class="btn-outline">
            <span class="material-icons" style="font-size:18px;">arrow_back</span> Back to Orders
        </a>
        <a href="{{ route('order.invoice', $order->order_id) }}" class="btn-primary" target="_blank">
            <span class="material-icons" style="font-size:18px;">print</span> View Invoice
        </a>
        <a href="{{ route('contact.index') }}" class="btn-outline">
            <span class="material-icons" style="font-size:18px;">support_agent</span> Need Help?
        </a>
    </div>
</div>
@endsection