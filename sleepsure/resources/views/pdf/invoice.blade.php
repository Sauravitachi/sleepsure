<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Invoice - {{ $order->order_id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'DejaVu Sans', 'Segoe UI', Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            padding: 30px;
            background: white;
        }
        
        .invoice-container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #0d47a1;
        }
        
        .header h1 {
            color: #0d47a1;
            font-size: 32px;
            margin-bottom: 8px;
            font-weight: bold;
        }
        
        .header .company-details {
            color: #666;
            font-size: 11px;
            margin-top: 5px;
        }
        
        .invoice-title {
            background: #0d47a1;
            color: white;
            padding: 10px 20px;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        
        .info-row {
            display: flex;
            margin-bottom: 25px;
            gap: 20px;
            flex-wrap: wrap;
        }
        
        .info-box {
            flex: 1;
            background: #f8fafc;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }
        
        .info-box h4 {
            color: #0d47a1;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 2px solid #e2e8f0;
        }
        
        .info-box p {
            margin-bottom: 5px;
            font-size: 11px;
            line-height: 1.5;
        }
        
        .info-box .label {
            font-weight: 600;
            color: #475569;
            width: 100px;
            display: inline-block;
        }
        
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }
        
        .status-placed { background: #e8f0fe; color: #1a73e8; }
        .status-processing { background: #fff4e5; color: #c47f00; }
        .status-shipped { background: #e3f2fd; color: #0d47a1; }
        .status-delivered { background: #e6f4ea; color: #0f9d58; }
        .status-cancelled { background: #fdecea; color: #c62828; }
        
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        
        .items-table th {
            background: #f1f5f9;
            padding: 12px;
            text-align: left;
            font-weight: 600;
            font-size: 12px;
            color: #1e293b;
            border-bottom: 2px solid #e2e8f0;
        }
        
        .items-table td {
            padding: 10px 12px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 11px;
        }
        
        .items-table .product-name {
            font-weight: 600;
            color: #1e293b;
        }
        
        .totals-section {
            margin-top: 20px;
            text-align: right;
        }
        
        .totals-table {
            width: 320px;
            margin-left: auto;
            border-collapse: collapse;
        }
        
        .totals-table td {
            padding: 8px 12px;
            border: none;
            font-size: 12px;
        }
        
        .totals-table .grand-total {
            font-weight: bold;
            font-size: 14px;
            border-top: 2px solid #e2e8f0;
            padding-top: 10px;
            margin-top: 5px;
        }
        
        .footer {
            margin-top: 40px;
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
            font-size: 10px;
            color: #94a3b8;
        }
        
        .amount {
            font-weight: 600;
            color: #0d47a1;
        }
        
        .amount-in-words {
            margin-top: 20px;
            padding: 10px;
            background: #f8fafc;
            border-radius: 5px;
            font-size: 11px;
            color: #475569;
        }
        
        .terms {
            margin-top: 30px;
            font-size: 10px;
            color: #64748b;
        }
        
        .terms strong {
            font-size: 11px;
        }
        
        /* Print Button Styles */
        .print-btn-container {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .print-btn {
            background: #0d47a1;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        
        .print-btn:hover {
            background: #1565c0;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        }
        
        .print-btn:active {
            transform: translateY(0);
        }
        
        /* Print Styles */
        @media print {
            .print-btn-container {
                display: none;
            }
            body {
                padding: 0;
                margin: 0;
            }
            .invoice-container {
                box-shadow: none;
                padding: 0;
                margin: 0;
            }
            .info-box {
                break-inside: avoid;
                page-break-inside: avoid;
            }
            .items-table tr {
                break-inside: avoid;
                page-break-inside: avoid;
            }
        }
        
        /* Mobile Responsive */
        @media (max-width: 768px) {
            body {
                padding: 15px;
            }
            .info-row {
                flex-direction: column;
                gap: 15px;
            }
            .totals-table {
                width: 100%;
            }
            .items-table {
                display: block;
                overflow-x: auto;
            }
        }
    </style>
</head>
<body>
    <!-- Print Button -->
    <div class="print-btn-container">
        <button onclick="window.print();" class="print-btn">
            🖨️ Print / Save as PDF
        </button>
    </div>
    
    <div class="invoice-container">
        <!-- Header -->
        <div class="header">
            <h1>{{ $company['company_name'] ?? 'SleepSure' }}</h1>
            <div class="company-details">
                <p>{{ $company['address'] ?? '123 Sleep Street, Dream City, India' }}</p>
                <p>Email: {{ $company['email'] ?? 'support@sleepsure.com' }} | Phone: {{ $company['phone'] ?? '1800-123-4567' }}</p>
                <p>GST: {{ $company['gst'] ?? '27AAACA1234B1Z' }}</p>
            </div>
        </div>

        <!-- Invoice Title -->
        <div class="invoice-title">
            TAX INVOICE
        </div>

        <!-- Invoice Info Row -->
        <div class="info-row">
            <div class="info-box">
                <h4>INVOICE DETAILS</h4>
                <p><span class="label">Invoice No:</span> {{ $order->order_id }}</p>
                <p><span class="label">Invoice Date:</span> {{ date('d-m-Y', strtotime($order->created_at)) }}</p>
                <p><span class="label">Order ID:</span> {{ $order->order_id }}</p>
                <p><span class="label">Order Date:</span> {{ date('d-m-Y', strtotime($order->created_at)) }}</p>
                @if($order->order)
                <p><span class="label">Order Ref:</span> {{ $order->order }}</p>
                @endif
            </div>
            
            <div class="info-box">
                <h4>ORDER STATUS</h4>
                @php
                    $status = $order->status ?? 1;
                    $statusText = $statusLabels[$status] ?? 'Placed';
                    $statusClass = match ($status) {
                        3 => 'status-shipped',
                        4 => 'status-delivered',
                        5 => 'status-cancelled',
                        2 => 'status-processing',
                        default => 'status-placed',
                    };
                @endphp
                <p><span class="label">Status:</span> <span class="status-badge {{ $statusClass }}">{{ $statusText }}</span></p>
                <p><span class="label">Payment Method:</span> 
                    @php
                        $payment = $order->payments->first();
                        $isCod = $payment && (($payment->payment_id ?? null) == 1 || str_contains(strtolower($payment->details ?? ''), 'cash on delivery'));
                    @endphp
                    {{ $isCod ? 'Cash on Delivery' : ($payment->details ?? 'Not specified') }}
                </p>
                <p><span class="label">Payment Status:</span> 
                    @php
                        $isPaid = !$isCod && ((float)($order->paid_amount ?? 0) >= (float)($order->total_amount ?? 0));
                    @endphp
                    {{ $isPaid ? 'Paid' : ($isCod ? 'Pending (Pay at delivery)' : 'Pending') }}
                </p>
                @if($order->order_notes)
                <p><span class="label">Notes:</span> {{ $order->order_notes }}</p>
                @endif
            </div>
        </div>

        <!-- Customer & Shipping Info Row -->
        <div class="info-row">
            <div class="info-box">
                <h4>BILLING ADDRESS</h4>
                @php $shipping = $order->shippingInfo; @endphp
                @if($shipping)
                    <p><strong>{{ $shipping->customer_name ?? $customer->customer_name ?? '' }}</strong></p>
                    <p>{{ $shipping->customer_address_1 ?? '' }}</p>
                    @if($shipping->customer_address_2)
                        <p>{{ $shipping->customer_address_2 }}</p>
                    @endif
                    <p>{{ $shipping->city ?? '' }}{{ ($shipping->city && $shipping->state) ? ',' : '' }} {{ $shipping->state ?? '' }}</p>
                    <p>{{ $shipping->country ?? '' }} - {{ $shipping->zip ?? '' }}</p>
                    <p>Phone: {{ $shipping->customer_mobile ?? '' }}</p>
                    <p>Email: {{ $shipping->customer_email ?? $customer->customer_email ?? '' }}</p>
                @else
                    <p>{{ $customer->customer_name ?? '' }}</p>
                    <p>{{ $customer->customer_address_1 ?? '' }}</p>
                    <p>{{ $customer->city ?? '' }}, {{ $customer->state ?? '' }}</p>
                    <p>Phone: {{ $customer->customer_mobile ?? '' }}</p>
                    <p>Email: {{ $customer->customer_email ?? '' }}</p>
                @endif
            </div>
            
            <div class="info-box">
                <h4>SHIPPING ADDRESS</h4>
                @if($shipping)
                    <p><strong>{{ $shipping->customer_name ?? '' }}</strong></p>
                    <p>{{ $shipping->customer_address_1 ?? '' }}</p>
                    @if($shipping->customer_address_2)
                        <p>{{ $shipping->customer_address_2 }}</p>
                    @endif
                    <p>{{ $shipping->city ?? '' }}{{ ($shipping->city && $shipping->state) ? ',' : '' }} {{ $shipping->state ?? '' }}</p>
                    <p>{{ $shipping->country ?? '' }} - {{ $shipping->zip ?? '' }}</p>
                    <p>Phone: {{ $shipping->customer_mobile ?? '' }}</p>
                @else
                    <p>Same as billing address</p>
                @endif
            </div>
        </div>

        <!-- Order Items Table -->
        <table class="items-table">
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th width="40%">Product</th>
                    <th width="15%">Variant</th>
                    <th width="10%">Quantity</th>
                    <th width="15%">Unit Price</th>
                    <th width="15%">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderDetails as $index => $item)
                @php
                    $product = $item->product;
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <div class="product-name">{{ $product->product_name ?? 'Product' }}</div>
                    </td>
                    <td>{{ $item->variant?->variant_name ?? 'Standard' }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>₹{{ number_format((float) $item->rate, 2) }}</td>
                    <td class="amount">₹{{ number_format((float) $item->total_price, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Totals Section -->
        <div class="totals-section">
            <table class="totals-table">
                <tr>
                    <td width="200">Subtotal:</td>
                    <td width="120" class="amount">₹{{ number_format($subtotal, 2) }}</td>
                </tr>
                @if($order->order_discount && $order->order_discount > 0)
                <tr>
                    <td>Discount:</td>
                    <td class="amount">- ₹{{ number_format($order->order_discount, 2) }}</td>
                </tr>
                @endif
                @foreach($order->taxSummaries as $tax)
                <tr>
                    <td>Tax ({{ $tax->tax_id ?? 'GST' }}):</td>
                    <td class="amount">₹{{ number_format($tax->tax_amount, 2) }}</td>
                </tr>
                @endforeach
                @if($order->service_charge && $order->service_charge > 0)
                <tr>
                    <td>Service Charge:</td>
                    <td class="amount">₹{{ number_format($order->service_charge, 2) }}</td>
                </tr>
                @endif
                <tr class="grand-total">
                    <td><strong>Grand Total:</strong></td>
                    <td><strong>₹{{ number_format($totalAmount, 2) }}</strong></td>
                </tr>
                @if($order->paid_amount > 0)
                <tr>
                    <td>Amount Paid:</td>
                    <td>₹{{ number_format($order->paid_amount, 2) }}</td>
                </tr>
                @endif
                @if($order->due_amount > 0)
                <tr>
                    <td>Due Amount:</td>
                    <td>₹{{ number_format($order->due_amount, 2) }}</td>
                </tr>
                @endif
            </table>
        </div>

        <!-- Amount in Words -->
        <div class="amount-in-words">
            <strong>Amount in Words:</strong> 
            @php
                function convertNumberToWords($number) {
                    $ones = array(
                        0 => 'Zero', 1 => 'One', 2 => 'Two', 3 => 'Three', 4 => 'Four',
                        5 => 'Five', 6 => 'Six', 7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
                        10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve', 13 => 'Thirteen',
                        14 => 'Fourteen', 15 => 'Fifteen', 16 => 'Sixteen', 17 => 'Seventeen',
                        18 => 'Eighteen', 19 => 'Nineteen'
                    );
                    
                    $tens = array(
                        2 => 'Twenty', 3 => 'Thirty', 4 => 'Forty', 5 => 'Fifty',
                        6 => 'Sixty', 7 => 'Seventy', 8 => 'Eighty', 9 => 'Ninety'
                    );
                    
                    if ($number < 20) {
                        return $ones[$number];
                    }
                    
                    if ($number < 100) {
                        $t = floor($number / 10);
                        $o = $number % 10;
                        return $tens[$t] . ($o ? ' ' . $ones[$o] : '');
                    }
                    
                    if ($number < 1000) {
                        $h = floor($number / 100);
                        $r = $number % 100;
                        return $ones[$h] . ' Hundred' . ($r ? ' ' . convertNumberToWords($r) : '');
                    }
                    
                    if ($number < 100000) {
                        $th = floor($number / 1000);
                        $r = $number % 1000;
                        return convertNumberToWords($th) . ' Thousand' . ($r ? ' ' . convertNumberToWords($r) : '');
                    }
                    
                    if ($number < 10000000) {
                        $l = floor($number / 100000);
                        $r = $number % 100000;
                        return convertNumberToWords($l) . ' Lakh' . ($r ? ' ' . convertNumberToWords($r) : '');
                    }
                    
                    $c = floor($number / 10000000);
                    $r = $number % 10000000;
                    return convertNumberToWords($c) . ' Crore' . ($r ? ' ' . convertNumberToWords($r) : '');
                }
                
                $rupees = floor($totalAmount);
                $paise = round(($totalAmount - $rupees) * 100);
                $words = convertNumberToWords($rupees) . ' Rupees';
                if ($paise > 0) {
                    $words .= ' and ' . convertNumberToWords($paise) . ' Paise';
                }
            @endphp
            {{ ucwords($words) }} Only
        </div>

        <!-- Terms & Conditions -->
        <div class="terms">
            <strong>Terms & Conditions:</strong><br>
            1. This is a system generated invoice and does not require signature.<br>
            2. Goods once sold cannot be returned or exchanged.<br>
            3. Subject to jurisdiction of Dream City courts.<br>
            4. For any queries, please contact support within 7 days of invoice date.
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Thank you for shopping with {{ $company['company_name'] ?? 'SleepSure' }}!</p>
            <p>For any queries, please contact us at {{ $company['email'] ?? 'support@sleepsure.com' }} or call {{ $company['phone'] ?? '1800-123-4567' }}</p>
            <p>Visit us: {{ $company['website'] ?? 'www.sleepsure.com' }}</p>
        </div>
    </div>
    
    <script>
        // Auto trigger print dialog (optional - uncomment if you want print dialog to open automatically)
        // window.onload = function() {
        //     window.print();
        // }
    </script>
</body>
</html>