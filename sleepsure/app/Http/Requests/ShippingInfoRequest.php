<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShippingInfoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'customer_id' => 'required|exists:customer_information,customer_id',
            'order_id' => 'nullable|integer',
            'customer_name' => 'nullable|string|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'customer_short_address' => 'nullable|string|max:255',
            'customer_address_line_1' => 'required|string|max:255',
            'customer_address_line_2' => 'nullable|string|max:255',
            'customer_mobile' => 'required|string|max:20',
            'customer_email' => 'required|email|max:255',
            'state' => 'required|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'zip' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:255',
        ];
    }
}
