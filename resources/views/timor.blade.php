{{--
  Template Name:Guide Template
--}}

@extends('layouts.app')

@section('content')
<!-- Enhanced Hero Section - Simplified -->
<div class="hero bg-cover bg-center relative" style="background-image: url('http://fisc.freebalance.com/wp-content/uploads/2025/03/Timor-Leste.jpg')">
    <div class="absolute inset-0 bg-black bg-opacity-60"></div>
    <div class="relative z-10 text-center text-white max-w-4xl mx-auto px-4 lg:py-10 py-12">
        <div class="inline-block py-1 px-3 bg-black bg-opacity-20 text-white text-sm rounded-full mb-3">FISC 2025</div>
        <h1 class="text-4xl md:text-6xl mb-4">Timor-Leste Delegate Guide</h1>
        <p class="text-xl mb-10">April 7-10, 2025 | Palm Springs Hotel Dili</p>

        <!-- Single Primary Call-to-Action -->
        <a href="#about-timor" class="btn btn-primary text-white text-white">
            Get Started
            <svg class="w-3 h-3 text-white transition-transform duration-300 group-hover:translate-x-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 8 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 13 5.7-5.326a.909.909 0 0 0 0-1.348L1 1"></path>
            </svg>
        </a>
    </div>
</div>

<!-- Clean Navigation Bar (Fixed) with Animated Item Indicator -->
<div class="sticky top-0 bg-base-100 shadow-sm border-b border-base-200 z-20">
    <div class="container mx-auto mx-4 px-0">
        <div class="relative">
            <nav class="flex justify-between items-center h-14 px-4">
                <div class="relative flex space-x-6" id="nav-container">
                    <!-- Animated indicator that moves between menu items -->
                    <div id="nav-indicator" class="absolute bottom-0 left-0 h-1 bg-primary" style="width: 0; transition: all 0.3s ease;"></div>

                    <a href="#about-timor" class="text-sm font-medium text-base-content/70 hover:text-primary nav-link" data-section="about-timor">
                        About
                    </a>
                    <a href="#pre-arrival" class="text-sm font-medium text-base-content/70 hover:text-primary nav-link" data-section="pre-arrival">
                        Pre-Arrival
                    </a>
                    <a href="#essentials" class="text-sm font-medium text-base-content/70 hover:text-primary nav-link" data-section="essentials">
                        Essentials
                    </a>
                    <a href="#location" class="text-sm font-medium text-base-content/70 hover:text-primary nav-link" data-section="location">
                        Location
                    </a>
                </div>
            </nav>
        </div>
    </div>
</div>

