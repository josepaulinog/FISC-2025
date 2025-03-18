<div class="hero h-60 relative" style="background-image: url('{{ get_the_post_thumbnail_url(get_the_ID(), 'full') }}');">
  <div class="hero-overlay bg-black bg-opacity-40"></div>
  <div class="hero-content text-center text-neutral-content">
    <div>
      <h1 class="mb-5 text-5xl text-white">{!! $title !!}</h1>
      @php
        $subheading = get_field('subheading');
        $term_description = term_description(); // Fetch term description if available
      @endphp
      @if($subheading)
        <p class="mb-5 text-xl text-white">{{ $subheading }}</p>
      @endif

      {{-- Check if it's a taxonomy page and display term description --}}
      @if (is_category() || is_tag())
        @if($term_description)
          <p class="mb-5">{{ $term_description }}</p>
        @endif
      @elseif (has_excerpt())
        <p class="mb-5">{{ get_the_excerpt() }}</p>
      @endif
    </div>
  </div>
</div>
