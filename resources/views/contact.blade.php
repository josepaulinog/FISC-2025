{{--
  Template Name: Contact Template
--}}

@extends('layouts.app')

@section('content')
    @while(have_posts()) @php(the_post())
        <section class="py-20 bg-base-200">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="shadow-xl card card-side bg-base-100 grid lg:grid-cols-2 grid-cols-1">
                    
                    <figure class="lg:mb-0 mb-10">
                        <div class="group w-full h-full">
                            <div class="relative h-full">
                                <img src="https://freebalance.com/wp-content/uploads/2022/03/modal-popup.jpeg" alt="ContactUs tailwind section" class="w-full h-full  bg-blend-multiply bg-orange-700 object-cover" />
                                
                                <h1 class="hidden font-manrope text-white text-4xl leading-10 absolute top-11 left-11">Contact us</h1>
                            </div>
                        </div>
                    </figure>

                    <div class="card-body px-16 py-16">
                        @if($formTitle)
                            <h2 class="font-manrope text-4xl leading-10 mb-4">
                                {!! $formTitle !!}
                            </h2>
                        @endif

                        @if($formDescription)
                            <p class="mb-4 opacity-60">
                                {!! $formDescription !!}
                            </p>
                        @endif
                        
                        @php(the_content())
                    </div>
                </div>
        </section>
    @endwhile
@endsection