<style>
    /* Fix for the hover border causing menu items to jump */
    .nav-link {
        height: 56px;
        /* Match the height of the navbar (h-14) */
        line-height: 56px;
        padding: 0;
        display: inline-block;
        position: relative;
        transition: color 0.3s ease;
    }

    /* Active state for text */
    .nav-link.active {
        color: var(--p);
        /* Using Daisy UI's primary color */
    }

    /* The navigation indicator - explicitly positioned */
    #nav-indicator {
        position: absolute;
        bottom: 0;
        z-index: 10;
        background-color: #fd6b18;
        /* Hard-coding the orange color to ensure it works */
        height: 3px;
        transition: transform 0.3s ease, width 0.3s ease, left 0.3s ease;
    }

    /* For smooth scrolling */
    html {
        scroll-behavior: smooth;
    }

    /* Debug styles - to visualize positioning */
    #nav-container {
        position: relative;
        /* Ensure proper positioning context for absolute elements */
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Simpler direct approach to manipulate the indicator
        const navIndicator = document.getElementById('nav-indicator');
        const navLinks = document.querySelectorAll('.nav-link');

        // Simple function to position the indicator
        function setActiveLink(link) {
            // Remove active class from all links
            navLinks.forEach(l => l.classList.remove('active'));

            // Add active class to the current link
            link.classList.add('active');

            // Position the indicator directly using the link's offsetLeft and width
            navIndicator.style.width = link.offsetWidth + 'px';
            navIndicator.style.left = link.offsetLeft + 'px';

            // Debug to console
            console.log(`Active link: ${link.textContent.trim()}, Position: ${link.offsetLeft}px, Width: ${link.offsetWidth}px`);
        }

        // Handle clicks on navigation links
        navLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();

                // Set this as the active link
                setActiveLink(this);

                // Smooth scroll to the target section
                const targetId = this.getAttribute('href');
                const targetSection = document.querySelector(targetId);

                if (targetSection) {
                    const headerHeight = 70; // Adjust based on your header height
                    const targetPosition = targetSection.getBoundingClientRect().top + window.pageYOffset - headerHeight;

                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Find which section is currently visible when scrolling
        function updateOnScroll() {
            const scrollPosition = window.pageYOffset + 100; // Add offset for header

            // Find the section that's currently in view
            let activeSection = null;

            // Check each section from bottom to top (reverse order)
            // This ensures we pick the topmost visible section when multiple are in view
            for (let i = navLinks.length - 1; i >= 0; i--) {
                const link = navLinks[i];
                const sectionId = link.getAttribute('data-section');
                const section = document.getElementById(sectionId);

                if (section) {
                    const sectionTop = section.offsetTop - 150; // Higher offset for better UX

                    if (scrollPosition >= sectionTop) {
                        activeSection = link;
                        break; // Use the first section that matches
                    }
                }
            }

            // If no section is active and we're at the top, default to first section
            if (!activeSection && scrollPosition < 300 && navLinks.length > 0) {
                activeSection = navLinks[0];
            }

            // Set the active section if found
            if (activeSection) {
                setActiveLink(activeSection);
            }
        }

        // Currency Converter functionality
        const currencyAmount = document.getElementById('currency-amount');
        const currencyFrom = document.getElementById('currency-from');
        const currencyResult = document.getElementById('currency-result');

        // Exchange rates relative to USD (since USD is the official currency of Timor-Leste)
        const exchangeRates = {
            'USD': 1.00,
            'EUR': 0.91,
            'GBP': 0.78,
            'AUD': 1.47
        };

        function updateCurrencyConversion() {
            if (!currencyAmount || !currencyFrom || !currencyResult) return;

            const amount = parseFloat(currencyAmount.value) || 0;
            const fromCurrency = currencyFrom.value;
            const rate = exchangeRates[fromCurrency];

            if (rate) {
                // Since USD is the currency of Timor-Leste, we convert to USD
                const resultInUSD = amount * (1 / rate);
                currencyResult.textContent = `${amount} ${fromCurrency} = ${resultInUSD.toFixed(2)} USD`;
            }
        }

        // Add event listeners for currency converter
        if (currencyAmount && currencyFrom) {
            currencyAmount.addEventListener('input', updateCurrencyConversion);
            currencyFrom.addEventListener('change', updateCurrencyConversion);

            // Initial calculation
            updateCurrencyConversion();
        }

        // Initialize the indicator position (after a small delay to ensure DOM is ready)
        setTimeout(() => {
            // Default to first link
            if (navLinks.length > 0) {
                setActiveLink(navLinks[0]);
            }

            // Then update based on scroll position
            updateOnScroll();
        }, 100);

        // Add scroll listener with throttling to prevent performance issues
        let isScrolling = false;
        window.addEventListener('scroll', function() {
            if (!isScrolling) {
                window.requestAnimationFrame(function() {
                    updateOnScroll();
                    isScrolling = false;
                });
                isScrolling = true;
            }
        });

        // Also update on window resize
        window.addEventListener('resize', function() {
            // Find current active link and reposition indicator
            const activeLink = document.querySelector('.nav-link.active') || navLinks[0];
            if (activeLink) {
                setActiveLink(activeLink);
            }
        });
    });
</script>

