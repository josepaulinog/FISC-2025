{{--
  Template Name: About Template
--}}

@extends('layouts.app')

@section('content')

@include('partials.headers.hero')

<main>

    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="text-center lg:mb-4">
                <h2 class="text-3xl mb-4">Our Impact</h2>
                <div class="w-16 h-1 rounded-full bg-primary mx-auto mb-4 inline-flex"></div>
                <p class="text-lg max-w-2xl mx-auto text-neutral-500 dark:text-neutral-400 lg:mb-8">
                FISC serves as the cornerstone of our customer-centric approach, enabling:
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="flex flex-col items-center">
                    <div class="w-16 h-16 inline-flex items-center justify-center rounded-lg bg-orange-100 text-primary mb-5 flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-10 h-10 text-primary">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-4">Global Collaboration</h3>
                    <p class="text-neutral-500 text-center">
                        FISC unites finance ministers, central bank governors, and PFM experts to tackle global fiscal challenges, share best practices, and foster international cooperation.
                    </p>
                </div>
                <div class="flex flex-col items-center">
                    <div class="w-16 h-16 inline-flex items-center justify-center rounded-lg bg-orange-100 text-primary mb-5 flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-10 h-10 text-primary">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 01-.825-.242m9.345-8.334a2.126 2.126 0 00-.476-.095 48.64 48.64 0 00-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0011.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-4">Knowledge Exchange</h3>
                    <p class="text-neutral-500 text-center">
                        Engage in high-level discussions on fiscal policy, budget transparency, and public sector accounting standards through keynotes, workshops, and panel discussions.
                    </p>
                </div>
                <div class="flex flex-col items-center">
                    <div class="w-16 h-16 inline-flex items-center justify-center rounded-lg bg-orange-100 text-primary mb-5 flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-10 h-10 text-primary">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-4">Practical Outcomes</h3>
                    <p class="text-neutral-500 text-center">
                        FISC discussions inform policy recommendations, shape international PFM standards, and guide the development of innovative financial management information systems (FMIS).
                    </p>
                </div>
            </div>
        </div>
    </section>

    <x-content-section
        bgClass="bg-base-200"
        imageUrl="https://freebalance.com/wp-content/uploads/2024/10/2019-FISC-scaled-1.jpg"
        imageAlt="Illustration of FreeBalance Partner Portal"
        imagePosition="left"
        title="Driving Public Financial Innovation"
        paragraph1="The FreeBalance International Steering Committee (FISC) 2025 is the global forum for Public Financial Management (PFM), bringing together government leaders, finance experts, and technology innovators."
        paragraph2="Through interactive discussions, workshops, and case studies, attendees will explore the latest trends in fiscal sustainability, governance transparency, and digital transformation.">
    </x-content-section>



