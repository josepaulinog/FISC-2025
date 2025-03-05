@extends('layouts.app')

@section('content')
  @while(have_posts()) @php(the_post())
    @include("partials.headers.{$header_template}")

    @if (request()->is('submit-an-opportunity') && \App\Helpers\OpportunityAccess::isLocked())
        @include('components.locked-content-overlay', ['message' => 'You do not have access to the Submit an Oportunity page.', 'class' => 'bg-base-gray'])
    @else
        {{-- Continue displaying the opportunity content --}}
        <div class="mx-auto">
          @includeFirst(['partials.content.content-page', 'partials.content.content-single'])
        </div>
    @endif
  @endwhile
@endsection