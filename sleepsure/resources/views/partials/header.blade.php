<style>
.cart-icon {
    position: relative;
    display: inline-block;
}
.cart-count-badge {
    position: absolute;
    top: -6px;
    right: -6px;
    background: #e53935;
    color: #fff;
    border-radius: 50%;
    padding: 2px 7px;
    font-size: 12px;
    min-width: 20px;
    text-align: center;
    display: none;
    z-index: 1;
    line-height: 1.2;
    font-weight: 600;
    box-shadow: 0 1px 4px rgba(0,0,0,0.12);
    pointer-events: none;
}
</style>
<header class="main-header">
    <div class="header-container">
        <button class="menu-toggle-btn" id="menuToggle" aria-label="Menu">
            <span class="material-icons">menu</span>
        </button>

        <div class="brand-logo">
            <a href="{{ route('home') }}">
                <img src="{{ $logo_url }}" alt="SleepSure" class="home-icon">
            </a>
        </div>

        <div class="search-container">
            <span class="material-icons search-icon cursor-pointer">search</span>
            <input type="text" placeholder="Search for Mattress, Category, Tag..." class="search-input" id="globalSearchInput" autocomplete="off" readonly style="cursor:pointer;">
        </div>

        <nav class="header-links desktop-only">
            <a class="become-dealer-btn" id="openModal">Become Dealer</a>
            <a href="{{ route('stores.index') }}">Stores</a>
            <a href="{{ route('bulk-orders.index') }}">Bulk Orders</a>
        </nav>

        <div class="header-icons">
            <a href="{{ route('contact.index') }}">
                <span class="material-icons desktop-only">phone</span>
            </a>
            <a href="{{ route('wishlist.index') }}">
                <span class="material-icons desktop-only">favorite_border</span>
            </a>           
             <a href="{{ route('cart.index') }}" class="cart-icon">
                <span class="material-icons">shopping_cart</span>
                <span id="cartCountBadge" class="cart-count-badge"></span>
            </a>                    
            <div class="account-icon">
                @auth
                    <div class="dropdown">
                        <a href="#" class="dropdown-toggle" id="accountDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="material-icons">account_circle</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="accountDropdown">
                            <li><a class="dropdown-item" href="{{ route('account.index') }}">My Account</a></li>
                            <li><a class="dropdown-item" href="{{ route('orders.index') }}">My Orders</a></li>
                            <li><a class="dropdown-item" href="#">Wishlist</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('login') }}">
                        <span class="material-icons">account_circle</span>
                    </a>
                @endauth
            </div>
        </div>
    </div>
</header>

