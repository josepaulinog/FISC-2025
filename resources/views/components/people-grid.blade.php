@props([
    'userType' => 'attendee', 
    'users' => null,
    'postType' => null, // Keeping for backward compatibility
    'posts' => null, // Keeping for backward compatibility
    'showSocial' => true,
    'showContact' => true,
    'showAdditionalInfo' => false,
    'title' => null,
    'description' => null,
    'bgClass' => 'bg-base-100',
    'showCTA' => false,
    'ctaLink' => '#',
    'ctaText' => 'View All'
])

<section class="{{ $bgClass }} py-16">
  <div class="container mx-auto px-4">
    @if($title || $description)
      <div class="text-center mb-12">
        @if($title)
          <h2 class="text-3xl text-gray-800 dark:text-white mb-4">{{ $title }}</h2>
          <div class="w-16 h-1 rounded-full bg-primary mx-auto mb-4 inline-flex"></div>
        @endif
        
        @if($description)
          <p class="max-w-2xl mx-auto text-gray-600 dark:text-gray-300">
            {{ $description }}
          </p>
        @endif
      </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
      @if(isset($users) && count($users) > 0)
        @foreach($users as $person)
          @php
            // Get user metadata
            $job_title = get_user_meta($person->ID, 'job_title', true);
            $organization = get_user_meta($person->ID, 'company', true);
            $country = get_user_meta($person->ID, 'country', true);
            $email = $person->user_email;
            $phone = get_user_meta($person->ID, 'phone', true);
            $linkedin = get_user_meta($person->ID, 'linkedin', true);
            $twitter = get_user_meta($person->ID, 'twitter', true);
            $website = get_user_meta($person->ID, 'website', true);
            $bio = get_user_meta($person->ID, 'description', true);
            $avatar = get_user_meta($person->ID, 'profile_avatar', true) ?: get_avatar_url($person->ID);
            
            // Additional attendee specific fields
            $arrival_date = get_user_meta($person->ID, 'arrival_date', true);
            $hotel_name = get_user_meta($person->ID, 'hotel_name', true);
            $visa_required = get_user_meta($person->ID, 'visa_required', true);
            $dietary_restrictions = get_user_meta($person->ID, 'dietary_restrictions', true);
            $accessibility_requirements = get_user_meta($person->ID, 'accessibility_requirements', true);
          @endphp
          
          <x-person-card 
            :user="$person"
            :userType="$userType"
            :job_title="$job_title"
            :organization="$organization"
            :country="$country"
            :email="$email"
            :phone="$phone"
            :linkedin="$linkedin"
            :twitter="$twitter"
            :website="$website"
            :bio="$bio"
            :avatar="$avatar"
            :arrival_date="$arrival_date"
            :hotel_name="$hotel_name"
            :visa_required="$visa_required"
            :dietary_restrictions="$dietary_restrictions"
            :accessibility_requirements="$accessibility_requirements"
            :showSocial="$showSocial"
            :showContact="$showContact"
            :showAdditionalInfo="$showAdditionalInfo"
          />
        @endforeach
      @elseif(isset($posts) && count($posts) > 0)
        {{-- Backward compatibility with post type --}}
        @foreach($posts as $person)
          @php
            // Original post meta processing
            $job_title = null;
            $organization = null;
            $country = null;
            $email = null;
            $phone = null;
            $linkedin = null;
            $twitter = null;
            
            // Attendee specific fields
            $fullName = null;
            $arrival_date = null;
            $hotel_name = null;
            $visa_required = null;
            $dietary_restrictions = null;
            $accessibility_requirements = null;
            
            if($postType === 'speaker') {
              $job_title = get_post_meta($person->ID, '_tribe_ext_speaker_job_title', true);
              $organization = get_post_meta($person->ID, '_tribe_ext_speaker_organization', true);
              $country = get_post_meta($person->ID, '_tribe_ext_speaker_country', true);
              $email = get_post_meta($person->ID, '_tribe_ext_speaker_email_address', true);
              $phone = get_post_meta($person->ID, '_tribe_ext_speaker_phone', true);
              $linkedin = get_post_meta($person->ID, '_tribe_ext_speaker_linkedin', true);
              $twitter = get_post_meta($person->ID, '_tribe_ext_speaker_twitter', true);
            } elseif($postType === 'attendee') {
              $fullName = get_field('full_name', $person->ID);
              $job_title = get_field('job_title', $person->ID);
              $organization = get_field('organization', $person->ID);
              $country = get_field('country', $person->ID);
              $email = get_field('email_address', $person->ID);
              $phone = get_field('phone_number', $person->ID);
              $arrival_date = get_field('arrival_date', $person->ID);
              $hotel_name = get_field('hotel_name', $person->ID);
              $visa_required = get_field('visa_required', $person->ID);
              $dietary_restrictions = get_field('dietary_restrictions', $person->ID);
              $accessibility_requirements = get_field('accessibility_requirements', $person->ID);
            }
          @endphp
          
          <x-person-card 
            :person="$person"
            :postType="$postType"
            :job_title="$job_title"
            :organization="$organization"
            :country="$country"
            :email="$email"
            :phone="$phone"
            :linkedin="$linkedin"
            :twitter="$twitter"
            :fullName="$fullName"
            :arrival_date="$arrival_date"
            :hotel_name="$hotel_name"
            :visa_required="$visa_required"
            :dietary_restrictions="$dietary_restrictions"
            :accessibility_requirements="$accessibility_requirements"
            :showSocial="$showSocial"
            :showContact="$showContact"
            :showAdditionalInfo="$showAdditionalInfo"
          />
        @endforeach
      @else
        <p class="text-center col-span-full text-gray-600">No {{ $userType ?? $postType }}s found.</p>
      @endif
    </div>

    @if($showCTA)
      <div class="text-center mt-8">
        <a class="btn btn-primary px-8 text-white" href="{{ $ctaLink }}">{{ $ctaText }}</a>
      </div>
    @endif
  </div>
</section>