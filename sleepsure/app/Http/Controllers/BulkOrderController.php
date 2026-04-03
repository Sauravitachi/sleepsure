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
            // Proper email validation
            'email' => 'required|email:rfc,dns|max:255',
            // Phone: strictly 10 digits numeric
            'phone' => 'required|digits:10',
            'client_type' => 'required|string|max:50',
            'quantity' => 'required|string|max:100',
            'message' => 'nullable|string'
        ], [
            'company.required' => 'Company is required.',
            'contact.required' => 'Contact person is required.',

            'email.required' => 'Email is required.',
            'email.email' => 'Please enter a valid email address.',

            'phone.required' => 'Phone number is required.',
            'phone.digits' => 'Phone number must be exactly 10 digits.',

            'client_type.required' => 'Client type is required.',
            'quantity.required' => 'Quantity is required.'
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