{{--  Dynamic Category Navigation --}}
<nav class="category-nav desktop-only">
    <div class="container nav-container">
        <ul class="nav-list-items">

            <li class="nav-item"><a href="{{ route('home') }}" class="text-white">Home</a></li>

            @foreach($categories->take(5) as $main)
                <li class="nav-item nav-item-mat">
                    <a href="{{ route('products.categories', $main->category_name) }}" class="nav-link-mat">{{ $main->category_name }}</a>
                    @if($main->subcategories->count() > 0)
                        <div class="mat-dropdown-container mt-2">
                            @foreach($main->subcategories as $sub)
                                <div class="dropdown-col">
                                    {{-- Subcategory Title --}}
                                    <div class="col-title text-muted fw-semibold small-xs mb-0">
                                        <a href="{{ route('products.categories', $sub->category_name) }}" style="color:inherit;text-decoration:none;">
                                            {{ Str::title($sub->category_name) }}
                                        </a>
                                    </div>
                                    {{-- Third-level Models --}}
                                    @if($sub->models->count() > 0)
                                        <ul class="col-links">
                                            @foreach($sub->models as $model)
                                                <li>
                                                    <a href="{{ route('products.categories', $model->category_name) }}">{{ Str::title($model->category_name) }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </li>
            @endforeach

        </ul>
    </div>
</nav>


<!-- Mobile Sidebar -->
<aside class="mobile-sidebar" id="sidebar">
    <div class="sidebar-content">
        <div class="sidebar-account-header">
            <span class="material-icons">account_circle</span>
            @auth
                <div class="account-info">
                    <div>{{ Auth::user()->customer_name }}</div>
                    <strong>{{ Auth::user()->customer_email }}</strong>
                </div>
            @else
                <a href="{{ route('login') }}">
                    <div class="account-info">
                        My Account
                        <strong>Log in</strong>
                    </div>
                </a>
            @endauth
            <div class="pincode-entry">
                <span class="material-icons location-icon">location_on</span>
                Enter <strong>Pincode</strong> <span class="material-icons edit-icon">edit</span>
            </div>
        </div>

        <div class="sidebar-utility-buttons">
            <a href="{{ route('cart.index') }}" class="utility-btn">
                <span class="material-icons">shopping_cart</span> My Cart
            </a>
            <a href="{{ route('orders.index') }}" class="utility-btn">
                <span class="material-icons">assignment</span> My Orders
            </a>
        </div>

        <nav class="sidebar-menu-links">
            <a href="{{ route('categories.index') }}"><span class="material-icons">apps</span> <strong>Browse Categories</strong></a>
            <a href="{{ route('offer.index') }}"><span class="material-icons">local_offer</span> <strong>Offers</strong></a>
            <a href="{{ route('blogs.index') }}"><span class="material-icons">article</span> <strong>Blog</strong></a>
            <a href="{{ route('contact.index') }}"><span class="material-icons">call</span> <strong>Contact Us</strong></a>
            <a href="{{ route('faq.index') }}"><span class="material-icons">help_outline</span> <strong>FAQ</strong></a>
            <a href="#"><span class="material-icons">map</span> <strong>Sitemap</strong></a>
            {{-- @auth
                <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                    @csrf
                    <button type="submit" style="width: 100%; text-align: left; background: none; border: none; padding: 12px 16px; cursor: pointer; display: flex; align-items: center; gap: 12px; color: inherit;">
                        <span class="material-icons">logout</span> <strong>Logout</strong>
                    </button>
                </form>
            @endauth --}}
        </nav>
    </div>
</aside>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- Dealer Modal -->
<div class="modal-backdrop" id="modalBackdrop">
    <div class="dealer-modal">
        <div class="modal-header">
            <h2>Become a SleepSure Dealer</h2>
            <button class="close-btn" id="closeModal">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <form id="dealerForm">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fullName">Full Name</label>
                            <input type="text" id="fullName" placeholder="Enter your full name" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" id="city" placeholder="Enter your city" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" placeholder="Enter your email address" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="mobile">Mobile Number</label>
                            <input type="tel" id="mobile" placeholder="Enter your mobile number" required>
                        </div>
                    </div>
                </div>

                <div class="user-type-group">
                    <label class="user-type-label">I am a</label>
                    <div class="radio-options">
                        <label class="radio-option">
                            <input type="radio" name="userType" value="landlord" required>
                            Landlord
                        </label>
                        <label class="radio-option">
                            <input type="radio" name="userType" value="dealer" required>
                            Dealer
                        </label>
                    </div>
                </div>

                <div class="checkbox-group">
                    <input type="checkbox" id="notifications">
                    <label for="notifications">Send me notifications</label>
                </div>

                <button type="submit" class="submit-btn">Submit</button>
            </form>
        </div>
    </div>
</div>

<script>
            // Search Modal Logic
            document.addEventListener('DOMContentLoaded', function () {
                const searchInput = document.getElementById('globalSearchInput');
                const searchContainer = document.querySelector('.search-container');
                const searchIcon = document.querySelector('.search-icon');
                const searchModal = document.getElementById('searchModal');
                const closeModalBtn = document.getElementById('closeSearchModal');
                const modalInput = document.getElementById('modalSearchInput');
                const modalContent = document.getElementById('searchModalContent');

                const openSearchModal = () => {
                    if (!searchModal) return;
                    searchModal.style.display = 'flex';
                    setTimeout(() => {
                        if (modalInput) modalInput.focus();
                    }, 100);
                };

                [searchInput, searchContainer, searchIcon].forEach(el => {
                    if (el) {
                        el.addEventListener('focus', openSearchModal);
                        el.addEventListener('click', openSearchModal);
                    }
                });

                if (closeModalBtn) {
                    closeModalBtn.onclick = function () {
                        searchModal.style.display = 'none';
                        if (modalInput) modalInput.value = '';
                        if (modalContent) modalContent.innerHTML = '';
                    };
                }
                if (searchModal) {
                    searchModal.onclick = function (e) {
                        if (e.target === this) {
                            searchModal.style.display = 'none';
                            if (modalInput) modalInput.value = '';
                            if (modalContent) modalContent.innerHTML = '';
                        }
                    };
                }
                document.addEventListener('keydown', function (e) {
                    if (e.key === 'Escape') {
                        if (searchModal) searchModal.style.display = 'none';
                        if (modalInput) modalInput.value = '';
                        if (modalContent) modalContent.innerHTML = '';
                    }
                });
                // Live search
                if (modalInput) {
                    let debounceTimeout;
                    modalInput.addEventListener('input', function () {
                        const q = this.value.trim();
                        clearTimeout(debounceTimeout);
                        if (q.length < 2) {
                            modalContent.innerHTML = `<div style='color:#888;'>Type to search products or categories...</div>`;
                            return;
                        }
                        debounceTimeout = setTimeout(() => {
                            fetch(`{{ url('/search/products') }}?q=${encodeURIComponent(q)}`)
                                .then(res => res.json())
                                .then(data => {
                                    if (data.success && data.results.length > 0) {
                                        modalContent.innerHTML = data.results.map(item => {
                                            if (item.search_type === 'category') {
                                                return `
                                                    <a href="${item.link}" class="search-result-item" style="background:#f7faff;">
                                                        <img src="${item.image_url || ''}" alt="" />
                                                        <div>
                                                            <div style="font-weight:600;">${item.category_name}</div>
                                                            <div style="font-size:12px;color:#1b4e9b;">Category</div>
                                                        </div>
                                                    </a>
                                                `;
                                            } else {
                                                return `
                                                    <a href="${item.link}" class="search-result-item">
                                                        <img src="${item.image_url || ''}" alt="" />
                                                        <div>
                                                            <div style="font-weight:600;">${item.product_name}</div>
                                                            <div style="font-size:12px;color:#888;">${item.categoryDetails?.category_name || ''}</div>
                                                        </div>
                                                    </a>
                                                `;
                                            }
                                        }).join('');
                                    } else {
                                        modalContent.innerHTML = '<div style="padding:12px;color:#888;">No results found</div>';
                                    }
                                })
                                .catch(() => {
                                    modalContent.innerHTML = '<div style="padding:12px;color:#888;">Error searching</div>';
                                });
                        }, 300);
                    });
                }
            });
        // Global Product Search (AJAX)
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('globalSearchInput');
            const resultsBox = document.getElementById('globalSearchResults');
            let debounceTimeout;
            if (searchInput && resultsBox) {
                searchInput.addEventListener('input', function () {
                    const q = this.value.trim();
                    clearTimeout(debounceTimeout);
                    if (q.length < 2) {
                        resultsBox.style.display = 'none';
                        resultsBox.innerHTML = '';
                        return;
                    }
                    debounceTimeout = setTimeout(() => {
                        fetch(`{{ url('/search/products') }}?q=${encodeURIComponent(q)}`)
                            .then(res => res.json())
                            .then(data => {
                                if (data.success && data.results.length > 0) {
                                    resultsBox.innerHTML = data.results.map(item => `
                                        <a href="/product/${item.product_id}" class="search-result-item" style="display:flex;align-items:center;padding:8px 12px;text-decoration:none;color:#222;border-bottom:1px solid #eee;">
                                            <img src="${item.image_url || ''}" alt="" style="width:36px;height:36px;object-fit:cover;margin-right:10px;border-radius:4px;">
                                            <div>
                                                <div style="font-weight:600;">${item.product_name}</div>
                                                <div style="font-size:12px;color:#888;">${item.categoryDetails?.category_name || ''}</div>
                                            </div>
                                        </a>
                                    `).join('');
                                    resultsBox.style.display = 'block';
                                } else {
                                    resultsBox.innerHTML = '<div style="padding:12px;color:#888;">No results found</div>';
                                    resultsBox.style.display = 'block';
                                }
                            })
                            .catch(() => {
                                resultsBox.innerHTML = '<div style="padding:12px;color:#888;">Error searching</div>';
                                resultsBox.style.display = 'block';
                            });
                    }, 300);
                });
                // Hide results on blur
                searchInput.addEventListener('blur', function () {
                    setTimeout(() => { resultsBox.style.display = 'none'; }, 200);
                });
                // Show results on focus if any
                searchInput.addEventListener('focus', function () {
                    if (resultsBox.innerHTML.trim()) resultsBox.style.display = 'block';
                });
            }
        });
    document.addEventListener('DOMContentLoaded', function () {
        const modalBackdrop = document.getElementById('modalBackdrop');
        const openModalBtn = document.getElementById('openModal');
        const closeModalBtn = document.getElementById('closeModal');
        const dealerForm = document.getElementById('dealerForm');

        // Open modal
        openModalBtn.addEventListener('click', function () {
            modalBackdrop.classList.add('active');
            document.body.style.overflow = 'hidden';
        });

        // Close modal
        closeModalBtn.addEventListener('click', function () {
            modalBackdrop.classList.remove('active');
            document.body.style.overflow = 'auto';
        });

        // Close modal when clicking outside
        modalBackdrop.addEventListener('click', function (e) {
            if (e.target === modalBackdrop) {
                modalBackdrop.classList.remove('active');
                document.body.style.overflow = 'auto';
            }
        });

        // Form submission
        dealerForm.addEventListener('submit', function (e) {
            e.preventDefault();

            // Get form data
            const formData = {
                fullName: document.getElementById('fullName').value,
                email: document.getElementById('email').value,
                mobile: document.getElementById('mobile').value,
                city: document.getElementById('city').value,
                userType: document.querySelector('input[name="userType"]:checked').value,
                notifications: document.getElementById('notifications').checked
            };

            // Show loading state
            const submitBtn = dealerForm.querySelector('.submit-btn');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Submitting...';
            submitBtn.disabled = true;

            // Send AJAX request to Laravel backend
            fetch('{{ route("dealer.register") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(formData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    dealerForm.reset();
                    modalBackdrop.classList.remove('active');
                    document.body.style.overflow = 'auto';
                } else {
                    // Handle validation errors
                    let errorMessage = 'Please correct the following errors:\n';
                    if (data.errors) {
                        Object.keys(data.errors).forEach(key => {
                            errorMessage += '\n- ' + data.errors[key][0];
                        });
                    } else {
                        errorMessage = data.message || 'An error occurred. Please try again.';
                    }
                    alert(errorMessage);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while submitting the form. Please try again.');
            })
            .finally(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
        });

        // Close with Escape key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && modalBackdrop.classList.contains('active')) {
                modalBackdrop.classList.remove('active');
                document.body.style.overflow = 'auto';
            }
        });
    });
  
    document.addEventListener('DOMContentLoaded', function () {
        function updateCartCount() {
            fetch("{{ route('cart.products.count') }}")
                .then(res => res.json())
                .then(data => {
                    const badge = document.getElementById('cartCountBadge');
                    if (badge) {
                        if (data.count > 0) {
                            badge.textContent = data.count;
                            badge.style.display = 'inline-block';
                        } else {
                            badge.style.display = 'none';
                        }
                    }
                });
        }
        updateCartCount();
        // Optionally, update on interval or after cart actions
        window.updateCartCount = updateCartCount;
    });
          
</script>