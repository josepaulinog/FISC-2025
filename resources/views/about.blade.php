{{--
  Template Name: About Template
--}}

@extends('layouts.app')

@section('content')

@include('partials.headers.hero')

<main>

<section class="py-16">
    <div class="container mx-auto px-4">
        <div class="text-center mb-8">
            <h2 class="text-3xl mb-4">Our Approach</h2>
            <div class="w-16 h-1 rounded-full bg-primary mx-auto mb-4 inline-flex"></div>
            <p class="text-lg max-w-2xl mx-auto text-neutral-500 dark:text-neutral-400 lg:mb-4">
                FISC serves as a platform for collaborative engagement, providing:
            </p>
        </div>

        <!-- Contact Details Cards (using the same style as contact page) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-4">
            <!-- Regional Collaboration Card -->
            <div class="card bg-white dark:bg-gray-800 shadow-lg hover:shadow-xl transition-shadow duration-300 border border-gray-100 dark:border-gray-700">
                <div class="card-body">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold mb-2">Regional Collaboration</h3>
                        <p class="text-neutral-500 text-center">
                            FISC brings together finance officials, PFM practitioners, and regional experts to address fiscal challenges, exchange ideas, and develop cooperative solutions.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Knowledge Exchange Card -->
            <div class="card bg-white dark:bg-gray-800 shadow-lg hover:shadow-xl transition-shadow duration-300 border border-gray-100 dark:border-gray-700">
                <div class="card-body">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 01-.825-.242m9.345-8.334a2.126 2.126 0 00-.476-.095 48.64 48.64 0 00-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0011.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold mb-2">Knowledge Exchange</h3>
                        <p class="text-neutral-500 text-center">
                            Participants engage in focused discussions on regional fiscal policy, budget transparency, and public sector accounting practices through presentations, workshops, and panels.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Applied Solutions Card -->
            <div class="card bg-white dark:bg-gray-800 shadow-lg hover:shadow-xl transition-shadow duration-300 border border-gray-100 dark:border-gray-700">
                <div class="card-body">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold mb-2">Applied Solutions</h3>
                        <p class="text-neutral-500 text-center">
                            FISC discussions contribute to practical recommendations for PFM improvements and inform the development of financial management information systems tailored to regional needs.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

    <x-content-section
        bgClass="bg-base-200"
        imageUrl="https://freebalance.com/wp-content/uploads/2024/10/2019-FISC-scaled-1.jpg"
        imageAlt="FISC Conference Session"
        imagePosition="left"
        title="The Digital Transformation of Public Financial Management"
        paragraph1="This year’s theme emphasizes how governments can leverage technology to improve
transparency, efficiency, and service delivery. Discussions will focus on:"
        :items="[
            'Modernizing public financial systems through digital platforms and AI-driven solutions..',
            'Enhancing fiscal transparency and accountability using real-time data and automation.',
            'Strengthening cybersecurity and data governance to protect national financial assets.',
            'Developing agile and adaptive financial management strategies in an evolving global
