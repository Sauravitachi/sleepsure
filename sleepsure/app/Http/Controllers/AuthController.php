<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerInformation;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;

class AuthController extends Controller
{
   public function proxySendOtp(Request $request)
{
    $request->validate([
        'mobile' => 'required|digits:10',
    ]);

    $mobile = $request->input('mobile');
    $client = new Client();

    try {
        $response = $client->post('https://sleepauth.kodesoft.store/app/sendmessage', [
            'form_params' => [
                'mobile' => $mobile,
                'type' => 'otp',
            ]
        ]);
        $data = json_decode($response->getBody(), true);

        if (isset($data['success']) && $data['success'] == "true") {
            session(['otp_phone' => $mobile]);
            // Return OTP in response for alert (for testing only)
            return response()->json([
                'success' => true,
                'message' => 'OTP sent successfully',
                'otp' => $data['otp'] ?? null // Show OTP in alert
            ]);
        } else {
            return response()->json(['success' => false, 'message' => 'Failed to send OTP'], 500);
        }
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Error sending OTP'], 500);
    }
}
  public function proxyVerifyOtp(Request $request)
{
    $request->validate([
        'otp' => 'required|digits:6',
    ]);

    $mobile = session('otp_phone');
    if (!$mobile) {
        return response()->json(['success' => false, 'message' => 'Session expired. Please try again.'], 401);
    }

    $otp = $request->input('otp');
    $client = new Client();

    try {
        $response = $client->post('https://sleepauth.kodesoft.store/app/verifyotp', [
            'form_params' => [
                'mobile' => $mobile,
                'otp' => $otp,
            ]
        ]);
        $data = json_decode($response->getBody(), true);

        if (isset($data['success']) && $data['success'] == "true") {
            $user = CustomerInformation::where('customer_mobile', $mobile)->first();
            if (!$user) {
                $user = CustomerInformation::create([
                    'customer_id' => (string) \Str::uuid(),
                    'customer_mobile' => $mobile,
                    'customer_name' => $mobile,
                    'status' => 1,
                ]);
            }
            Auth::login($user);
            return response()->json(['success' => true, 'message' => 'OTP Matched']);
        } else {
            return response()->json(['success' => false, 'message' => 'Invalid OTP'], 401);
        }
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Error verifying OTP'], 500);
    }
}


    /**
     * Show login form
     */
    public function showLogin()
    {
        $global = globalData();
        return view('auth.login', $global);
    }

    /**
     * Show signup form
     */
    public function showSignup()
    {
        $global = globalData();
        return view('auth.signup', $global);
    }

