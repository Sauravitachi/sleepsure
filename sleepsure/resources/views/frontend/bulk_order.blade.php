@extends('layouts.app')

@section('title', 'Premium Mattress & Sleep Solutions')

@section('content')

<div class="bulk-container">
        <!-- Bulk Order Form -->
        <section class="bulk-form-section">
            <h2 class="section-title">Request a Bulk Quote</h2>
            
            <div id="successMessage" class="alert alert-success" style="display:none; margin-bottom: 20px;">
                Your bulk order request has been submitted successfully! Our team will contact you within 2 business hours.
            </div>
            
            <div id="errorMessage" class="alert alert-danger" style="display:none; margin-bottom: 20px;"></div>
            
            <form id="bulkOrderForm" method="POST" action="{{ route('bulk-order.store') }}">
                @csrf
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label" for="company">Company Name *</label>
                        <input type="text" class="form-control" id="company" name="company" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="contact">Contact Person *</label>
                        <input type="text" class="form-control" id="contact" name="contact" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="email">Email Address *</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="phone">Phone Number *</label>
                        <input type="tel" class="form-control" id="phone" name="phone" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="client-type">Business Type *</label>
                        <select class="form-control" id="client-type" name="client_type" required>
                            <option value="">Select your business type</option>
                            <option value="hotel">Hotel/Resort</option>
                            <option value="corporate">Corporate Housing</option>
                            <option value="university">University/College</option>
                            <option value="healthcare">Healthcare Facility</option>
                            <option value="property">Property Management</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="quantity">Estimated Quantity *</label>
                        <select class="form-control" id="quantity" name="quantity" required>
                            <option value="">Select quantity range</option>
                            <option value="10-25">10-25 units</option>
                            <option value="26-50">26-50 units</option>
                            <option value="51-100">51-100 units</option>
                            <option value="101-250">101-250 units</option>
                            <option value="251-500">251-500 units</option>
                            <option value="500+">500+ units</option>
                        </select>
                    </div>



                    <div class="form-group form-full">
                        <label class="form-label" for="message">Additional Requirements</label>
                        <textarea class="form-control" id="message" name="message"
                            placeholder="Tell us about your specific needs, delivery timeline, custom requirements..."></textarea>
                    </div>
                </div>

                <button type="submit" class="btn-primary" id="submitBtn" style="width: 100%; margin-top: var(--spacing-lg);">
                    <i class="fas fa-paper-plane"></i> Submit Quote Request
                </button>
            </form>
        </section>




        <!-- CTA Section -->
        <section class="cta-section">
            <h2 class="cta-title">Ready to Place Your Bulk Order?</h2>
            <p>Contact our commercial sales team for personalized pricing and custom solutions</p>

            <div class="cta-buttons">
                <button class="btn-primary">
                    <i class="fas fa-phone"></i> Call Sales: (800) 555-7325
                </button>
                <button class="btn-secondary">
                    <i class="fas fa-envelope"></i> Email Commercial Team
                </button>
            </div>

            <div style="margin-top: var(--spacing-xl); opacity: 0.9;">
                <p><i class="fas fa-clock"></i> Response within 2 business hours</p>
            </div>
        </section>
    </div>
    
    <script>
    document.getElementById('bulkOrderForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const form = e.target;
        const submitBtn = document.getElementById('submitBtn');
        const successMsg = document.getElementById('successMessage');
        const errorMsg = document.getElementById('errorMessage');
        
        // Disable submit button
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Submitting...';
        
        // Hide previous messages
        successMsg.style.display = 'none';
        errorMsg.style.display = 'none';
        
        // Get form data
        const formData = new FormData(form);
        
        // Submit form via AJAX
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message
                successMsg.style.display = 'block';
                successMsg.textContent = data.message;
                
                // Reset form
                form.reset();
                
                // Scroll to success message
                successMsg.scrollIntoView({ behavior: 'smooth', block: 'center' });
            } else {
                // Show error message
                errorMsg.style.display = 'block';
                if (data.errors) {
                    const errorList = Object.values(data.errors).flat();
                    errorMsg.innerHTML = '<strong>Please fix the following errors:</strong><ul>' + 
                        errorList.map(err => '<li>' + err + '</li>').join('') + '</ul>';
                } else {
                    errorMsg.textContent = data.message || 'An error occurred. Please try again.';
                }
                errorMsg.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        })
        .catch(error => {
            // Show error message
            errorMsg.style.display = 'block';
            errorMsg.textContent = 'An error occurred while submitting your request. Please try again.';
            errorMsg.scrollIntoView({ behavior: 'smooth', block: 'center' });
        })
        .finally(() => {
            // Re-enable submit button
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i> Submit Quote Request';
        });
    });
    </script>
@endsection