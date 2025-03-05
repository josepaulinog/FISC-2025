<div class="drawer-side z-50">
  <!-- Overlay: Clicking this should also toggle the checkbox -->
  <label for="my-drawer" aria-label="close sidebar" class="drawer-overlay cursor-pointer"></label>
  
  <div class="menu p-4 w-80 min-h-full bg-base-100 text-base-content pt-20 relative">
    <!-- Close Button: Changed end-2.5 to right-2.5 and added cursor-pointer -->
    <label for="my-drawer" aria-label="close sidebar" class="cursor-pointer text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-10 h-10 absolute top-2.5 right-2.5 inline-flex items-center justify-center dark:hover:bg-gray-600 dark:hover:text-white">
      <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"></path>
      </svg>
      <span class="sr-only">Close menu</span>
    </label>
    
    <div class="mb-8">
      <a href="{{ home_url('/') }}" class="text-xl font-normal">
          <x-logo class="h-12 fill-current font-normal" />
      </a>
    </div>
    
    {!! $mobileNavigation !!}
  </div>
</div>
