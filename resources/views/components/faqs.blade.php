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
<section class="py-16 {{ $bgClass }}">
  <div class="container mx-auto px-4">
    <div class="text-center mb-8">
      <h2 class="text-3xl mb-4 dark:text-white-500">{{ $title }}</h2>
      <div class="w-16 h-1 rounded-full bg-primary mx-auto mb-4 inline-flex"></div>
      <p class="text-lg max-w-2xl mx-auto text-neutral-600 dark:text-neutral-400">
        {{ $subtitle }}
      </p>
    </div>
    <div class="max-w-3xl mx-auto">
      
    </div>
  </div>
</section>
