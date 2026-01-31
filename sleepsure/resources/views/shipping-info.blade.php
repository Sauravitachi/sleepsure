@extends('layouts.app')

@section('title', 'Shipping Information')

@section('content')
<div class="container mt-5">
    <h2>Shipping Information</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{ route('shipping-info.store') }}">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name" value="{{ old('first_name') }}">
                    @error('first_name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" value="{{ old('last_name') }}">
                    @error('last_name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="customer_email">Email</label>
            <input type="email" class="form-control @error('customer_email') is-invalid @enderror" id="customer_email" name="customer_email" value="{{ old('customer_email') }}">
            @error('customer_email')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="customer_mobile">Mobile</label>
            <input type="text" class="form-control @error('customer_mobile') is-invalid @enderror" id="customer_mobile" name="customer_mobile" value="{{ old('customer_mobile') }}">
            @error('customer_mobile')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="customer_address_line_1">Address Line 1</label>
            <input type="text" class="form-control @error('customer_address_line_1') is-invalid @enderror" id="customer_address_line_1" name="customer_address_line_1" value="{{ old('customer_address_line_1') }}">
            @error('customer_address_line_1')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="customer_address_line_2">Address Line 2</label>
            <input type="text" class="form-control @error('customer_address_line_2') is-invalid @enderror" id="customer_address_line_2" name="customer_address_line_2" value="{{ old('customer_address_line_2') }}">
            @error('customer_address_line_2')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="city">City</label>
                    <input type="text" class="form-control @error('city') is-invalid @enderror" id="city" name="city" value="{{ old('city') }}">
                    @error('city')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="state">State</label>
                    <input type="text" class="form-control @error('state') is-invalid @enderror" id="state" name="state" value="{{ old('state') }}">
                    @error('state')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="country">Country</label>
                    <input type="text" class="form-control @error('country') is-invalid @enderror" id="country" name="country" value="{{ old('country') }}">
                    @error('country')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="zip">ZIP</label>
            <input type="text" class="form-control @error('zip') is-invalid @enderror" id="zip" name="zip" value="{{ old('zip') }}">
            @error('zip')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Submit Shipping Info</button>
    </form>
</div>
@endsection
