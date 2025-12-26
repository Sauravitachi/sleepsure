/**
 * SleepSure Website JavaScript
 * Systematically organized into modules for maintainability and performance.
 */

// ===========================================
// UTILITY FUNCTIONS (For Reusability)
// ===========================================

/**
 * Debounce function to limit function execution (e.g., on window resize or input)
 */
const debounce = (func, wait) => {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func.apply(this, args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
};

/**
 * Throttle function to limit function execution rate (e.g., on scroll or mouse move)
 */
const throttle = (func, limit) => {
    let inThrottle;
    return function(...args) {
        if (!inThrottle) {
            func.apply(this, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    };
};


// ===========================================
// MODULE 1: MOBILE MENU
// ===========================================
const MobileMenu = (() => {
    // Configuration
    const config = {
        selectors: {
            menuToggle: '#menuToggle',
            sidebar: '#sidebar',
            sidebarOverlay: '#sidebarOverlay'
        },
        bodyOverflow: true // Enable/disable body scroll when menu is open
    };

    // State
    const state = {
        isActive: false
    };

    // DOM Elements
    const elements = {};

    /**
     * Cache DOM elements for better performance
     */
    const cacheElements = () => {
        elements.menuToggle = document.querySelector(config.selectors.menuToggle);
        elements.sidebar = document.querySelector(config.selectors.sidebar);
        elements.sidebarOverlay = document.querySelector(config.selectors.sidebarOverlay);
    };

    /**
     * Toggle sidebar open/close state
     */
    const toggleSidebar = () => {
        state.isActive = !state.isActive;
        updateSidebarState();
    };

    /**
     * Close sidebar
     */
    const closeSidebar = () => {
        state.isActive = false;
        updateSidebarState();
    };

    /**
     * Handle escape key press
     */
    const handleEscapeKey = (event) => {
        if (event.key === 'Escape' && state.isActive) {
            closeSidebar();
        }
    };

    /**
     * Update DOM based on sidebar state
     */
    const updateSidebarState = () => {
        const { sidebar, sidebarOverlay } = elements;
        
        if (sidebar) {
            sidebar.classList.toggle('active', state.isActive);
        }
        
        if (sidebarOverlay) {
            sidebarOverlay.classList.toggle('active', state.isActive);
        }

        // Handle body scroll
        if (config.bodyOverflow) {
            document.body.style.overflow = state.isActive ? 'hidden' : 'auto';
        }
    };
    
    /**
     * Bind event listeners
     */
    const bindEvents = () => {
        if (elements.menuToggle) {
            elements.menuToggle.addEventListener('click', toggleSidebar);
        }

        if (elements.sidebarOverlay) {
            elements.sidebarOverlay.addEventListener('click', closeSidebar);
        }

        // Close on escape key
        document.addEventListener('keydown', handleEscapeKey);
    };

    /**
     * Initialize mobile menu functionality
     */
    const init = () => {
        cacheElements();
        bindEvents();
    };

    // Public API
    return {
        init,
        close: closeSidebar,
        isOpen: () => state.isActive
    };
})();


// ===========================================
// MODULE 2: MATTRESS QUIZ MODAL
// ===========================================
const MattressQuiz = (() => {
    // Configuration
    const config = {
        selectors: {
            openBtn: '#openMattressQuiz',
            closeBtn: '#closeMattressQuiz',
            modal: '#mattressQuizModal'
        }
    };

    // State
    const state = {
        isOpen: false
    };

    // DOM Elements
    const elements = {};

    /**
     * Cache DOM elements
     */
    const cacheElements = () => {
        elements.openBtn = document.querySelector(config.selectors.openBtn);
        elements.closeBtn = document.querySelector(config.selectors.closeBtn);
        elements.modal = document.querySelector(config.selectors.modal);
    };

    /**
     * Open the modal
     */
    const openModal = () => {
        state.isOpen = true;
        updateModalState();
    };

    /**
     * Close the modal
     */
    const closeModal = () => {
        state.isOpen = false;
        updateModalState();
    };

    /**
     * Handle outside click
     */
    const handleOutsideClick = (event) => {
        if (state.isOpen && event.target === elements.modal) {
            closeModal();
        }
    };

    /**
     * Handle escape key
     */
    const handleEscapeKey = (event) => {
        if (event.key === 'Escape' && state.isOpen) {
            closeModal();
        }
    };

    /**
     * Update modal DOM state
     */
    const updateModalState = () => {
        if (elements.modal) {
            elements.modal.classList.toggle('open', state.isOpen);
        }
    };
    
    /**
     * Bind event listeners
     */
    const bindEvents = () => {
        if (elements.openBtn) {
            elements.openBtn.addEventListener('click', openModal);
        }

        if (elements.closeBtn) {
            elements.closeBtn.addEventListener('click', closeModal);
        }

        // Close on outside click
        document.addEventListener('click', handleOutsideClick);

        // Close on escape key
        document.addEventListener('keydown', handleEscapeKey);
    };

    /**
     * Initialize mattress quiz modal
     */
    const init = () => {
        cacheElements();
        bindEvents();
    };

    // Public API
    return {
        init,
        open: openModal,
        close: closeModal,
        isOpen: () => state.isOpen
    };
})();


// ===========================================
// MODULE 3: COUNTDOWN TIMER
// ===========================================
const CountdownTimer = (() => {
    // Configuration
    const config = {
        daysElementId: 'days',
        hoursElementId: 'hours',
        minutesElementId: 'minutes',
        secondsElementId: 'seconds',
        durationInDays: 90, // 90 days countdown
        updateInterval: 1000 // 1 second
    };

    // State
    const state = {
        countdownDate: null,
        intervalId: null,
        isRunning: false
    };

    // DOM Elements
    const elements = {};

    /**
     * Cache DOM elements
     */
    const cacheElements = () => {
        elements.days = document.getElementById(config.daysElementId);
        elements.hours = document.getElementById(config.hoursElementId);
        elements.minutes = document.getElementById(config.minutesElementId);
        elements.seconds = document.getElementById(config.secondsElementId);
    };

    /**
     * Setup countdown date (sets a future date based on durationInDays)
     */
    const setupCountdown = () => {
        state.countdownDate = new Date();
        state.countdownDate.setDate(state.countdownDate.getDate() + config.durationInDays);
    };

    /**
     * Update countdown display
     */
    const updateCountdown = () => {
        const now = new Date().getTime();
        const distance = state.countdownDate - now;

        if (distance < 0) {
            handleCountdownEnd();
            return;
        }

        const time = calculateTimeUnits(distance);
        updateDisplay(time);
    };

    /**
     * Calculate time units from milliseconds
     */
    const calculateTimeUnits = (distance) => {
        return {
            days: Math.floor(distance / (1000 * 60 * 60 * 24)),
            hours: Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)),
            minutes: Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60)),
            seconds: Math.floor((distance % (1000 * 60)) / 1000)
        };
    };

    /**
     * Update DOM display with time values
     */
    const updateDisplay = (time) => {
        const formatTime = (value) => String(value).padStart(2, '0');

        if (elements.days) elements.days.textContent = formatTime(time.days);
        if (elements.hours) elements.hours.textContent = formatTime(time.hours);
        if (elements.minutes) elements.minutes.textContent = formatTime(time.minutes);
        if (elements.seconds) elements.seconds.textContent = formatTime(time.seconds);
    };

    /**
     * Handle countdown completion
     */
    const handleCountdownEnd = () => {
        stopCountdown();
        resetDisplay();
        console.log('Countdown finished!');
    };

    /**
     * Reset display to zeros
     */
    const resetDisplay = () => {
        if (elements.days) elements.days.textContent = '00';
        if (elements.hours) elements.hours.textContent = '00';
        if (elements.minutes) elements.minutes.textContent = '00';
        if (elements.seconds) elements.seconds.textContent = '00';
    };
    
    /**
     * Start the countdown
     */
    const startCountdown = () => {
        if (state.isRunning) return;

        state.isRunning = true;
        updateCountdown(); // Initial call to avoid delay
        state.intervalId = setInterval(updateCountdown, config.updateInterval);
    };

    /**
     * Stop the countdown
     */
    const stopCountdown = () => {
        if (!state.isRunning) return;

        state.isRunning = false;
        clearInterval(state.intervalId);
    };

    /**
     * Initialize countdown timer
     */
    const init = () => {
        cacheElements();
        setupCountdown();
        startCountdown();
    };

    // Public API
    return {
        init,
        start: startCountdown,
        stop: stopCountdown,
        isRunning: () => state.isRunning
    };
})();


