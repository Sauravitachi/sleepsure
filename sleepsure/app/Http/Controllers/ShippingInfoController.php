<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShippingInfoRequest;
use App\Models\ShippingInfo;
use Illuminate\Http\Request;

class ShippingInfoController extends Controller
{
    public function store(ShippingInfoRequest $request)
    {
        try {
            $shipping = ShippingInfo::create($request->validated());
            return redirect()->back()->with('success', 'Shipping information saved successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => 'Failed to save shipping information.']);
        }
    }
}