<main class="mx-auto">

    <!-- Minimalist Welcome Section - Place after hero section and before sticky navigation -->
    <section id="welcome-fisc" class="py-12 bg-base-100">
        <div class="container mx-auto px-4">
            <!-- Clean, Minimalist Layout -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <!-- Left Column: Essential Information -->
                <div>
                    <div class="mb-4">
                        <h2 class="text-3xl text-gray-800 dark:text-white mb-4">Welcome to FISC 2025</h2>

                        <div class="max-w-3xl mb-2">
                            <p class="py-4 leading-relaxed text-neutral-600 dark:text-neutral-400">We are looking forward to welcoming you in Dili for the 2025 FreeBalance International Steering Committee (FISC) event in April. We're confident that this year's event will leave you with many great takeaways and best practices to bring back to your country.</p>

                            <p class="py-4 leading-relaxed text-neutral-600 dark:text-neutral-400">The overall theme for FISC 2025, <span class="italic">"The Digital Transformation of Public Financial Management"</span> is focused on providing insights into leveraging digital solutions to enhance Public Financial Management systems. PFM is the core to effective government operations and sustainable development. Attendees will engage FreeBalance executives in the adjustment of the product roadmap in the context of digital transformation.</p>
                        </div>
                    </div>
                    <div class="mb-6">
                        <h3 class="text-lg font-medium mb-4">Event Information</h3>
                        <ul class="space-y-3">
                            <li class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary mr-3 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="text-neutral-600 dark:text-neutral-400">April 7-10, 2025 at Palm Springs Hotel Dili</span>
                            </li>
                            <li class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary mr-3 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-neutral-600 dark:text-neutral-400">Theme: The Digital Transformation of Public Financial Management</span>
                            </li>
                            <li class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary mr-3 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <div class="text-neutral-600 dark:text-neutral-400">
                                    <div>Zero IV, Fatuhada</div>
                                    <div>Dom Aleixo, Timor-Leste</div>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="text-lg font-medium">Airport Arrival</h3>
                        <p class="py-4 leading-relaxed text-neutral-600 dark:text-neutral-400">Upon exiting the customs area at Presidente Nicolau Lobato International Airport, look out for a driver with a sign with your name. The driver will take you directly to your hotel. The Palm Springs Hotel Dili is approximately 15-20 minutes from the airport depending on traffic.</p>

                        <p class="text-sm mb-2">In the event you don’t see your driver or you separate from your group, please call, text or WhatsApp:</p>
                        <p><a href="tel:+6707723488" class="text-primary">Ludmila: +1 786 521-1544</a></p>
                        <p><a href="tel:+6707723566" class="text-primary">Carolyn: +670 7723 5566</a></p>
                    </div>
                </div>

                <!-- Right Column: Contacts -->
                <div>
                    <div class="mb-8 p-4 bg-base-200/50 rounded-md">
                        <h3 class="text-lg font-medium mb-4">Emergency Contacts</h3>

                        <div class="space-y-4">
                            <div>
                                <p class="font-medium">BCD Travel Support</p>
                                <p><a href="tel:+19055074445" class="text-primary">+1 905 507-4445</a></p>
                                <p class="text-sm text-gray-500 mt-1">Office hours: 8:30am-5:00pm EST Mon-Fri</p>
                            </div>

                            <div>
                                <p class="font-medium">After Hours Support</p>
                                <p><a href="tel:+18553814440" class="text-primary">+1 855-381-4440</a> (Toll Free)</p>
                                <p><a href="tel:+19055077909" class="text-primary">+1 905-507-7909</a> (International)</p>
                                <p class="text-sm text-gray-500 mt-1">Executive Code: TL25</p>
                            </div>

                            <div>
                                <p class="font-medium">Local Support</p>
                                <p><a href="tel:+6707723488" class="text-primary">Ludmila: +1 786 521-1544</a></p>
                                <p><a href="tel:+6707723566" class="text-primary">Carolyn: +670 7723 5566</a></p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-medium mb-4">Need Assistance?</h3>
                        <p class="mb-4">If you have any questions, please do not hesitate to contact:</p>

                        <div class="flex items-center mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <a href="mailto:lpatralska@freebalance.com" class="text-primary">lpatralska@freebalance.com</a>
                        </div>

                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <a href="tel:+6707723488" class="text-primary">+1 786 521-1544</a>
                        </div>
                        <p class="mt-6 text-md text-gray-600 font-medium">Ludmila Patralska</p>
                        <p class="mt-0 text-sm text-gray-500">Director of Affairs, Office of the CEO</p>

                        <p class="mt-6 text-sm text-gray-600">We look forward to a successful and enjoyable event in Dili. We know that the program we have planned will provide you with valuable information to drive better PFM reform and modernization efforts when you return home.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>