// ===========================================
// MODULE 4: STICKY NAVIGATION (Fixed Nav on Scroll)
// ===========================================
const StickyNav = (() => {
    let navElement;
    let navOffset = 0;

    const cacheElements = () => {
        // Find the navigation element based on the provided selector
        navElement = document.querySelector(".category-nav");
    };

    // Calculate the element's position from the top of the document
    const setOffset = () => {
        if (navElement) {
            navOffset = navElement.offsetTop;
        }
    };

    // Logic to fix the nav bar when scrolling past its initial position
    const handleScroll = () => {
        if (!navElement) return;
        // Check if the current scroll position is past the nav's original offset
        if (window.pageYOffset >= navOffset) {
            navElement.classList.add("fixed-nav");
        } else {
            navElement.classList.remove("fixed-nav");
        }
    };
    
    const init = () => {
        cacheElements();
        if (navElement) {
            setOffset(); // Set initial offset
            // Use throttle for performance during scroll
            window.addEventListener("scroll", throttle(handleScroll, 10));
            // Recalculate offset when window is resized
            window.addEventListener("resize", debounce(setOffset, 200)); 
        }
    };

    return { init };
})();


// ===========================================
// MODULE 5: CARD INTERACTION (Buy/Remove Button Logic)
// ===========================================
const CardInteraction = (() => {
    /**
     * Binds click handlers to the '.buy' and '.remove' buttons.
     */
    const bindEvents = () => {
        // Buy button logic (adds 'clicked' class to closest '.bottom' element)
        document.querySelectorAll('.buy').forEach(button => {
            button.addEventListener('click', function() {
                const bottomElement = this.closest('.bottom');
                if (bottomElement) {
                    bottomElement.classList.add('clicked');
                }
            });
        });

        // Remove button logic (removes 'clicked' class from closest '.bottom' element)
        document.querySelectorAll('.remove').forEach(button => {
            button.addEventListener('click', function() {
                const bottomElement = this.closest('.bottom');
                if (bottomElement) {
                    bottomElement.classList.remove('clicked');
                }
            });
        });
    };

    const init = () => {
        bindEvents();
    };

    return { init };
})();


