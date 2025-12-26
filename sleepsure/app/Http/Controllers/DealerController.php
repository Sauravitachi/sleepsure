<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\UserLogin;
use App\Models\User;

class DealerController extends Controller
{
    //This function is used to Generate Key
    public function generator($lenth)
    {
        $number = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "N", "M", "O", "P", "Q", "R", "S", "U", "V", "T", "W", "X", "Y", "Z", "1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
        $con = '';
        for ($i = 0; $i < $lenth; $i++) {
            $rand_value = rand(0, 34);
            $rand_number = $number[$rand_value];

            if (empty($con)) {
                $con = $rand_number;
            } else {
                $con = "$con" . "$rand_number";
            }
        }
        return $con;
    }

    public function register(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'fullName' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mobile' => 'required|string|max:20',
            'city' => 'required|string|max:100',
            'userType' => 'required|in:landlord,dealer',
            'notifications' => 'nullable|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Generate unique user_id
            $user_id = $this->generator(15);

            // Check if user_id already exists (unlikely but possible)
            while (UserLogin::where('user_id', $user_id)->exists()) {
                $user_id = $this->generator(15);
            }

            // Split full name into first and last name
            $nameParts = explode(' ', trim($request->fullName), 2);
            $first_name = $nameParts[0];
            $last_name = isset($nameParts[1]) ? $nameParts[1] : '';

            // Generate default password (you might want to generate random or send via email)
            $default_password = 'dealer123'; 
            $password = md5("gef" . $default_password);

            // Determine user_type based on selection
            // 6=dealer, 8=landlord
            $user_type = ($request->userType === 'dealer') ? 6 : 8;

            // Determine is_notify
            $is_notify = $request->notifications ? 'yes' : 'no';

            // Start transaction
            DB::beginTransaction();

            UserLogin::create([
                'user_id' => $user_id,
                'store_id' => '', // Empty string for varchar field
                'username' => $request->email,
                'password' => $password,
                'phone' => $request->mobile,
                'token' => '',
                'user_type' => $user_type,
                'is_notify' => $is_notify,
                'security_code' => '',
                'status' => 1
            ]);

            // Insert into users table
            User::create([
                'user_id' => $user_id,
                'last_name' => $last_name,
                'first_name' => $first_name,
                'gender' => 1, // Default to male, you might want to add gender field to form
                'date_of_birth' => null,
                'logo' => null,
                'status' => 1
            ]);

            // Commit transaction
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Thank you for your interest! We will contact you soon.',
                'user_id' => $user_id,
                'default_password' => $default_password // Send this via email in production
            ], 200);

        } catch (\Exception $e) {
            // Rollback transaction on error
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your request. Please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
