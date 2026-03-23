<?php

namespace App\Http\Controllers;

use App\Models\Enquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BulkOrderController extends Controller
{
    public function index()
    {
        return view('frontend.bulk_order');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'company' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            'email' => ['required', 'email', 'regex:/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/'],
            'phone' => ['required', 'regex:/^\+?[0-9]{7,15}$/'],
            'client_type' => 'required|string|max:50',
            'quantity' => 'required|string|max:100',
            'message' => 'nullable|string'
        ], [
            'phone.regex' => 'Phone number must contain only digits (optionally starting with +) and be 7-15 characters long.',
            'email.regex' => 'Please enter a valid email address.'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $enquiry = Enquiry::create([
                'name' => $request->contact,
                'email' => $request->email,
                'phone' => $request->phone,
                'business_type' => $request->client_type,
                'estimated_qty' => $request->quantity,
                'organisation' => $request->company,
                'requirement' => $request->message ?? '',
                'status' => '1', // 1 = open
                'created_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Your bulk order request has been submitted successfully! Our team will contact you within 2 business Days.',
                'enquiry_id' => $enquiry->id
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while submitting your request. Please try again.'
            ], 500);
        }
    }
}
