@if(is_user_logged_in())
    {{-- Hero for Logged-in Users --}}
    <x-hero-image 
        title="FISC 2025: The Digital Transformation of Public Financial Management" 
        subtitle="April 7-10, 2025 | Dili, Timor-Leste"
        primaryButtonText="View Agenda"
        primaryButtonUrl="/agenda"
    >
    </x-hero-image>
@else
    {{-- Hero for Guests (Not Logged-in Users) --}}
    <x-hero-image 
        title="FISC 2025: The Digital Transformation of Public Financial Management" 
        subtitle="April 7-10, 2025 | Dili, Timor-Leste"
        primaryButtonText="Login"
        primaryButtonUrl="/login"
    >
    </x-hero-image>
@endif


@if (!is_front_page())
  <div class="container mx-auto px-4 py-4 hidden">
    @php
      $home_url = home_url('/');
      $current_title = wp_get_document_title();
    @endphp
    <nav class="text-sm" aria-label="Breadcrumb">
      <ol class="list-none p-0 inline-flex">
        <li class="flex items-center">
          <a href="{{ $home_url }}" class="text-blue-600 hover:text-blue-800">Home</a>
          <svg width="20" class="fill-current w-3 h-3 mx-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
            <path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z" />
          </svg>
        </li>
        <li>
          <span class="text-gray-500" aria-current="page">{{ $current_title }}</span>
        </li>
      </ol>
    </nav>
  </div>
@endif