</main>

<script>
    // This code should be included in your Sage 10 theme's JavaScript files
    // e.g., in resources/scripts/app.js or a custom module

    // Cookie helper functions
    const Cookies = {
        set: function(name, value, days) {
            let expires = '';
            if (days) {
                const date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = '; expires=' + date.toUTCString();
            }
            document.cookie = name + '=' + JSON.stringify(value) + expires + '; path=/';
        },
        get: function(name) {
            const nameEQ = name + '=';
            const ca = document.cookie.split(';');
            for (let i = 0; i < ca.length; i++) {
                let c = ca[i];
                while (c.charAt(0) === ' ') c = c.substring(1, c.length);
                if (c.indexOf(nameEQ) === 0) {
                    try {
                        return JSON.parse(c.substring(nameEQ.length, c.length));
                    } catch (e) {
                        return null;
                    }
                }
            }
            return null;
        },
        delete: function(name) {
            document.cookie = name + '=; Max-Age=-99999999; path=/';
        }
    };

    // After the DOM is loaded
    document.addEventListener('DOMContentLoaded', function() {
        // Check if Alpine.js is available
        if (typeof window.Alpine !== 'undefined') {
            // Add our custom Alpine.js data handler
            window.Alpine.data('checklistData', function() {
                // The initial checklist items
                const defaultItems = [{
                        id: 1,
                        text: 'Passport (valid for at least 6 months beyond your stay)',
                        done: false,
                        link: '#passport',
                        urgent: true
                    },
                    {
                        id: 2,
                        text: 'Flight reservations to Dili',
                        done: false,
                        link: '#flights',
                        urgent: true
                    },
                    {
                        id: 3,
                        text: 'Travel insurance with medical coverage',
                        done: false,
                        link: '#insurance',
                        urgent: false
                    },
                    {
                        id: 4,
                        text: 'Pack appropriate clothing for hot, humid climate',
                        done: false,
                        link: '#packing',
                        urgent: false
                    },
                    {
                        id: 5,
                        text: 'Exchange currency or withdraw USD from ATM',
                        done: false,
                        link: '#currency',
                        urgent: false
                    },
                    {
                        id: 6,
                        text: 'Inform bank of international travel',
                        done: false,
                        link: '#banking',
                        urgent: false
                    }
                ];

                // Load saved items from cookies or use defaults
                const savedItems = Cookies.get('fisc_checklist_items');

                return {
                    items: savedItems || defaultItems,
                    showSuccessModal: false,

                    // Initialize component
                    init() {
                        // Watch for changes and save to cookies
                        this.$watch('items', (value) => {
                            Cookies.set('fisc_checklist_items', value, 90); // Save for 90 days
                        }, {
                            deep: true
                        });
                    },

                    // Reset the checklist to default state
                    resetChecklist() {
                        this.items = JSON.parse(JSON.stringify(defaultItems));
                    },

                    // Save progress and show success modal
                    saveProgress() {
                        // Save current state to cookies
                        Cookies.set('fisc_checklist_items', this.items, 90); // Save for 90 days

                        // Calculate stats for the modal
                        this.completedCount = this.items.filter(item => item.done).length;
                        this.totalCount = this.items.length;
                        this.completionPercentage = Math.round((this.completedCount / this.totalCount) * 100);

                        // Show the success modal
                        this.showSuccessModal = true;
                    },

                    // Close the success modal
                    closeModal() {
                        this.showSuccessModal = false;
                    },

                    // Get completion percentage
                    getCompletionPercentage() {
                        const completed = this.items.filter(item => item.done).length;
                        return Math.round((completed / this.items.length) * 100);
                    },

                    // Get completion counts
                    getCompletedCount() {
                        return this.items.filter(item => item.done).length;
                    },

                    // Get total count
                    getTotalCount() {
                        return this.items.length;
                    }
                };
            });
        }
    });
</script>

@endsection