<section class="py-16 bg-white hidden">
  <div class="container mx-auto px-4">

    <div class="text-center lg:mb-12">
            <h2 class="text-3xl mb-4">Why FISC 2025 Matters </h2>
            <div class="w-16 h-1 rounded-full bg-primary mx-auto mb-4 inline-flex"></div>
            <p class="text-lg max-w-2xl mx-auto text-neutral-500 dark:text-neutral-400 lg:mb-12">
                    Join us as we explore a dynamic schedule of engaging sessions and keynotes.
            </p>
    </div>

    <div class="flex flex-wrap sm:-m-4 -mx-4 -mb-10 -mt-4 md:space-y-0 space-y-6">
      <div class="p-4 md:w-1/2 flex">
        <div class="w-12 h-12 inline-flex items-center justify-center rounded-lg bg-orange-100 text-primary mb-4 flex-shrink-0">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-6 h-6 text-primary">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>
        </div>
        <div class="flex-grow pl-6">
          <h2 class="text-gray-900 text-lg title-font font-medium mb-2">Exclusive Networking Opportunities</h2>
          <p class="leading-relaxed text-base">Connect with government leaders, PFM professionals, and technology innovators from around the world in a private, collaborative environment.</p>
        </div>
      </div>
      <div class="p-4 md:w-1/2 flex">
        <div class="w-12 h-12 inline-flex items-center justify-center rounded-lg bg-orange-100 text-primary mb-4 flex-shrink-0">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-6 h-6 text-primary">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                </svg>
        </div>
        <div class="flex-grow pl-6">
          <h2 class="text-gray-900 text-lg title-font font-medium mb-2">Influence the Roadmap</h2>
          <p class="leading-relaxed text-base">Connect with government leaders, PFM professionals, and technology innovators from around the world in a private, collaborative environment.</p>
        </div>
      </div>
      <div class="p-4 md:w-1/2 flex">
        <div class="w-12 h-12 inline-flex items-center justify-center rounded-lg bg-orange-100 text-primary mb-4 flex-shrink-0">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-6 h-6 text-primary"> <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 0 1-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0 1 15 18.257V17.25m6-12V15a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 15V5.25m18 0A2.25 2.25 0 0 0 18.75 3H5.25A2.25 2.25 0 0 0 3 5.25m18 0V12a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 12V5.25" /></svg>
        </div>
        <div class="flex-grow pl-6">
          <h2 class="text-gray-900 text-lg title-font font-medium mb-2">Knowledge Exchange</h2>
          <p class="leading-relaxed text-base">Gain access to exclusive insights into emerging trends, best practices, and innovative solutions in PFM and governance.</p>
        </div>
      </div>
      <div class="p-4 md:w-1/2 flex">
        <div class="w-12 h-12 inline-flex items-center justify-center rounded-lg bg-orange-100 text-primary mb-4 flex-shrink-0">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-6 h-6 text-primary"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 0 0 1.5-.189m-1.5.189a6.01 6.01 0 0 1-1.5-.189m3.75 7.478a12.06 12.06 0 0 1-4.5 0m3.75 2.383a14.406 14.406 0 0 1-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 1 0-7.517 0c.85.493 1.509 1.333 1.509 2.316V18" /></svg>
        </div>
        <div class="flex-grow pl-6">
          <h2 class="text-gray-900 text-lg title-font font-medium mb-2">Actionable Insights</h2>
          <p class="leading-relaxed text-base">Learn from exclusive case studies, expert presentations, and interactive discussions to drive reform in your country.</p>
        </div>
      </div>
    </div>
  </div>
