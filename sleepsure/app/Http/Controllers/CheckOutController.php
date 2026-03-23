<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\CustomerInformation;
use App\Models\ShippingInfo;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\OrderDelivery;
use App\Models\OrderPayment;
use App\Models\OrderTaxColSummary;
use App\Models\OrderTaxColDetails;
use App\Models\SoftSetting;
use App\Models\Store;
use App\Models\PaymentGateway;
use App\Models\EmailConfiguration;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class CheckOutController extends Controller
{
    public function store(Request $request)
    {
        try {
            // Validate required fields
            $request->validate([
                'first_name' => ['required', 'string', 'min:2', 'max:255', 'regex:/^[\pL\s\'.-]+$/u'],
                'last_name' => ['required', 'string', 'min:1', 'max:255', 'regex:/^[\pL\s\'.-]+$/u'],
                'customer_email' => 'required|email:rfc|max:255',
                'customer_mobile' => ['required', 'regex:/^\+?[0-9]{10,15}$/'],
                'customer_address_line_1' => 'required|string|min:5|max:255',
                'ship_city' => ['required', 'string', 'min:2', 'max:100', 'regex:/^[\pL\s\'.-]+$/u'],
                'ship_state' => ['required', 'string', 'min:2', 'max:100', 'regex:/^[\pL\s\'.-]+$/u'],
                'country' => ['required', 'string', 'min:2', 'max:100', 'regex:/^[\pL\s\'.-]+$/u'],
                'ship_zip' => ['required', 'string', 'min:4', 'max:10', 'regex:/^[A-Za-z0-9\s-]{4,10}$/'],
                'cart' => 'required|array|min:1',
                'total_amount' => 'required|numeric|min:0',
                'payment_method' => 'required|string|in:COD,razorpay'
            ], [
                'customer_mobile.regex' => 'Phone number must be 10 to 15 digits and may start with +.',
                'ship_zip.regex' => 'ZIP code must be 4 to 10 characters and can contain letters, numbers, spaces, and hyphen.',
            ]);

            // Step 1: Generate random order id
            $order_id = strtoupper(Str::random(15));

            // Step 2: Create short address
            $short_address = $request->ship_city . ', ' . $request->ship_state . ', ' . $request->country . ', ' . $request->ship_zip;

            $customer = Auth()->user();
            if (!$customer instanceof CustomerInformation) {
                $customer = CustomerInformation::where('customer_email', $request->customer_email)->first();
            }

            ShippingInfo::create([
                'shiping_info_id'      => strtoupper(Str::random(15)),
                'customer_id'          => $customer->customer_id,
                'order_id'             => $order_id,
                'customer_name'        => trim($request->first_name . ' ' . $request->last_name),
                'first_name'           => $request->first_name,
                'last_name'            => $request->last_name,
                'customer_short_address' => $short_address,
                'customer_address_1'   => $request->customer_address_line_1,
                'customer_address_2'   => $request->customer_address_line_2 ?? '',
                'customer_mobile'      => $request->customer_mobile,
                'customer_email'       => $request->customer_email,
                'city'                 => $request->ship_city,
                'state'                => $request->ship_state,
                'country'              => $request->country, 
                'zip'                  => $request->ship_zip,
                'company'              => $request->company ?? '',
            ]);

            $default_store = DB::table('store_set')->where('default_status', 1)->first();
            $store_id = $default_store ? $default_store->store_id : null;

            // Step 5: Create order
            $orderData = [
                'order_id'        => $order_id,
                'customer_id'     => $customer->customer_id, 
                'store_id'        => $store_id,
                'user_id' => Auth()->id() ? (string) Auth()->id() : '0',
                'date'            => date('m-d-Y'),
                'total_amount'    => $request->total_amount ?? 0,
                'order'           => $request->order_number ?? $order_id,
                'details'         => '', // fill as needed
                'total_discount'  => $request->total_discount ?? null,
                'order_discount'  => $request->order_discount ?? null,
                'service_charge'  => $request->service_charge ?? null,
                'paid_amount'     => $request->payment_method == 'COD' ? 0 : ($request->paid_amount ?? 0),
                'due_amount'      => $request->payment_method == 'razorpay' ? $request->total_amount : ($request->due_amount ?? 0),
                'file_path'       => $request->file_path ?? '',
                'coupon'          => $request->coupon ?? null,
                'order_notes'     => $request->order_notes ?? null,
                'status'          => 1,
                'created_at'      => now(),
            ];

            Order::create($orderData);

            OrderDelivery::create([
                'order_delivery_id' => strtoupper(Str::random(15)),
                'delivery_id' => $request->delivery_method ?? 1, 
                'order_id' => $order_id,
                'details' => $request->delivery_details ?? '',
            ]);

            OrderPayment::create([
                'order_payment_id' => strtoupper(Str::random(15)),
                'payment_id' => $request->payment_method == 'COD' ? 1 : 2, // 1 for COD, 2 for Razorpay
                'order_id' => $order_id,
                'details' => $request->payment_method == 'COD' ? 'Cash on Delivery' : 'Razorpay - Payment Pending',
            ]);

            foreach ($request->cart as $item) {
                OrderDetails::create([
                    'order_details_id'  => strtoupper(Str::random(15)),
                    'order_id'          => $order_id,
                    'product_id'        => $item['product_id'],
                    'variant_id'        => $item['variant'],
                    'variant_color'     => $item['variant_color'] ?? null,
                    'store_id'          => $store_id,
                    'quantity'          => $item['qty'],
                    'rate'              => $item['actual_price'],
                    'supplier_rate'     => $item['supplier_price'],
                    'total_price'       => $item['actual_price'] * $item['qty'],
                    'discount'          => 0,
                    'product_discount'  => $item['discount'],
                    'status'            => 1
                ]);

                // CGST Tax summary
                if (!empty($item['options']['cgst_id'])) {
                    $cgst_summary = [
                        'order_tax_col_id' => strtoupper(Str::random(15)),
                        'order_id' => $order_id,
                        'tax_amount' => $item['options']['cgst'] * $item['qty'],
                        'tax_id' => $item['options']['cgst_id'],
                        'date' => date('m-d-Y'),
                    ];
                    $result = OrderTaxColSummary::where('order_id', $order_id)
                        ->where('tax_id', $item['options']['cgst_id'])
                        ->count();
                    if ($result > 0) {
                        OrderTaxColSummary::where('order_id', $order_id)
                            ->where('tax_id', $item['options']['cgst_id'])
                            ->increment('tax_amount', $item['options']['cgst'] * $item['qty']);
                    } else {
                        OrderTaxColSummary::create($cgst_summary);
                    }
                    OrderTaxColDetails::create([
                        'order_tax_col_de_id' => strtoupper(Str::random(15)),
                        'order_id' => $order_id,
                        'amount' => $item['options']['cgst'] * $item['qty'],
                        'product_id' => $item['product_id'],
                        'tax_id' => $item['options']['cgst_id'],
                        'variant_id' => $item['variant'],
                        'date' => date('m-d-Y'),
                    ]);
                }
                // IGST Tax summary
                if (!empty($item['options']['igst_id'])) {
                    $igst_summary = [
                        'order_tax_col_id' => strtoupper(Str::random(15)),
                        'order_id' => $order_id,
                        'tax_amount' => $item['options']['igst'] * $item['qty'],
                        'tax_id' => $item['options']['igst_id'],
                        'date' => date('m-d-Y'),
                    ];
                    $result = OrderTaxColSummary::where('order_id', $order_id)
                        ->where('tax_id', $item['options']['igst_id'])
                        ->count();
                    if ($result > 0) {
                        OrderTaxColSummary::where('order_id', $order_id)
                            ->where('tax_id', $item['options']['igst_id'])
                            ->increment('tax_amount', $item['options']['igst'] * $item['qty']);
                    } else {
                        OrderTaxColSummary::create($igst_summary);
                    }
                    OrderTaxColDetails::create([
                        'order_tax_col_de_id' => strtoupper(Str::random(15)),
                        'order_id' => $order_id,
                        'amount' => $item['options']['igst'] * $item['qty'],
                        'product_id' => $item['product_id'],
                        'tax_id' => $item['options']['igst_id'],
                        'variant_id' => $item['variant'],
                        'date' => date('m-d-Y'),
                    ]);
                }
                // SGST Tax summary
                if (!empty($item['options']['sgst_id'])) {
                    $sgst_summary = [
                        'order_tax_col_id' => strtoupper(Str::random(15)),
                        'order_id' => $order_id,
                        'tax_amount' => $item['options']['sgst'] * $item['qty'],
                        'tax_id' => $item['options']['sgst_id'],
                        'date' => date('m-d-Y'),
                    ];
                    $result = OrderTaxColSummary::where('order_id', $order_id)
                        ->where('tax_id', $item['options']['sgst_id'])
                        ->count();
                    if ($result > 0) {
                        OrderTaxColSummary::where('order_id', $order_id)
                            ->where('tax_id', $item['options']['sgst_id'])
                            ->increment('tax_amount', $item['options']['sgst'] * $item['qty']);
                    } else {
                        OrderTaxColSummary::create($sgst_summary);
                    }
                    OrderTaxColDetails::create([
                        'order_tax_col_de_id' => strtoupper(Str::random(15)),
                        'order_id' => $order_id,
                        'amount' => $item['options']['sgst'] * $item['qty'],
                        'product_id' => $item['product_id'],
                        'tax_id' => $item['options']['sgst_id'],
                        'variant_id' => $item['variant'],
                        'date' => date('m-d-Y'),
                    ]);
                }
            }

            // Step 12: Send WhatsApp message if enabled
            $sms_status = SoftSetting::first()->sms_service ?? 0;
            if ($sms_status == 1) {
                // Implement send_sms logic or call service
                // $this->send_sms($order_id, $customer->customer_id, "Order");
            }

            // Step 13: Send order confirmation email using env/config (no DB override)
            try {
                if (empty($customer->customer_email)) {
                    Log::info('Order email skipped: customer email missing', ['order_id' => $order_id]);
                } else {
                    $subject = 'Your SleepSure order ' . $order_id;
                    $body = "Hi {$request->first_name},\n\n" .
                        'Thank you for your order with SleepSure.' . "\n" .
                        'Order ID: ' . $order_id . "\n" .
                        'Total Amount: ₹' . number_format((float)$request->total_amount, 2) . "\n" .
                        'Payment Method: ' . $request->payment_method . "\n\n" .
                        'We will notify you when your order is on the way.';

                    Mail::raw($body, function ($message) use ($customer, $subject) {
                        $message->to($customer->customer_email)
                            ->subject($subject);
                    });

                    Log::info('Order confirmation email sent', [
                        'order_id' => $order_id,
                        'customer_email' => $customer->customer_email,
                    ]);
                }
            } catch (\Throwable $ex) {
                Log::warning('Order email failed', [
                    'order_id' => $order_id,
                    'error' => $ex->getMessage(),
                ]);
            }

            // Return different responses based on payment method
            $response = [
                'success' => true,
                'order_id' => $order_id,
                'payment_method' => $request->payment_method,
                'customer_email' => $customer->customer_email,
                'customer_mobile' => $customer->customer_mobile,
                'total_amount' => $request->total_amount
            ];

            if ($request->payment_method === 'razorpay') {
                $response['needs_payment'] = true;
            }

            return response()->json($response);
        
        } catch(\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'message' => 'Validation failed', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }
}

