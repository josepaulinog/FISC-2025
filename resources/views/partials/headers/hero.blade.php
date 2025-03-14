<!-- Hero -->
<div class="relative overflow-hidden bg-base-200">
    <div class="mx-auto max-w-screen-md py-12 px-4 sm:px-6 md:max-w-screen-xl md:py-20 lg:py-32 md:px-8">
        <div class="md:pe-8 md:w-1/2 xl:pe-0 xl:w-5/12">
            <!-- Title -->
            <h1 class="text-3xl text-base-content md:text-4xl md:leading-tight lg:text-5xl lg:leading-tight">
                {!! $title !!}
            </h1>
            @php
            $subheading = get_field('subheading');
            @endphp
            @if($subheading)
            <p class="mt-3 text-neutral-600 dark:text-neutral-400">{{ $subheading }}</p>
            @endif
            <!-- End Title -->
        </div>
    </div>

    <div style="background-image: url('{{ get_the_post_thumbnail_url(get_the_ID(), 'full') }}');" class="hidden md:block md:absolute md:top-0 md:start-1/2 md:end-0 h-full bg-no-repeat bg-center bg-cover">

    </div>
    <!-- End Col -->
</div>
<!-- End Hero -->


<style>

.duotone-orange::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(
        to bottom right,
        rgba(243, 108, 36, 0.7),  /* Orange */
        rgba(0, 0, 0, 0.2)       /* Dark base */
    );
    mix-blend-mode: multiply;
}

.duotone-orange::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(
        to bottom right,
        rgba(255, 170, 0, 0.4),  /* Light orange */
        rgba(255, 68, 0, 0.4)    /* Deep orange */
    );
    mix-blend-mode: screen;
}
</style>