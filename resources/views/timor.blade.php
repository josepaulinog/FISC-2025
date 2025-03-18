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

    <!-- About Timor-Leste Section -->
    <section id="about-timor" class="py-16 bg-base-200">
        <div class="container mx-auto px-4">
            <!-- Header -->
            <div class="text-center mb-12">
                <h2 class="text-3xl mb-4">About Timor-Leste</h2>
                <div class="w-24 h-1 bg-primary rounded-full mx-auto mb-4"></div>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Get to know our beautiful host country for FISC 2025
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <!-- Key Facts Card -->
                <div class="card bg-white shadow-lg">
                    <div class="card-body">
                        <h3 class="text-xl font-semibold mb-4 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Key Facts
                        </h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Capital</p>
                                <p class="font-medium">Dili</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Population</p>
                                <p class="font-medium">1.3 Million</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Languages</p>
                                <p class="font-medium">Tetum, Portuguese, Indonesian, English</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Independence</p>
                                <p class="font-medium">May 20, 2002</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Currency</p>
                                <p class="font-medium">US Dollar (USD)</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Religion</p>
                                <p class="font-medium">97% Roman Catholic</p>
                            </div>
                        </div>

                        <!-- Brief History Card -->
                        <div class="mt-6 p-4 bg-base-100 rounded-lg border">
                            <h4 class="font-medium mb-2">Brief History</h4>
                            <p class="text-sm text-gray-600">
                                Timor-Leste (East Timor) gained independence in 2002, becoming the first new sovereign state of the 21st century. After centuries of Portuguese colonization and 24 years of Indonesian occupation, the country has rapidly developed while preserving its rich cultural heritage.
                            </p>
                        </div>

                        <!-- Currency Converter Widget -->
                        <div class="mt-6">
                            <h4 class="font-medium mb-3">Currency Converter</h4>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="text-sm text-gray-500">Amount</label>
                                    <input type="number" value="1" min="1" class="input input-bordered w-full" id="currency-amount">
                                </div>
                                <div>
                                    <label class="text-sm text-gray-500">From</label>
                                    <select class="select select-bordered w-full" id="currency-from">
                                        <option value="USD">USD - US Dollar</option>
                                        <option value="EUR">EUR - Euro</option>
                                        <option value="GBP">GBP - British Pound</option>
                                        <option value="AUD">AUD - Australian Dollar</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mt-3 p-3 bg-gray-50 rounded-lg text-center">
                                <p class="font-medium text-primary" id="currency-result">1 USD = 1.00 USD</p>
                                <p class="text-xs text-gray-500 mt-1">US Dollar is the official currency of Timor-Leste</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Useful Phrases Card -->
                <div class="card bg-white shadow-lg">
                    <figure>
                        <img src="https://cdn.mappr.co/wp-content/uploads/2023/02/timor-leste-location-map-flag-pin.jpg"
                            alt="Timor-Leste landscape" class="w-full h-64 object-cover">
                    </figure>
                    <div class="card-body">
                        <h3 class="text-xl font-semibold mb-4 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                            </svg>
                            Useful Phrases in Tetum
                        </h3>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="flex justify-between items-center p-2 bg-base-100 rounded-lg">
                                <div>
                                    <p class="font-medium">Bondia</p>
                                    <p class="text-sm text-gray-600">Good morning</p>
                                </div>
                                <button class="btn btn-ghost btn-circle btn-sm hidden" onclick="playAudio('bondia')">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15.536a5 5 0 001.06-7.072M3.818 13.364a9 9 0 011.06-12.728" />
                                    </svg>
                                </button>
                            </div>
                            <div class="flex justify-between items-center p-2 bg-base-100 rounded-lg">
                                <div>
                                    <p class="font-medium">Botarde</p>
                                    <p class="text-sm text-gray-600">Good afternoon</p>
                                </div>
                                <button class="btn btn-ghost btn-circle btn-sm hidden" onclick="playAudio('botarde')">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15.536a5 5 0 001.06-7.072M3.818 13.364a9 9 0 011.06-12.728" />
                                    </svg>
                                </button>
                            </div>
                            <div class="flex justify-between items-center p-2 bg-base-100 rounded-lg">
                                <div>
                                    <p class="font-medium">Obrigadu / Obrigada</p>
                                    <p class="text-sm text-gray-600">Thank you (male/female)</p>
                                </div>
                                <button class="btn btn-ghost btn-circle btn-sm hidden" onclick="playAudio('obrigadu')">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15.536a5 5 0 001.06-7.072M3.818 13.364a9 9 0 011.06-12.728" />
                                    </svg>
                                </button>
                            </div>
                            <div class="flex justify-between items-center p-2 bg-base-100 rounded-lg">
                                <div>
                                    <p class="font-medium">Hau nia naran ...</p>
                                    <p class="text-sm text-gray-600">My name is ...</p>
                                </div>
                                <button class="btn btn-ghost btn-circle btn-sm hidden" onclick="playAudio('hauni')">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15.536a5 5 0 001.06-7.072M3.818 13.364a9 9 0 011.06-12.728" />
                                    </svg>
                                </button>
                            </div>
                            <div class="flex justify-between items-center p-2 bg-base-100 rounded-lg">
                                <div>
                                    <p class="font-medium">Diak ka lae?</p>
                                    <p class="text-sm text-gray-600">How are you?</p>
                                </div>
                                <button class="btn btn-ghost btn-circle btn-sm hidden" onclick="playAudio('diak')">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15.536a5 5 0 001.06-7.072M3.818 13.364a9 9 0 011.06-12.728" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Weather Widget -->
                        <div class="mt-6 p-4 rounded-lg bg-gradient-to-r from-blue-50 to-blue-100">
                            <h4 class="font-medium mb-2 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" />
                                </svg>
                                Current Weather in Dili
                            </h4>
                            <div class="flex items-center">
                                <div class="text-3xl font-bold mr-4">31°C</div>
                                <div>
                                    <p class="font-medium">Sunny</p>
                                    <p class="text-sm text-gray-600">Humidity: 76%</p>
                                </div>
                                <div class="ml-auto text-yellow-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 10a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 10a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                            <div class="mt-3 grid grid-cols-4 gap-2 text-center text-xs">
                                <div>
                                    <p>Apr 7</p>
                                    <p class="text-yellow-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 10a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 10a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd" />
                                        </svg>
                                    </p>
                                    <p>30°C</p>
                                </div>
                                <div>
                                    <p>Apr 8</p>
                                    <p class="text-yellow-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 10a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 10a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd" />
                                        </svg>
                                    </p>
                                    <p>31°C</p>
                                </div>
                                <div>
                                    <p>Apr 9</p>
                                    <p class="text-blue-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M5.5 16a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.977A4.5 4.5 0 1113.5 16h-8z" />
                                        </svg>
                                    </p>
                                    <p>29°C</p>
                                </div>
                                <div>
                                    <p>Apr 10</p>
                                    <p class="text-yellow-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 10a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 10a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd" />
                                        </svg>
                                    </p>
                                    <p>30°C</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pre-Arrival Checklist -->
    <section id="pre-arrival" class="py-16 bg-base-100">
        <div class="container mx-auto px-4">
            <!-- Header -->
            <div class="text-center mb-8">
                <h2 class="text-3xl mb-4">Pre-Arrival Checklist</h2>
                <div class="w-24 h-1 bg-primary rounded-full mx-auto mb-4"></div>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Essential preparations to ensure a smooth journey to Timor-Leste
                </p>
            </div>

            <div class="card bg-white shadow-lg border border-gray-200">
                <div class="card-body">
                    <!-- Interactive Checklist with Cookie Storage -->
                    <div x-data="checklistData">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-xl font-semibold">Your Checklist</h3>
                            <span class="badge badge-primary text-white" x-text="getCompletedCount() + ' of ' + getTotalCount() + ' completed'"></span>
                        </div>

                        <div class="grid gap-3">
                            <template x-for="item in items" :key="item.id">
                                <div class="flex items-center border rounded-lg p-3" :class="{'bg-green-50 border-green-200': item.done, 'bg-white': !item.done, 'border-gray-200': !item.done && item.urgent}">
                                    <input type="checkbox" class="checkbox checkbox-primary mr-3 [--chkbg:theme(colors.primary)] [--chkfg:white]" :checked="item.done" @click="item.done = !item.done">
                                    <div class="flex-1">
                                        <p class="font-medium" x-text="item.text"></p>
                                        <a :href="item.link" class="text-xs text-primary hover:underline hidden">View details</a>
                                    </div>
                                    <span x-show="item.urgent && !item.done" class="badge bg-secondary badge-sm text-white border-0">Required</span>
                                </div>
                            </template>
                        </div>

                        <!-- Save Progress Section -->
                        <div id="save-progress-container" class="mt-8 flex flex-col bg-gray-50 p-4 rounded-lg">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="font-medium">Save your checklist progress</h4>
                                    <p class="text-sm text-gray-600">We're automatically saving your progress to browser cookies</p>
                                </div>
                                <div class="flex space-x-2">
                                    <button @click="resetChecklist()" class="btn btn-outline btn-sm">Reset</button>
                                    <button @click="saveProgress()" class="btn btn-primary text-white btn-sm">Save Progress</button>
                                </div>
                            </div>
                        </div>

                        <!-- Success Modal (Daisy UI) -->
                        <input type="checkbox" id="success-modal" class="modal-toggle" :checked="showSuccessModal" @change="showSuccessModal = $el.checked" />
                        <div class="modal" :class="{'modal-open': showSuccessModal}">
                            <div class="modal-box">
                                <div class="flex justify-center mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-success" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <h3 class="font-bold text-xl text-center mb-2">Progress Saved!</h3>
                                <div class="text-center mb-6">
                                    <p>Your checklist has been saved to your browser's cookies.</p>
                                    <p class="mt-2">You've completed <span class="font-bold" x-text="getCompletedCount()"></span> out of <span x-text="getTotalCount()"></span> items.</p>
                                </div>

                                <!-- Progress Bar -->
                                <div class="w-full bg-gray-200 rounded-full h-4 mb-6">
                                    <div class="bg-primary h-4 rounded-full" :style="'width: ' + getCompletionPercentage() + '%'"></div>
                                </div>

                                <p class="text-sm text-gray-600 mb-4">Your progress will be remembered on this device until you clear your browser cookies or use the reset button.</p>

                                <div class="modal-action">
                                    <button @click="closeModal()" class="btn btn-primary text-white">Continue</button>
                                </div>
                            </div>
                            <label class="modal-backdrop" @click="closeModal()"></label>
                        </div>

                        <!-- Rest of your content (Travel Information, Packing Essentials, etc.) -->
                        <!-- ... Your existing content here ... -->
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section id="cultural" class="py-16 bg-base-100 hidden">
        <div class="container mx-auto px-4">
            <!-- Clean, Simple Header -->
            <div class="text-center mb-8">
                <h2 class="text-3xl mb-4">Cultural Experiences</h2>
                <div class="w-24 h-1 bg-primary rounded-full mx-auto mb-4"></div>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Experience the unique culture of Timor-Leste during your FISC 2025 visit
                </p>
            </div>

            <div class="card bg-white shadow-lg border hover:shadow-xl transition-shadow duration-300">
                <div class="card-body p-6">
                    <!-- Local Culture Sections -->
                    <div class="grid md:grid-cols-2 gap-6 mt-8">
                        <!-- Traditional Crafts Section (replaced Useful Phrases) -->
                        <div class="border rounded-lg p-5 bg-gray-50">
                            <div class="flex items-center gap-3 mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                                </svg>
                                <h3 class="font-semibold text-lg">Traditional Crafts to Discover</h3>
                            </div>
                            <div class="grid grid-cols-1 gap-4">
                                <div class="flex flex-col sm:flex-row gap-4 items-center">
                                    <img src="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEjXJjV4O1LpGPfqG2o3iAwP6E5nr_vcs8YCrJ77XGAJUXaoInY1SzAyXJ01K7ZJd9MoDM0FhX4DNEvMVdHKkQeBfRqZd94BKRyNeYNzCWKy7CVHPAm4AUjRibxsMTNXUS7eOt6DMFeQnjM/s320/Tais,+Dili,+E+Timor,+Nov06.jpg" alt="Tais weaving" class="rounded-lg object-cover sm:w-1/3 max-w-xs w-28 h-28 aspect-square" />
                                    <div>
                                        <h4 class="font-medium text-md mb-1">Tais Textiles</h4>
                                        <p class="text-sm text-gray-600">These handwoven cloths are Timor-Leste's most iconic craft. Each region has distinctive patterns and colors that tell stories of cultural heritage and family history. Delegates can purchase these as meaningful souvenirs.</p>
                                    </div>
                                </div>
                                <div class="flex flex-col sm:flex-row gap-4 items-center">
                                    <img src="https://www.artesintonia.com.br/cdn/shop/collections/banner-colecao-artesanatos-decoratvos-decoracoes-tribais-timor-indonesia-etnicas.jpg?v=1693456247" alt="Wood carving" class="rounded-lg object-cover sm:w-1/3 max-w-xs w-28 h-28 aspect-square" />
                                    <div>
                                        <h4 class="font-medium text-md mb-1">Traditional Wood Carvings</h4>
                                        <p class="text-sm text-gray-600">Local artisans create intricate sculptures representing ancestral figures, everyday life, and natural elements. These beautiful pieces showcase the skilled craftsmanship passed down through generations.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Local Foods with Images -->
                        <div class="border rounded-lg p-5 bg-gray-50">
                            <div class="flex items-center gap-3 mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                <h3 class="font-semibold text-lg">Foods to Try</h3>
                            </div>
                            <div class="grid gap-4">
                                <div class="flex flex-col sm:flex-row gap-3 items-center">
                                    <img src="https://amcarmenskitchen.com/wp-content/uploads/2021/05/1895.jpg" alt="Ikan Pepes" class="rounded-lg object-cover w-28 h-28 aspect-square" />
                                    <div>
                                        <h4 class="font-medium">Ikan Pepes</h4>
                                        <p class="text-sm text-gray-600">Fish seasoned with aromatic spices and wrapped in banana leaf before being grilled or steamed. The banana leaf imparts a unique fragrance and keeps the fish moist during cooking.</p>
                                    </div>
                                </div>
                                <div class="flex flex-col sm:flex-row gap-3 items-center">
                                    <img src="https://www.crsricebowl.org/wp-content/uploads/2024/09/CRS2012074635_2560w.jpg" alt="Batar Da'an" class="rounded-lg object-cover w-28 h-28 aspect-square" />
                                    <div>
                                        <h4 class="font-medium">Batar Da'an</h4>
                                        <p class="text-sm text-gray-600">A hearty traditional stew made with corn and pumpkin, often including beans and other local vegetables. This comforting dish is a staple in Timorese households.</p>
                                    </div>
                                </div>
                                <div class="flex flex-col sm:flex-row gap-3 items-center">
                                    <img src="https://images.squarespace-cdn.com/content/v1/636bcbc6e2494c61701cfca1/e14a2cb4-1c7b-4ff6-b81a-8cc890f22c46/4212NEW.jpg" alt="Timor Coffee" class="rounded-lg object-cover w-28 h-28 aspect-square" />
                                    <div>
                                        <h4 class="font-medium">Timor Coffee</h4>
                                        <p class="text-sm text-gray-600">Timor-Leste produces some of the world's finest organic coffee. Grown at high elevations, it has a smooth, full-bodied flavor with low acidity and notes of chocolate and caramel.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Cultural Tips -->
                    <div class="mt-6 p-4 border border-dashed rounded-lg bg-gray-50">
                        <h3 class="font-semibold text-lg mb-3 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Quick Cultural Tips
                        </h3>
                        <div class="grid md:grid-cols-2 gap-3 text-sm">
                            <div class="flex items-start gap-2">
                                <svg class="h-5 w-5 text-primary mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Greet people with a handshake and a smile. Many Timorese also place their right hand over their heart after shaking hands as a sign of sincerity.</span>
                            </div>
                            <div class="flex items-start gap-2">
                                <svg class="h-5 w-5 text-primary mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Dress modestly, especially when visiting cultural sites or rural communities. Shoulders and knees should be covered.</span>
                            </div>
                            <div class="flex items-start gap-2">
                                <svg class="h-5 w-5 text-primary mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Remove shoes when entering someone's home or certain buildings if others have done so.</span>
                            </div>
                            <div class="flex items-start gap-2">
                                <svg class="h-5 w-5 text-primary mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>The U.S. dollar is the official currency in Timor-Leste. Bring smaller bills as change can be limited.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Interactive Map Component -->
    <x-interactive-map />
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