landscape.'
        ]">
    </x-content-section>

    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl mb-4">Key Benefits of Fisc 2025</h2>
                <div class="w-16 h-1 rounded-full bg-primary mx-auto mb-4 inline-flex"></div>
                <p class="text-lg max-w-2xl mx-auto text-neutral-500 dark:text-neutral-400 mb-8">
                    FISC brings together customers at all stages of their PFM modernization journey. Some have been using FreeBalance solutions for over 25 years, while others are just beginning. FISC creates a dynamic environment where delegates share stories, lessons learned, and good practices. Attendees benefit from:
                </p>
            </div>

            <!-- Simple, minimal grid layout -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-10">
                <!-- Peer-to-peer knowledge exchange -->
                <div class="flex items-start">
                    <div class="mr-4 flex-shrink-0">
                        <div class="w-12 h-12 rounded-md bg-gray-100 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-2 text-gray-800 dark:text-white">Peer-to-peer knowledge exchange</h3>
                        <p class="text-neutral-500 dark:text-neutral-300  mb-8">
                            Attendees learn from one another about managing organizational change, overcoming obstacles, and effective governance strategies.
                        </p>
                    </div>
                </div>

                <!-- Good practices in PFM reform -->
                <div class="flex items-start">
                    <div class="mr-4 flex-shrink-0">
                        <div class="w-12 h-12 rounded-md bg-gray-100 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-2 text-gray-800 dark:text-white">Good practices in PFM reform</h3>
                        <p class="text-neutral-500 dark:text-neutral-300  mb-8">
                            Governments discuss real experiences in modernizing financial systems, improving transparency, and implementing digital solutions.
                        </p>
                    </div>
                </div>

                <!-- Global network of PFM leaders -->
                <div class="flex items-start">
                    <div class="mr-4 flex-shrink-0">
                        <div class="w-12 h-12 rounded-md bg-gray-100 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 0 1-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0 1 15 18.257V17.25m6-12V15a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 15V5.25m18 0A2.25 2.25 0 0 0 18.75 3H5.25A2.25 2.25 0 0 0 3 5.25m18 0V12a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 12V5.25" />
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-2 text-gray-800 dark:text-white">Global network of PFM leaders</h3>
                        <p class="text-neutral-500 dark:text-neutral-300  mb-8">
                            Customers connect with government officials, digital transformation experts, and FreeBalance executives in an open, collaborative environment.
                        </p>
                    </div>
                </div>

                <!-- Shared success, shared challenges -->
                <div class="flex items-start">
                    <div class="mr-4 flex-shrink-0">
                        <div class="w-12 h-12 rounded-md bg-gray-100 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 0 0 1.5-.189m-1.5.189a6.01 6.01 0 0 1-1.5-.189m3.75 7.478a12.06 12.06 0 0 1-4.5 0m3.75 2.383a14.406 14.406 0 0 1-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 1 0-7.517 0c.85.493 1.509 1.333 1.509 2.316V18" />
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-2 text-gray-800 dark:text-white">Shared success, shared challenges</h3>
                        <p class="text-neutral-500 dark:text-neutral-300  mb-8">
                            Delegates discuss what has worked, what hasn't, and how to navigate complex reforms, ensuring that every participant gains practical insights.
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Additional paragraph -->
            <div class="text-center mt-12">
                <p class="text-lg max-w-3xl mx-auto text-neutral-500 dark:text-neutral-400">
                    By actively participating in FISC, FreeBalance customers influence the solutions that support their financial reform goals—a level of collaboration that sets FISC apart from any other industry event.
                </p>
            </div>
        </div>
    </section>

    <section class="py-16 bg-base-200">
        <div class="container mx-auto px-4">
            <div class="text-center lg:mb-12">
                <h2 class="text-3xl mb-4">FISC Program Evolution: 2007-2025</h2>
                <div class="w-16 h-1 rounded-full bg-primary mx-auto mb-4 inline-flex"></div>
                <p class="text-lg max-w-2xl mx-auto text-neutral-500 dark:text-neutral-400 lg:mb-12">
                    Since its inception, FISC has evolved to address changing priorities in public financial management. The program continues to develop with FISC 2025 in Timor-Leste.
                </p>
            </div>

            <ul class="timeline timeline-snap-icon timeline-vertical lg:timeline-vertical">
                <li>
                    <div class="timeline-middle">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-10 w-10 text-primary">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="timeline-start shadow-xl border-0 timeline-box md:text-end mb-10 mx-4  p-6">
                        <time class="font-mono italic">2007</time>
                        <div class="text-lg text-secondary font-semibold">London</div>
                        <p class="text-neutral-500 dark:text-neutral-400">
                            The initial FISC meeting established a framework for collaborative discussions on PFM topics.
                        </p>
                    </div>
                    <hr />
                </li>

                <li>
                    <hr />
                    <div class="timeline-middle">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-10 w-10 text-primary">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="timeline-end shadow-xl border-0 timeline-box mb-10 mb-10 mx-4  p-6">
                        <time class="font-mono italic">2008</time>
                        <div class="text-lg text-secondary font-semibold">Cascais</div>
                        FISC expanded its program content to include discussions on fiscal sustainability.
                    </div>
                    <hr />
                </li>

                <li>
                    <hr />
                    <div class="timeline-middle">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-10 w-10 text-primary">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="timeline-start shadow-xl border-0 timeline-box md:text-end mb-10 mx-4  p-6">
                        <time class="font-mono italic">2009</time>
                        <div class="text-lg text-secondary font-semibold">Prague</div>
                        Technology integration became a focal point of FISC discussions.
                    </div>
                    <hr />
                </li>

                <li>
                    <hr />
                    <div class="timeline-middle">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-10 w-10 text-primary">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="timeline-end shadow-xl border-0 timeline-box mb-10 mb-10 mx-4  p-6">
                        <time class="font-mono italic">2010</time>
                        <div class="text-lg text-secondary font-semibold">Ottawa</div>
                        FISC introduced specialized sessions for ministerial-level participants.
                    </div>
                    <hr />
                </li>

                <li>
                    <hr />
                    <div class="timeline-middle">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-10 w-10 text-primary">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="timeline-start shadow-xl border-0 timeline-box md:text-end mb-10 mx-4  p-6">
                        <time class="font-mono italic">2016</time>
                        <div class="text-lg text-secondary font-semibold">Managua</div>
                        The 10th FISC focused on practical innovations in financial management systems.
                    </div>
                    <hr />
                </li>

                <li>
                    <hr />
                    <div class="timeline-middle">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-10 w-10 text-primary">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="timeline-end shadow-xl border-0 timeline-box mb-10 mb-10 mx-4  p-6">
                        <time class="font-mono italic">2018</time>
                        <div class="text-lg text-secondary font-semibold">Miami</div>
                        FISC expanded its format to include the H20 Summit on technology applications in governance.
                    </div>
                    <hr />
                </li>

                <li>
                    <hr />
                    <div class="timeline-middle">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-10 w-10 text-primary">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="timeline-start shadow-xl border-0 timeline-box md:text-end mb-10 mx-4  p-6">
                        <time class="font-mono italic">2019</time>
                        <div class="text-lg text-secondary font-semibold">Cascais</div>
                        The 12th FISC returned to Portugal with a focus on sustainable finance practices in the public sector.
                    </div>
                </li>
            </ul>
        </div>
    </section>

    <!-- FAQs Section -->
    @php
    $faqItems = [
    [
    'question' => 'What is FISC 2025?',
    'answer' => 'FISC 2025 is a forum focused on Public Financial Management (PFM) that will bring together government officials, finance professionals, and technology specialists in Timor-Leste from April 7-10, 2025 to discuss fiscal management approaches, transparency mechanisms, and technology integration.'
    ],
    [
    'question' => 'Who will be presenting at FISC 2025?',
    'answer' => 'FISC 2025 will feature presentations from FreeBalance senior leaders, technical specialists, and selected guest speakers with expertise in various aspects of public financial management.'
    ],
    [
    'question' => 'Where and when will FISC 2025 be held?',
    'answer' => 'FISC 2025 will be held at the Palm Springs Hotel in Dili, Timor-Leste from April 7-10, 2025.'
    ],
    [
    'question' => 'How does FISC contribute to PFM practices?',
    'answer' => 'FISC facilitates knowledge exchange between participants, allowing them to learn from each other\'s experiences with implementing financial systems. The discussions and recommendations from FISC often contribute to product development and implementation strategies for financial management solutions.'
    ],
    [
    'question' => 'What topics will be covered at FISC 2025?',
    'answer' => 'FISC 2025 will include sessions on public financial management practices, digital transformation in government finance, transparency mechanisms, and financial system implementation strategies. Visit the Agenda page to see the latest session information. Please note that the agenda is subject to change.'
    ],
    [
    'question' => 'Will there be cultural activities during FISC 2025?',
    'answer' => 'Yes, FISC 2025 will include selected cultural activities and networking events to showcase Timor-Leste\'s heritage and provide opportunities for informal discussions among participants.'
    ],
    ];
    @endphp

    <x-faqs
        title="Frequently Asked Questions"
        subtitle="Information about FISC 2025 in Timor-Leste"
        bgClass=""
        :faqs="$faqItems" />

</main>

@endsection

@push('scripts')