// ===========================================
// MODULE 6: CARD FILTERING (Offers/Promotions)
// ===========================================
const CardFilter = (() => {
    let filterButtons;
    let offerCards;
    
    const cacheElements = () => {
        filterButtons = document.querySelectorAll('.filter-buttons button');
        offerCards = document.querySelectorAll('.offer-card');
    };

    /**
     * Hides all cards and displays only those matching the provided type.
     */
    const showCards = (type) => {
        offerCards.forEach(card => {
            // Check card's data-type attribute
            card.style.display = card.dataset.type === type ? 'block' : 'none';
        });
    };
    
    /**
     * Binds click events to filter buttons.
     */
    const bindEvents = () => {
        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                // 1. Remove active class from all buttons
                filterButtons.forEach(btn => btn.classList.remove('active'));
                // 2. Add active to clicked button
                this.classList.add('active');
                // 3. Show cards of selected type
                showCards(this.dataset.type);
            });
        });
    };

    const init = () => {
        cacheElements();
        bindEvents();
        
        // Default behavior: Show initial cards (assuming 'cards' is the default category)
        if (filterButtons.length > 0) {
            const defaultType = filterButtons[0].dataset.type || 'cards';
            filterButtons[0].classList.add('active'); // Set first button active
            showCards(defaultType);
        } else {
             // Fallback for initialization
             showCards('cards');
        }
    };

    return { init };
})();


// ===========================================
// MODULE 7: TESTIMONIALS (Placeholder)
// ===========================================
// NOTE: This module is included as it was referenced in the original DOMContentLoaded,
// but it is currently a placeholder as its logic was not provided.
const Testimonials = (() => {
    const init = () => {
        // Logic for Testimonials/Carousel initialization goes here
        // Example: Calculate slide width, set initial position, bind swipe events, etc.
    };
    
    // Add an event listener to re-initialize on resize, using debounce for performance
    window.addEventListener('resize', debounce(() => {
        // Re-run initialization logic on resize
        Testimonials.init();
    }, 250));

    return { init };
})();


// ===========================================
// PRIMARY INITIALIZATION
// ===========================================

document.addEventListener('DOMContentLoaded', () => {
    // Initialize all modules here
    MobileMenu.init();
    MattressQuiz.init();
    CountdownTimer.init();
    Testimonials.init();
    
    // New modules integrated:
    StickyNav.init();
    CardInteraction.init();
    CardFilter.init();

    console.log('All SleepSure JavaScript modules initialized.');
});



