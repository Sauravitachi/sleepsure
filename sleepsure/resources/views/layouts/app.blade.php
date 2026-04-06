<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SleepSure - @yield('title', 'Premium Mattress & Sleep Solutions')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Styles -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="icon" href="{{ $favicon_url }}" type="image/x-icon">

    @stack('styles')
</head>
<body>
    <!-- Alert Bar -->
    {{-- <div class="top-alert-bar">
        Use code SLEEP (till 1st Oct) to get up to 30% off + Additional 11% off with bank offers.
    </div> --}}
    <div class="top-alert-bar">
        @php
            use App\Models\Coupon;
            $popularCoupon = Coupon::where('status', 1)
                ->where('is_popular', '1')
                ->first();
            
            if(!$popularCoupon) {
                $popularCoupon = Coupon::where('status', 1)->first();
            }
        @endphp
        
        @if($popularCoupon)
            @php
                $discountText = '';
                if($popularCoupon->discount_type == 1) {
                    $discountText = '৳' . number_format($popularCoupon->discount_amount, 0);
                } else {
                    $discountText = $popularCoupon->discount_percentage . '%';
                }
                
                $endDateText = '';
                if($popularCoupon->end_date && $popularCoupon->end_date != 'NULL') {
                    $endDate = \Carbon\Carbon::parse($popularCoupon->end_date);
                    if($endDate->isFuture()) {
                        $endDateText = ' (till ' . $endDate->format('jS M') . ')';
                    }
                }
            @endphp
            
            Use code <strong>{{ $popularCoupon->coupon_discount_code }}</strong> 
            to get <strong>{{ $discountText }} off</strong>
            @if($popularCoupon->coupon_msg)
                {{ $popularCoupon->coupon_msg }}
            @endif
            {{ $endDateText }}
        @else
            Use code SLEEP (till 1st Oct) to get up to 30% off + Additional 11% off with bank offers.
        @endif
    </div>

    <!-- Header -->
    @include('partials.header')

    <!-- Main Content -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('partials.footer')

    <!-- Chat Button -->
    <div class="chat-button">
        <span class="material-icons">chat</span>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    
    @stack('scripts')

    @php
        // Error should always force red background; fall back to alert/success otherwise.
        $toastMessage = session('error') ?? session('alert') ?? session('success');
        $toastVariant = session('error') ? 'danger' : (session('alert') ? 'warning' : (session('success') ? 'success' : 'primary'));
    @endphp

    @if($toastMessage)
        <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1080;">
            <div id="sessionToast" class="toast align-items-center text-bg-{{ $toastVariant }} border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="4000">
                <div class="d-flex">
                    <div class="toast-body">{{ $toastMessage }}</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>
        <script>
            (() => {
                const toastEl = document.getElementById('sessionToast');
                if (toastEl && window.bootstrap?.Toast) {
                    new bootstrap.Toast(toastEl).show();
                }
            })();
        </script>
    @endif

    @include('partials.search_modal')
        <script>
    // Open modal from header search
    document.getElementById('globalSearchInput')?.addEventListener('focus', function() {
        document.getElementById('searchModal').style.display = 'flex';
        setTimeout(() => document.getElementById('modalSearchInput').focus(), 100);
    });

    // Also open on click (for mobile/readonly)
    document.getElementById('globalSearchInput')?.addEventListener('click', function() {
        document.getElementById('searchModal').style.display = 'flex';
        setTimeout(() => document.getElementById('modalSearchInput').focus(), 100);
    });

    // Close modal
    document.getElementById('closeSearchModal')?.addEventListener('click', function() {
        document.getElementById('searchModal').style.display = 'none';
        document.getElementById('modalSearchInput').value = '';
        document.getElementById('searchModalContent').innerHTML = '';
    });
    document.getElementById('searchModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            this.style.display = 'none';
            document.getElementById('modalSearchInput').value = '';
            document.getElementById('searchModalContent').innerHTML = '';
        }
    });
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.getElementById('searchModal').style.display = 'none';
            document.getElementById('modalSearchInput').value = '';
            document.getElementById('searchModalContent').innerHTML = '';
        }
    });

    // Live search
    document.getElementById('modalSearchInput')?.addEventListener('input', function() {
        const q = this.value.trim();
        const content = document.getElementById('searchModalContent');
        if (q.length < 2) {
            // Show trending/popular here
            content.innerHTML = `<div>Trending Searches: ...</div>`;
            return;
        }
        fetch(`{{ url('/search/products') }}?q=${encodeURIComponent(q)}`)
            .then(res => res.json())
            .then(data => {
                if (data.success && data.results.length > 0) {
                    content.innerHTML = data.results.map(item => `
                        <a href="/product/${item.product_id}" class="search-result-item">
                            <img src="${item.image_url || ''}" alt="" style="width:36px;height:36px;object-fit:cover;margin-right:10px;border-radius:4px;">                            
                            <div>

                                <div style="font-weight:600;">${item.product_name}</div>
                                <div style="font-size:12px;color:#888;">${item.categoryDetails?.category_name || ''}</div>
                            </div>
                        </a>
                    `).join('');
                } else {
                    content.innerHTML = '<div style="padding:12px;color:#888;">No results found</div>';
                }
                console.log(data);
            });
    });
    document.querySelectorAll('.slider-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        const slider = document.getElementById(btn.dataset.target);
        if (!slider) return;
        const scrollAmount = slider.offsetWidth * 0.8;
        slider.scrollBy({
            left: btn.classList.contains('left') ? -scrollAmount : scrollAmount,
            behavior: 'smooth'
        });
    });
});
    </script>
</body>
</html>