    /**
     * Handle login - Send OTP
     */
   public function login(Request $request)
{
    $field = $request->has('customer_mobile') ? 'customer_mobile' : 'phone';

    $validator = Validator::make($request->all(), [
        $field => 'required|digits:10'
    ]);

    if ($validator->fails()) {
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first($field)
            ], 422);
        }
        return back()->withErrors($validator)->withInput();
    }

    // ✅ ALWAYS USE THIS VARIABLE
    $phone = $request->input($field);

    /* ================= DEV BYPASS ================= */
    if (app()->environment('local') || env('AUTH_BYPASS', false)) {
        $customer = CustomerInformation::where('customer_mobile', $phone)->first();

        if (!$customer) {
            $customer = CustomerInformation::create([
                'customer_id' => strtoupper(Str::random(15)),
                'customer_name' => 'Customer ' . $phone,
                'first_name' => 'Customer',
                'last_name' => 'N/A',
                'birth_day' => null,
                'customer_short_address' => 'N/A',
                'customer_address_1' => 'N/A',
                'customer_address_2' => 'N/A',
                'city' => 'N/A',
                'state' => 'N/A',
                'country' => 'N/A',
                'zip' => 'N/A',
                'customer_mobile' => $phone,
                'customer_email' => 'user'.$phone.'@na.local',
                'vat_no' => null,
                'cr_no' => null,
                'previous_balance' => null,
                'image' => 'assets/dist/img/user.png',
                'password' => md5(Str::random(16)),
                'token' => Str::random(40),
                'company' => null,
                'status' => 1,
                'gid' => null,
                'guid' => null,
                'fid' => null,
                'fuid' => null,
                'created_at' => now(),
            ]);
        }

        Auth::login($customer);

        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'redirect' => route('home'),
                'message' => 'Logged in (development bypass enabled)'
            ]);
        }

        return redirect()->route('home')
            ->with('success', 'Logged in (development bypass enabled)');
    }

    /* ================= OTP FLOW ================= */
    $customer = CustomerInformation::where('customer_mobile', $phone)->first();

    if (!$customer) {
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => false,
                'message' => 'User not found. Please sign up first.'
            ], 404);
        }
        return back()->withErrors(['phone' => 'User not found. Please sign up first.'])->withInput();
    }

    // Generate OTP
    $otp = rand(100000, 999999);

    // ✅ FIXED SESSION STORAGE
    session([
        'otp' => $otp,
        'otp_phone' => $phone, // ✅ CORRECT
        'otp_expiry' => now()->addMinutes(5)
    ]);

    \Log::info("OTP for {$phone}: {$otp}");

    if ($request->expectsJson() || $request->is('api/*')) {
        return response()->json([
            'success' => true,
            'otp' => $otp,
            'redirect' => route('otp.verify'),
            'message' => 'OTP sent to your mobile number'
        ]);
    }

    return redirect()->route('otp.verify')
        ->with('success', 'OTP sent to your mobile number');
}

    /**
     * Handle signup
     */
    public function signup(Request $request)
    {
        // Dev bypass: allow signup without password and skip OTP
        if (app()->environment('local') || env('AUTH_BYPASS', false)) {
            $validator = Validator::make($request->all(), [
                'first_name' => 'required|string|max:255',
                'last_name' => 'nullable|string|max:255',
                'customer_email' => 'nullable|email',
                'phone' => 'required|digits:10|unique:customer_information,customer_mobile',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $fullName = $request->first_name . ' ' . $request->last_name;

            $customer = CustomerInformation::create([
                'customer_id' => strtoupper(Str::random(15)),
                'customer_name' => $fullName,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name ?: 'N/A',
                'birth_day' => null,
                'customer_short_address' => 'N/A',
                'customer_address_1' => 'N/A',
                'customer_address_2' => 'N/A',
                'city' => 'N/A',
                'state' => 'N/A',
                'country' => 'N/A',
                'zip' => 'N/A',
                'customer_mobile' => $request->phone,
                'customer_email' => $request->customer_email ?: ('user'.$request->phone.'@na.local'),
                'vat_no' => null,
                'cr_no' => null,
                'previous_balance' => null,
                'image' => 'assets/dist/img/user.png',
                'password' => md5(Str::random(16)),
                'token' => Str::random(40),
                'company' => null,
                'status' => 1,
                'gid' => null,
                'guid' => null,
                'fid' => null,
                'fuid' => null,
                'created_at' => now(),
            ]);

            Auth::login($customer);
            return redirect()->route('home')->with('success', 'Account created and logged in (development bypass enabled)');
        }

        // Normal flow with password and OTP verification
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'customer_email' => 'nullable|email',
            // Ensure uniqueness against customer_information table
            'phone' => 'required|digits:10|unique:customer_information,customer_mobile',
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Combine first and last name
        $fullName = $request->first_name . ' ' . $request->last_name;

        // Create user
        $customer = CustomerInformation::create([
            'customer_id' => strtoupper(Str::random(15)),
            'customer_name' => $fullName,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name ?: 'N/A',
            'birth_day' => null,
            'customer_short_address' => 'N/A',
            'customer_address_1' => 'N/A',
            'customer_address_2' => 'N/A',
            'city' => 'N/A',
            'state' => 'N/A',
            'country' => 'N/A',
            'zip' => 'N/A',
            'customer_mobile' => $request->phone,
            'customer_email' => $request->customer_email ?: ('user'.$request->phone.'@na.local'),
            'vat_no' => null,
            'cr_no' => null,
            'previous_balance' => null,
            'image' => 'assets/dist/img/user.png',
            'password' => md5($request->password),
            'token' => Str::random(40),
            'company' => null,
            'status' => 1,
            'gid' => null,
            'guid' => null,
            'fid' => null,
            'fuid' => null,
            'created_at' => now(),
        ]);

        // Generate OTP for verification
        $otp = rand(100000, 999999);

        session([
            'otp' => $otp,
            'otp_phone' => $request->phone,
            'otp_expiry' => now()->addMinutes(5),
            'user_id' => $customer->customer_id
        ]);

        // TODO: Send OTP via SMS API
        \Log::info("OTP for {$request->phone}: {$otp}");

        return redirect()->route('otp.verify')->with('success', 'Account created! Please verify your mobile number.');
    }

    /**
     * Show OTP verification form
     */
   public function showOtpVerify()
{
    if (!session()->has('otp_phone')) {
        return redirect()->route('login')
            ->withErrors('Session expired. Please login again.');
    }

    $global = globalData();
    return view('auth.otp', $global);
}

    

// public function verifyOtp(Request $request)
// {
//     // ✅ Allow JSON payload
//     $request->merge(json_decode($request->getContent(), true) ?? []);

//     // ✅ Only OTP is required
//     $request->validate([
//         'otp' => 'required|digits:6',
//     ]);

//     // ✅ Get mobile from session (SECURE)
//     $mobile = session('otp_phone');

//     if (!$mobile) {
//         return response()->json([
//             'success' => false,
//             'message' => 'Session expired. Please login again.'
//         ], 401);
//     }

//     /* ================= OTP VERIFY ================= */
//     $client = new Client();

//     try {
//         $res = $client->post('https://sleepauth.kodesoft.store/app/verifyotp', [
//             'form_params' => [
//                 'mobile' => $mobile,
//                 'otp'    => $request->otp,
//             ],
//             'timeout' => 10
//         ]);

//         $body = json_decode($res->getBody(), true);

//         if (!($body['success'] ?? false)) {
//             return response()->json([
//                 'success' => false,
//                 'message' => 'Invalid OTP'
//             ], 422);
//         }

//     } catch (\Exception $e) {
//         \Log::error('OTP verify error', ['error' => $e->getMessage()]);

//         return response()->json([
//             'success' => false,
//             'message' => 'OTP verification service error'
//         ], 500);
//     }

//     /* ================= LOGIN ================= */
//     $customer = CustomerInformation::where(
//         'customer_mobile',
//         $mobile
//     )->first();

//     if (!$customer) {
//         return response()->json([
//             'success' => true,
//             'is_new_user' => true,
//             'redirect' => route('register')
//         ]);
//     }

//     auth()->login($customer);

//     session([
//         'customer_id' => $customer->id,
//         'otp_verified' => true
//     ]);

//     return response()->json([
//         'success' => true,
//         'is_new_user' => false,
//         'redirect' => route('dashboard')
//     ]);
// }

//     public function resendOtp()
//     {
//         $phone = session('otp_phone');

//         if (!$phone) {
//             return response()->json([
//                 'success' => false,
//                 'message' => 'Session expired'
//             ], 401);
//         }

//         $client = new \GuzzleHttp\Client();

//         try {
//             $client->post('https://sleepauth.kodesoft.store/app/sendmessage', [
//                 'form_params' => [
//                     'mobile' => $phone,
//                     'type' => 'otp'
//                 ]
//             ]);

//             return response()->json([
//                 'success' => true,
//                 'message' => 'OTP resent successfully'
//             ]);

//         } catch (\Exception $e) {
//             return response()->json([
//                 'success' => false,
//                 'message' => 'Failed to resend OTP'
//             ], 500);
//         }
//     }

    /**
     * Logout
     */
    public function logout()
    {
        Auth::logout();
        session()->flush();
        return redirect()->route('home')->with('success', 'Logged out successfully!');
    }
}
