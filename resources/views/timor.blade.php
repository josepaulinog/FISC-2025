{{--
  Template Name:Guide Template
--}}

@extends('layouts.app')

@section('content')
<!-- Enhanced Hero Section - Simplified -->
<div class="hero bg-cover bg-center relative" style="background-image: url('https://fisc.freebalance.com/wp-content/uploads/2025/03/Timor-Leste.jpg')">
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

</main>

@endsection