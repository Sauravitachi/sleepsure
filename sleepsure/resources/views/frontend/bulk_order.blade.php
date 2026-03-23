@extends('layouts.app')

@section('title', 'Premium Mattress & Sleep Solutions')

@section('content')

<div class="bulk-container">
        <section class="bulk-form-section">
            <h2 class="section-title">Request a Bulk Quote</h2>
            
            <div id="successMessage" class="alert alert-success" style="display:none; margin-bottom: 20px;">
                Your bulk order request has been submitted successfully! Our team will contact you within 2 business days.
            </div>
            
            <div id="errorMessage" class="alert alert-danger" style="display:none; margin-bottom: 20px;"></div>
            
            <form id="bulkOrderForm" method="POST" action="{{ route('bulk-order.store') }}" novalidate>
                @csrf
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label" for="company">Company Name *</label>
                        <input type="text" class="form-control" id="company" name="company" required>
                        <div class="invalid-feedback js-error" id="company-error" style="display:none;"></div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="contact">Contact Person *</label>
                        <input type="text" class="form-control" id="contact" name="contact" required>
                        <div class="invalid-feedback js-error" id="contact-error" style="display:none;"></div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="email">Email Address *</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                        <div class="invalid-feedback js-error" id="email-error" style="display:none;"></div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="phone">Phone Number *</label>
                        <input type="tel" class="form-control" id="phone" name="phone" inputmode="tel" pattern="\+?[0-9]{7,15}" title="Use 7-15 digits, digits only, optional leading +" required>
                        <div class="invalid-feedback js-error" id="phone-error" style="display:none;"></div>
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
                        <div class="invalid-feedback js-error" id="client_type-error" style="display:none;"></div>
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
                        <div class="invalid-feedback js-error" id="quantity-error" style="display:none;"></div>
                    </div>

                    <div class="form-group form-full">
                        <label class="form-label" for="message">Additional Requirements</label>
                        <textarea class="form-control" id="message" name="message"
                            placeholder="Tell us about your specific needs, delivery timeline, custom requirements..."></textarea>
                        <div class="invalid-feedback js-error" id="message-error" style="display:none;"></div>
                    </div>
                </div>

                <button type="submit" class="btn-primary" id="submitBtn" style="width: 100%; margin-top: var(--spacing-lg);">
                    <i class="fas fa-paper-plane"></i> Submit Quote Request
                </button>
            </form>
        </section>

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
    const phoneInput = document.getElementById('phone');
    phoneInput.addEventListener('input', () => {
        const cleaned = phoneInput.value.replace(/[^0-9+]/g, '').slice(0, 15);
        phoneInput.value = cleaned;
    });

    const setAlert = (element, type, content) => {
        element.classList.remove('alert-success', 'alert-danger');
        element.classList.add(type === 'success' ? 'alert-success' : 'alert-danger');
        element.style.display = 'block';
        element.innerHTML = content;
    };

    const form = document.getElementById('bulkOrderForm');
    form.addEventListener('invalid', (e) => {
        e.preventDefault();
    }, true);

    const clearFieldErrors = () => {
        form.querySelectorAll('.js-error').forEach((errorEl) => {
            errorEl.textContent = '';
            errorEl.style.display = 'none';
        });

        form.querySelectorAll('.is-invalid').forEach((fieldEl) => {
            fieldEl.classList.remove('is-invalid');
        });
    };

    const setFieldError = (fieldName, message) => {
        const fieldEl = form.querySelector(`[name="${fieldName}"]`);
        const errorEl = document.getElementById(`${fieldName}-error`);

        if (fieldEl) {
            fieldEl.classList.add('is-invalid');
        }

        if (errorEl) {
            errorEl.textContent = message;
            errorEl.style.display = 'block';
        }
    };

    form.querySelectorAll('input, select, textarea').forEach((fieldEl) => {
        const eventName = fieldEl.tagName === 'SELECT' ? 'change' : 'input';
        fieldEl.addEventListener(eventName, () => {
            if (fieldEl.classList.contains('is-invalid')) {
                fieldEl.classList.remove('is-invalid');
            }

            const errorEl = document.getElementById(`${fieldEl.name}-error`);
            if (errorEl) {
                errorEl.textContent = '';
                errorEl.style.display = 'none';
            }
        });
    });

    form.addEventListener('submit', function(e) {
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
        clearFieldErrors();
        
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
        .then(async response => {
            const data = await response.json();
            return { ok: response.ok, data };
        })
        .then(data => {
            if (data.ok && data.data.success) {
                // Show success message
                setAlert(successMsg, 'success', data.data.message);
                
                // Reset form
                form.reset();
                
                // Scroll to success message
                successMsg.scrollIntoView({ behavior: 'smooth', block: 'center' });
            } else {
                // Show error message
                if (data.data.errors) {
                    Object.entries(data.data.errors).forEach(([fieldName, messages]) => {
                        if (Array.isArray(messages) && messages.length) {
                            setFieldError(fieldName, messages[0]);
                        }
                    });

                    setAlert(errorMsg, 'error', 'Please fix the highlighted fields and try again.');
                } else {
                    setAlert(errorMsg, 'error', data.data.message || 'An error occurred. Please try again.');
                }
                errorMsg.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        })
        .catch(error => {
            // Show error message
            setAlert(errorMsg, 'error', 'An error occurred while submitting your request. Please try again.');
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