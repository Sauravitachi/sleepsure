<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{CustomerInformation, SoftSetting};
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;

class AuthController extends Controller
{
    //send otp to mobile via external API
    public function sendOtp(Request $request)
    {
        $request->validate([
            'mobile' => 'required|digits:10',
        ]);

        $client = new \GuzzleHttp\Client();
        $base_url = SoftSetting::pluck('web_base_url')->first();

        $response = $client->post(
            $base_url . 'app/sendmessage',
            [
                'form_params' => [
                    'mobile' => $request->mobile,
                    'type'   => 'otp',
                ]
            ]
        );

        $data = json_decode($response->getBody(), true);

        if (($data['success'] ?? '') === "true") {

            session(['otp_phone' => $request->mobile]);

            return response()->json([
                'success' => true,
                'message' => 'OTP sent successfully',

                'otp' => $data['otp'] ?? null,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Failed to send OTP'
        ], 400);
    }

    //verify otp via external API and login user
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $mobile = session('otp_phone');

        if (!$mobile) {
            return response()->json([
                'success' => false,
                'message' => 'Session expired'
            ], 401);
        }

        $client = new \GuzzleHttp\Client();
        $base_url = SoftSetting::pluck('web_base_url')->first();
        $response = $client->post(
            $base_url . 'app/verifyotp',
            [
                'form_params' => [
                    'mobile' => $mobile,
                    'otp'    => $request->otp,
                ]
            ]
        );

        $data = json_decode($response->getBody(), true);

        if (($data['success'] ?? '') === "true") {

            $user = CustomerInformation::firstOrCreate(
                ['customer_mobile' => $mobile],
                [
                    'customer_id'   => (string) Str::uuid(),
                    'customer_name' => $mobile,
                    'status'        => 1,
                ]
            );

            Auth::login($user);
            session()->forget('otp_phone');

            return response()->json([
                'success' => true,
                'redirect' => route('home'),
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid OTP'
        ], 401);
    }

    //Show login form
    public function showLogin()
    {
        $global = globalData();
        return view('auth.login', $global);
    }

    //Show signup form
    public function showSignup()
    {
        $global = globalData();
        return view('auth.signup', $global);
    }

    //Handle signup with bypass for development and normal flow with OTP verification
    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name'       => 'required|string|max:255',
            'last_name'        => 'nullable|string|max:255',
            'customer_email'   => 'nullable|email',
            'phone'            => 'required|digits:10|unique:customer_information,customer_mobile',
            // 'password'         => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Create user
        $customer = CustomerInformation::create([
            'customer_id'      => strtoupper(Str::random(15)),
            'customer_name'    => trim($request->first_name . ' ' . $request->last_name),
            'first_name'       => $request->first_name,
            'last_name'        => $request->last_name ?: 'N/A',
            'customer_mobile'  => $request->phone,
            'customer_email'   => $request->customer_email ?: ('user'.$request->phone.'@na.local'),
            // 'password'         => md5($request->password),
            'status'           => 1,
            'created_at'       => now(),

            'customer_short_address' => 'N/A', 
            'customer_address_1' => 'N/A', 
            'customer_address_2' => 'N/A', 
            'city' => 'N/A', 
            'state' => 'N/A', 
            'country' => 'N/A', 
            'zip' => 'N/A', 
            'image' => 'assets/dist/img/user.png', 
            'password' => md5('password'), 
            'token' => Str::random(40), 
        ]);

        // Send OTP via SleepAuth
        $client = new \GuzzleHttp\Client();
        $base_url = SoftSetting::pluck('web_base_url')->first();
        $response = $client->post(
            $base_url . 'app/sendmessage',
            [
                'form_params' => [
                    'mobile' => $request->phone,
                    'type'   => 'otp',
                ]
            ]
        );

        $data = json_decode($response->getBody(), true);

        if (($data['success'] ?? '') !== "true") {
            return back()->withErrors('Failed to send OTP. Please try again.');
        }

        // Store mobile in session (used by verifyOtp)
        session(['otp_phone' => $request->phone]);

        //SHOW OTP
        session()->flash('otp_alert', $data['otp'] ?? null);

        return redirect()->route('otp.verify')
            ->with('success', 'Account created! Please verify your mobile number.');
    }

    //Show OTP verification form
    public function showOtpVerify()
    {
        if (!session()->has('otp_phone')) {
            return redirect()->route('login')
                ->withErrors('Session expired. Please login again.');
        }

        $global = globalData();
        return view('auth.otp', $global);
    }
    
    //Logout
    public function logout()
    {
        Auth::logout();
        session()->flush();
        return redirect()->route('home')->with('success', 'Logged out successfully!');
    }
}