</section>

    

    <section class="py-16">
        <div class="container mx-auto px-4">

            <div class="text-center lg:mb-12">
                <h2 class="text-3xl mb-4">Why FISC 2025 Matters </h2>
                <div class="w-16 h-1 rounded-full bg-primary mx-auto mb-4 inline-flex"></div>
                <p class="text-lg max-w-2xl mx-auto text-neutral-500 dark:text-neutral-400 lg:mb-12">
                    Join us as we explore a dynamic schedule of engaging sessions and keynotes.
                </p>
            </div>
            <div class="grid max-w-xl grid-cols-1 gap-x-8 gap-y-10 lg:max-w-none lg:grid-cols-2 lg:gap-y-16">
                <div class="flex items-start space-x-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-16 h-16 text-primary mb-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>
                    <div>
                        <h3 class="text-xl font-semibold mb-2">Exclusive Networking Opportunities</h3>
                        <p class="text-neutral-500">Connect with government leaders, PFM professionals, and technology innovators from around the world in a private, collaborative environment.</p>
                    </div>
                </div>
                <div class="flex items-start space-x-4">
                    
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-16 h-16 text-primary mb-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                </svg>

                    <div>
                        <h3 class="text-xl font-semibold mb-2">Knowledge Exchange</h3>
                        <p class="text-neutral-500">Gain access to exclusive insights into emerging trends, best practices, and innovative solutions in PFM and governance.</p>
                    </div>
                </div>
                <div class="flex items-start space-x-4">

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-16 h-16 text-primary mb-4"> <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 0 1-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0 1 15 18.257V17.25m6-12V15a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 15V5.25m18 0A2.25 2.25 0 0 0 18.75 3H5.25A2.25 2.25 0 0 0 3 5.25m18 0V12a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 12V5.25" /></svg>


                    <div>
                        <h3 class="text-xl font-semibold mb-2">Influence the Roadmap</h3>
                        <p class="text-neutral-500">Connect with government leaders, PFM professionals, and technology innovators from around the world in a private, collaborative environment.</p>
                    </div>
                </div>
                <div class="flex items-start space-x-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-16 h-16 text-primary mb-4"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 0 0 1.5-.189m-1.5.189a6.01 6.01 0 0 1-1.5-.189m3.75 7.478a12.06 12.06 0 0 1-4.5 0m3.75 2.383a14.406 14.406 0 0 1-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 1 0-7.517 0c.85.493 1.509 1.333 1.509 2.316V18" /></svg>
                    <div>
                        <h3 class="text-xl font-semibold mb-2">Actionable Insights</h3>
                        <p class="text-neutral-500">Learn from exclusive case studies, expert presentations, and interactive discussions to drive reform in your country.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 bg-base-200">
        <div class="container mx-auto px-4">
            <div class="text-center lg:mb-12">
                <h2 class="text-3xl mb-4">A Legacy of Impact: FISC Timeline</h2>
                <div class="w-16 h-1 rounded-full bg-primary mx-auto mb-4 inline-flex"></div>
                <p class="text-lg max-w-2xl mx-auto text-neutral-500 dark:text-neutral-400 lg:mb-12">
                    Since its inception, FISC has been at the forefront of shaping global fiscal policies. Explore our journey through the years.
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
                        <div class="text-lg font-semibold">London</div>
                        <p class="text-neutral-500 dark:text-neutral-400">
                        The inaugural FISC meeting laid the foundation for global PFM collaboration.
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
                        <div class="text-lg font-semibold">Cascais</div>
                        FISC expanded its reach, focusing on sustainable fiscal policies.
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
                        <div class="text-lg font-semibold">Prague</div>
                        FISC introduced digital transformation as a key theme.
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
                        <div class="text-lg font-semibold">Ottawa</div>
                        FISC in Canada marked the launch of the Ministers' Program.
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
                        <div class="text-lg font-semibold">Managua</div>
                        The 10th Annual FISC Conference focused on innovation in PFM.
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
                        <div class="text-lg font-semibold">Miami</div>
                        FISC and H20 Government Summit highlighted technology-driven governance.
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
                        <div class="text-lg font-semibold">Cascais</div>
                        The 12th Annual FISC Conference returned to Portugal, emphasizing sustainable finance.
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
    'answer' => 'FISC 2025 is the global forum for Public Financial Management (PFM), bringing together government leaders, finance experts, and technology innovators to discuss the latest trends in fiscal sustainability, governance transparency, and digital transformation.'
    ],
    [
    'question' => 'Who can attend FISC 2025?',
    'answer' => 'FISC 2025 is an exclusive event for delegates and official guests, including government officials, finance professionals, and technology innovators.'
    ],
    [
    'question' => 'Where will FISC 2025 be held?',
    'answer' => 'FISC 2025 will be held at the Timor-Leste Convention Centre in Dili, Timor-Leste.'
    ],
    [
    'question' => 'How does FISC contribute to global PFM practices?',
    'answer' => 'FISC plays a crucial role in shaping global PFM practices by facilitating knowledge exchange between countries, international organizations, and PFM experts. Discussions and recommendations from FISC often inform policy decisions, contribute to the development of international PFM standards, and guide the implementation of PFM reforms worldwide.'
    ],
    [
    'question' => 'What is the agenda for FISC 2025?',
    'answer' => 'The agenda includes keynote speeches, panel discussions, workshops, and networking sessions focused on public financial management, digital transformation, and governance transparency. A detailed schedule will be shared closer to the event.'
    ],
    [
    'question' => 'Are there any social or cultural events during FISC 2025?',
    'answer' => 'Yes, FISC 2025 will feature cultural events, networking dinners, and excursions to showcase the rich heritage of Timor-Leste. These events are designed to foster collaboration and provide a memorable experience for attendees.'
    ],
    ];
    @endphp

    <x-faqs
        title="Frequently Asked Questions"
        subtitle="Find answers to common questions about FISC 2025."
        bgClass=""
        :faqs="$faqItems" />

</main>

@endsection

@push('scripts')