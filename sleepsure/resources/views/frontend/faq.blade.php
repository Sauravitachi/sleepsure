@extends('layouts.app')

@section('title', 'Premium Mattress & Sleep Solutions')

@section('content')

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<div class="faq-container">
    <div class="faq-header">
        <h1 class="page-title">Frequently Asked Questions</h1>
        <p class="page-subtitle">
            Find answers to common questions about our mattresses, delivery, warranty, and more
        </p>
    </div>

    <!-- FAQ Categories -->
    <div class="faq-categories">
        <button class="category-btn active" data-category="all">All Questions</button>
        @foreach($faqCategories as $cat)
            <button class="category-btn" data-category="cat{{ $cat->id }}">
                {{ $cat?->title }}
            </button>
        @endforeach
    </div>

    <!-- FAQ Accordion -->
    <div class="accordion" id="faqAccordion">
        @php $faqIndex = 1; @endphp

        @foreach($faqCategories as $cat)
            @foreach($cat->faqs as $faq)
                <div class="accordion-item" data-category="cat{{ $cat->id }}">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#faq{{ $faqIndex }}">

                            <div class="faq-icon me-2">
                                @php
                                    $baseUrl = 'https://sleepauth.kodesoft.store/';
                                    $placeholder = $baseUrl . 'my-assets/image/product.png';
                                    $iconPath = $faq->icon
                                        ? $baseUrl . ltrim($faq->icon, '/')
                                        : $placeholder;
                                @endphp
                                <img src="{{ $iconPath }}" alt="icon" width="24" height="24">
                            </div>

                            {!! $faq->que !!}
                        </button>
                    </h2>

                    <div id="faq{{ $faqIndex }}"
                         class="accordion-collapse collapse"
                         data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            {!! $faq->ans !!}
                        </div>
                    </div>
                </div>

                @php $faqIndex++; @endphp
            @endforeach
        @endforeach
    </div>

    <!-- Contact Section -->
    <div class="contact-section">
        <h3 class="contact-title">Still have questions?</h3>
        <p>Our sleep experts are here to help you find the perfect mattress</p>
        <button class="contact-btn">
            <i class="fas fa-headset"></i> Contact Support
        </button>
    </div>
</div>

@endsection


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const categoryButtons = document.querySelectorAll('.category-btn');
    const faqItems = document.querySelectorAll('.accordion-item');

    if (!categoryButtons.length || !faqItems.length) return;

    categoryButtons.forEach(btn => {
        btn.addEventListener('click', () => {

            categoryButtons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            const category = btn.dataset.category;

            faqItems.forEach(item => {
                item.style.display =
                    category === 'all' || item.dataset.category === category
                        ? 'block'
                        : 'none';
            });
        });
    });
});
</script>
@endpush
