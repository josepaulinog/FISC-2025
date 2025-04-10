@props([
    // Section title.
    'title' => 'Frequently Asked Questions',
    // Section subtitle.
    'subtitle' => 'Find answers to common questions about FISC 2025.',
    // Background class for the section.
    'bgClass' => 'bg-base-200',
    // Array of FAQs. Each FAQ should have 'question' and 'answer' keys.
    'faqs' => []
])

<style>
/* Override the problematic transition in collapse-title */
.custom-collapse-title {
  position: relative;
  min-height: 3.75rem;
  padding: 1rem 3rem 1rem 1rem;
  font-size: 1.25rem;
  line-height: 1.75rem;
  font-weight: 500;
  cursor: pointer;
  grid-column-start: 1;
  grid-row-start: 1;
}
</style>

<section class="py-16 {{ $bgClass }}">
  <div class="container mx-auto px-4">
    <div class="text-center mb-8">
      <h2 class="text-3xl mb-4 dark:text-white-500">{{ $title }}</h2>
      <div class="w-16 h-1 rounded-full bg-primary mx-auto mb-4 inline-flex"></div>
      <p class="max-w-2xl mx-auto text-neutral-600 dark:text-neutral-400">
        {{ $subtitle }}
      </p>
    </div>
    <div class="max-w-3xl mx-auto">
      @foreach($faqs as $faq)
        <div class="collapse collapse-arrow shadow-lg mb-4 rounded-md p-2 border bg-white dark:bg-black/25">
          <input type="checkbox" @if($loop->first) checked @endif />
          <div class="custom-collapse-title text-xl text-gray-800 dark:text-white">
            {{ $faq['question'] }}
          </div>
          <div class="collapse-content text-gray-600 dark:text-white/75">
            <p>{{ $faq['answer'] }}</p>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>