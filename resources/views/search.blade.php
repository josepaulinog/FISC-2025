@extends('layouts.app')

@section('content')

{{-- Hero Section --}}
<section
  class="hero h-60 relative bg-gray-100 bg-cover bg-center bg-no-repeat"
  style="background-image: url('{{ asset('images/docs.jpeg') }}')">
  <div class="hero-overlay bg-black bg-opacity-50"></div>
  <div class="hero-content text-center text-neutral-content">
    <div class="max-w-xl">
      <h1 class="mb-5 text-5xl text-white">Search Results</h1>
      <p class="p-0 text-xl">
        @if($search_query)
        {{ $search_results['search_results_count'] }} results found for "{{ $search_query }}"
        @else
        {{ $search_results['search_results_count'] }} Search Results Found
        @endif
      </p>
    </div>
  </div>
</section>

<div class="container px-4">
  <div class="breadcrumbs text-sm mt-4">
    <ul>
      <li><a href="{{ home_url() }}">Home</a></li>
      <li>Research Results</li>
    </ul>
  </div>
</div>

<div class="drawer container mx-auto px-4 lg:drawer-open">
  <input id="my-drawer-2" type="checkbox" class="drawer-toggle" />
  <div class="drawer-content flex flex-col">
    <!-- Page content here -->
    <label for="my-drawer-2" class="btn btn-primary drawer-button text-white lg:hidden mb-4 ml-4 mt-4">
      Open drawer
    </label>
    <div class="mx-auto py-16 lg:px-8">
      <div class="flex flex-wrap justify-between mb-8">
        {{-- Search Results --}}
        <div class="w-full px-4">
          @if (count($search_results['search_results']) > 0)
          <div id="search-results-container" class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @foreach ($search_results['search_results'] as $result)
            @php
            $is_locked = App\Helpers\MaterialAccess::isLocked($result['id']);
            @endphp
            <div class="bg-base-100 rounded-lg shadow-md overflow-hidden transition duration-300 ease-in-out transform hover:-translate-y-1 hover:shadow-lg relative">
              @if($is_locked)
                <div class="absolute top-2 right-2 bg-base-100 rounded-full p-2 shadow-md">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                  </svg>
                </div>
              @endif
              <a href="{{ $result['link'] }}" class="block">
                <div class="h-2 bg-cover bg-center" style="background-color: {{ $result['category_color'] }};"></div>
              </a>
              <div class="p-4 py-6">
                <div class="text-sm mb-4">
                  @foreach ($result['categories'] as $category)
                  <span class="badge badge-outline">{{ $category['name'] }}</span>
                  @endforeach
                </div>
                <h3 class="text-xl font-semibold mb-4">
                  <a href="{{ $result['link'] }}" class="hover:text-primary dark:text-neutral-200">{{ html_entity_decode($result['title']) }}</a>
                </h3>
                <p class="mt-2 text-xs text-gray-500 dark:text-neutral-600">Published on {{ $result['date'] }}</p>
                @if($is_locked)
                  <button class="inline-block bg-gray-300 text-gray-600 font-bold py-2 px-4 rounded cursor-not-allowed mt-4" title="You don't have permission to access this content">Locked</button>
                @else
                  <a href="{{ $result['link'] }}" class="font-semibold text-primary dark:text-primary-dark hover:underline transition duration-300 mt-3 block">Read More <svg class="inline w-3.5 h-3.5 ms-1 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
            </svg></a>
                @endif
              </div>
            </div>
            @endforeach
          </div>

          {{-- Load More Button --}}
          <div id="load-more-container" class="text-center mt-8">
            @if ($search_results['pagination']['current'] < $search_results['pagination']['total'])
              <button id="load-more-button" class="btn btn-primary text-white" data-current-page="{{ $search_results['pagination']['current'] }}">
              Load More
              </button>
              @endif
              <div id="spinner" class="hidden mt-4">
                <span class="loading loading-spinner loading-lg"></span>
              </div>
          </div>
          @else
          {{-- Improved No Results Message --}}
          <div class="flex flex-col items-center justify-center py-16">

          <svg class="mb-6" width="62px" height="66px" viewBox="0 0 58 52" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <defs></defs>
                            <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g id="053---Notification" fill="#dedede" fill-rule="nonzero">
                                    <path d="M57.1211,40.0976 L36.3561,4.5463 C34.9629416,1.76003431 32.1151512,1.74736541e-05 29,1.74736542e-05 C25.8848488,1.74736542e-05 23.0370584,1.76003431 21.6439,4.5463 L0.8789,40.0976 C-0.395802115,42.6470592 -0.259560435,45.6747599 1.23896945,48.0994282 C2.73749933,50.5240964 5.38463021,51.9999796 8.235,52 L49.765,52 C52.6153698,51.9999796 55.2625007,50.5240964 56.7610306,48.0994282 C58.2595604,45.6747599 58.3958021,42.6470592 57.1211,40.0976 Z M29,47 C26.790861,47 25,45.209139 25,43 C25,40.790861 26.790861,39 29,39 C31.209139,39 33,40.790861 33,43 C33,45.209139 31.209139,47 29,47 Z M33,31 C33,33.209139 31.209139,35 29,35 C26.790861,35 25,33.209139 25,31 L25,12 C25,9.790861 26.790861,8 29,8 C31.209139,8 33,9.790861 33,12 L33,31 Z" id="Shape"></path>
                                </g>
                            </g>
            </svg> 

            <h2 class="text-2xl font-semibold text-gray-700 mb-4">No results found</h2>
            <p class="text-gray-500 mb-6">We couldn't find any results for "{{ $search_query }}". Please try again with different keywords.</p>
            <a href="{{ url()->previous() }}" class="btn btn-primary text-white">
              
              Go Back
            </a>
          </div>
          @endif
        </div>
      </div>
    </div>
  </div>
  
  <div class="drawer-side">
    <label for="my-drawer-2" aria-label="close sidebar" class="drawer-overlay"></label>
    <aside class="menu text-base-content min-h-full w-96 bg-base-100 p-0">
      <div class="border p-8 pt-8 rounded-box mt-8">
        <div class="flex justify-between items-center mb-4">
          <h3 class="text-xl font-semibold">Filters</h3>
          <button id="clear-all-filters" class="btn btn-sm normal-case form-with-loader">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
            Clear All
          </button>
        </div>
        <form id="filters-form" action="{{ get_home_url() }}" method="GET" class="form-with-loader space-y-4">
          <input type="hidden" name="post_type" value="material">
          <div class="form-control">
            <label class="input input-bordered flex items-center gap-2">
              <input type="text" id="search_query" name="s" value="{{ $search_query }}" class="grow" placeholder="Search">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 16 16"
                fill="currentColor"
                class="h-4 w-4 opacity-70">
                <path
                  fill-rule="evenodd"
                  d="M9.965 11.026a5 5 0 1 1 1.06-1.06l2.755 2.754a.75.75 0 1 1-1.06 1.06l-2.755-2.754ZM10.5 7a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Z"
                  clip-rule="evenodd" />
              </svg>
            </label>
          </div>
          
          <div class="form-control">
            <label class="label">
              <span class="label-text text-base">Content Type</span>
            </label>
            <label class="flex items-center space-x-2 mb-2">
              <input type="checkbox" id="all_content_types" name="content_type[]" class="checkbox border-gray-400 [--chkbg:#5db85b] [--chkfg:#fff]" value="all" 
                {{ $allContentTypesSelected ? 'checked' : '' }}>
              <span>All Content Types</span>
            </label>
            @foreach($allContentTypes as $type)
              @if($type !== 'all')
                <label class="flex items-center space-x-2 mb-2">
                  <input type="checkbox" name="content_type[]" class="checkbox border-gray-400 [--chkbg:#5db85b] [--chkfg:#fff] content-type-checkbox" value="{{ $type }}" 
                    {{ in_array($type, $selectedContentTypes) || $allContentTypesSelected ? 'checked' : '' }}>
                  <span>{{ $type }}</span>
                </label>
              @endif
            @endforeach
          </div>

          <div class="form-control">
            <label class="label">
              <span class="label-text text-base">Category</span>
            </label>
            <label class="flex items-center space-x-2 mb-2">
              <input type="checkbox" id="all_categories" name="material_category[]" class="checkbox border-gray-400 [--chkbg:#5db85b] [--chkfg:#fff]" value="all" 
                {{ $allCategoriesSelected ? 'checked' : '' }}>
              <span>All Categories</span>
            </label>
            @foreach($allCategories as $category)
              @if($category->slug !== 'all')
                <label class="flex items-center space-x-2 mb-2">
                  <input type="checkbox" name="material_category[]" class="checkbox border-gray-400 [--chkbg:#5db85b] [--chkfg:#fff] category-checkbox" value="{{ $category->slug }}" 
                    {{ in_array($category->slug, $selectedCategories) || $allCategoriesSelected ? 'checked' : '' }}>
                  <span>{{ $category->name }}</span>
                </label>
              @endif
            @endforeach
          </div>

          <div class="form-control">
            <label class="label">
              <span class="label-text text-base">Language</span>
            </label>
            <label class="flex items-center space-x-2 mb-2">
              <input type="checkbox" id="all_languages" name="material_language[]" class="checkbox border-gray-400 [--chkbg:#5db85b] [--chkfg:#fff]" value="all" 
                {{ $allLanguagesSelected ? 'checked' : '' }}>
              <span>All Languages</span>
            </label>
            @foreach($allLanguages as $language)
              @if($language->slug !== 'all')
                <label class="flex items-center space-x-2 mb-2">
                  <input type="checkbox" name="material_language[]" class="checkbox border-gray-400 [--chkbg:#5db85b] [--chkfg:#fff] language-checkbox" value="{{ $language->slug }}" 
                    {{ in_array($language->slug, $selectedLanguages) || $allLanguagesSelected ? 'checked' : '' }}>
                  <span>{{ $language->name }}</span>
                </label>
              @endif
            @endforeach
          </div>

          <div>
            <button type="submit" class="btn btn-primary w-full text-white">Apply Filters</button>
          </div>
        </form>
      </div>
    </aside>
  </div>
</div>

{{-- Haven't Found Section --}}
<section class="bg-base-200 py-16">
  <div class="container mx-auto text-center">
    <h2 class="text-3xl mb-6">Haven't found what you're looking for?</h2>
    <p class="text-lg mb-8">We're here to assist you. If you didn't find the information you were looking for, please feel free to contact us. Our team is ready to help!</p>
    <a href="/contact/" class="btn btn-primary text-white">Contact Us</a>
  </div>
</section>

@endsection