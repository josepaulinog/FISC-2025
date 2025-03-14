{{--
  Template Name: Support Template
--}}

@extends('layouts.app')

@section('content')
<section class="bg-base-200 py-20">
<div 
    class="relative w-full bg-base-100 px-6 shadow-xl ring-1 ring-gray-900/5 sm:mx-auto sm:max-w-4xl sm:rounded-lg sm:px-10">
    <div class="mx-auto px-5 py-10">
        <div class="flex flex-col items-center">
            <h2 class="mt-5 text-center text-5xl tracking-tight md:text-5xl">Partner Support</h2>
            <p class="mt-3 text-lg text-neutral-600 dark:text-neutral-400 md:text-xl">Frequently Asked Questions</p>
        </div>
        <div class="mx-auto mt-8 grid max-w-2xl divide-y divide-neutral-200">
            <div class="py-5">
                <details open class="group">
                    <summary class="flex cursor-pointer list-none items-center justify-between font-medium">
                        <span>How do I access partner-specific materials?</span>
                        <span class="transition group-open:rotate-180">
                                <svg fill="none" height="24" shape-rendering="geometricPrecision"
                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="1.5" viewBox="0 0 24 24" width="24">
                                    <path d="M6 9l6 6 6-6"></path>
                                </svg>
                            </span>
                    </summary>
                    <p class="group-open:animate-fadeIn mt-3 text-neutral-600 dark:text-neutral-400">Partner-specific materials, including joint branded content, are available in the "Partner Tools" section of the portal. Access is based on your company's partnership level and individual user privileges. If you can't find what you need, please contact our partner support team.</p>
                </details>
            </div>
            <div class="py-5">
                <details class="group">
                    <summary class="flex cursor-pointer list-none items-center justify-between font-medium">
                        <span>How do I submit an opportunity through the portal?</span>
                        <span class="transition group-open:rotate-180">
                                <svg fill="none" height="24" shape-rendering="geometricPrecision"
                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="1.5" viewBox="0 0 24 24" width="24">
                                    <path d="M6 9l6 6 6-6"></path>
                                </svg>
                            </span>
                    </summary>
                    <p class="group-open:animate-fadeIn mt-3 text-neutral-600 dark:text-neutral-400">To submit an opportunity, navigate to the "Opportunity Form" on the top navigation menu. Fill out all required fields and submit. The form will automatically create a record in our system and notify the relevant internal stakeholders.</p>
                </details>
            </div>
            <div class="py-5 hidden">
                <details class="group">
                    <summary class="flex cursor-pointer list-none items-center justify-between font-medium">
                        <span>How are user privileges determined?</span>
                        <span class="transition group-open:rotate-180">
                                <svg fill="none" height="24" shape-rendering="geometricPrecision"
                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="1.5" viewBox="0 0 24 24" width="24">
                                    <path d="M6 9l6 6 6-6"></path>
                                </svg>
                            </span>
                    </summary>
                    <p class="group-open:animate-fadeIn mt-3 text-neutral-600 dark:text-neutral-400">User privileges are set based on your role within your organization and your company's partnership level with FreeBalance. For example, senior staff may have access to more sensitive materials, while sales teams can access presentations that pre-sales cannot. If you need additional access, please contact your company's FreeBalance partnership manager.</p>
                </details>
            </div>
            <div class="py-5">
                <details class="group">
                    <summary class="flex cursor-pointer list-none items-center justify-between font-medium">
                        <span>How often is content updated?</span>
                        <span class="transition group-open:rotate-180">
                                <svg fill="none" height="24" shape-rendering="geometricPrecision"
                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="1.5" viewBox="0 0 24 24" width="24">
                                    <path d="M6 9l6 6 6-6"></path>
                                </svg>
                            </span>
                    </summary>
                    <p class="group-open:animate-fadeIn mt-3 text-neutral-600 dark:text-neutral-400">We regularly update our content to ensure you have access to the latest information. Major updates are typically announced via email and on the portal dashboard. We recommend checking the portal frequently for new materials and updates.</p>
                </details>
            </div>
            <div class="py-5">
                <details class="group">
                    <summary class="flex cursor-pointer list-none items-center justify-between font-medium">
                        <span>How do I get technical support for FreeBalance products?</span>
                        <span class="transition group-open:rotate-180">
                                <svg fill="none" height="24" shape-rendering="geometricPrecision"
                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="1.5" viewBox="0 0 24 24" width="24">
                                    <path d="M6 9l6 6 6-6"></path>
                                </svg>
                            </span>
                    </summary>
                    <p class="group-open:animate-fadeIn mt-3 text-neutral-600 dark:text-neutral-400">For technical support, please use the "Support Ticket" system available in the portal. This ensures your request is routed to the appropriate team. For urgent matters, you can also contact our partner support hotline, available 24/7.</p>
                </details>
            </div>
            <div class="py-5">
                <details class="group">
                    <summary class="flex cursor-pointer list-none items-center justify-between font-medium">
                        <span>How can I provide feedback or suggest improvements to the portal?</span>
                        <span class="transition group-open:rotate-180">
                                <svg fill="none" height="24" shape-rendering="geometricPrecision"
                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="1.5" viewBox="0 0 24 24" width="24">
                                    <path d="M6 9l6 6 6-6"></path>
                                </svg>
                            </span>
                    </summary>
                    <p class="group-open:animate-fadeIn mt-3 text-neutral-600 dark:text-neutral-400">We value your input! You can submit feedback or suggestions through the "Contact" form in the portal. We regularly review all submissions and use them to improve our partner experience.</p>
                </details>
            </div>
        </div>
    </div>
</div>
</section>

@endsection