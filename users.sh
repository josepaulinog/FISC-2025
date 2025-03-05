#!/bin/bash

# Define the events in an array (each event has start date, end date, and title)
events=(
  # Monday, April 7
  "2025-04-07 08:45:00|2025-04-07 09:00:00|Opening Remarks"
  "2025-04-07 09:00:00|2025-04-07 10:30:00|Session: Fiscal Transparency in Public Finance Management"
  "2025-04-07 10:30:00|2025-04-07 11:00:00|Break"
  "2025-04-07 11:00:00|2025-04-07 13:00:00|Session: Digital Transformation in Government Finance Systems"
  "2025-04-07 13:00:00|2025-04-07 14:00:00|Lunch"
  "2025-04-07 14:00:00|2025-04-07 16:45:00|Session: Case Study - Timor-Leste's Journey to Sustainable Development"
  "2025-04-07 16:45:00|2025-04-07 17:00:00|Closing Remarks"
  "2025-04-07 19:00:00|2025-04-07 22:00:00|Opening Reception & Dinner"

  # Tuesday, April 8
  "2025-04-08 08:45:00|2025-04-08 09:00:00|Opening Remarks"
  "2025-04-08 09:00:00|2025-04-08 10:30:00|Session: Strengthening Governance through Accountability"
  "2025-04-08 10:30:00|2025-04-08 11:00:00|Break"
  "2025-04-08 11:00:00|2025-04-08 11:15:00|Group Photo"
  "2025-04-08 11:15:00|2025-04-08 13:00:00|Session: Collaborative Approaches to Economic Growth"
  "2025-04-08 13:00:00|2025-04-08 14:00:00|Lunch"
  "2025-04-08 14:00:00|2025-04-08 16:45:00|Session: Leveraging Technology for Financial Inclusion"
  "2025-04-08 16:45:00|2025-04-08 17:00:00|Closing Remarks"
  "2025-04-08 19:00:00|2025-04-08 22:00:00|Dinner & Event"

  # Wednesday, April 9
  "2025-04-09 08:45:00|2025-04-09 09:00:00|Opening Remarks"
  "2025-04-09 09:00:00|2025-04-09 10:30:00|Session: Lessons Learned from Global PFM Reforms"
  "2025-04-09 10:30:00|2025-04-09 11:00:00|Break"
  "2025-04-09 11:00:00|2025-04-09 16:00:00|Lunch & Cultural Excursion (Exploring Timor-Leste's Heritage)"
  "2025-04-09 16:00:00|2025-04-09 16:45:00|Session: Reflections on the Day's Activities"
  "2025-04-09 16:45:00|2025-04-09 17:00:00|Closing Remarks"
  "2025-04-09 19:00:00|2025-04-09 22:00:00|Dinner & Event"

  # Thursday, April 10
  "2025-04-10 08:45:00|2025-04-10 09:00:00|Opening Remarks"
  "2025-04-10 09:00:00|2025-04-10 10:30:00|Session: Future Directions for Public Finance Management"
  "2025-04-10 10:30:00|2025-04-10 11:00:00|Break"
  "2025-04-10 11:00:00|2025-04-10 13:00:00|Session: Closing Keynote Address by Hon. Santina José Rodrigues F. Viegas Cardoso, Minister of Finance, Timor-Leste"
  "2025-04-10 13:00:00|2025-04-10 14:00:00|Lunch"
  "2025-04-10 14:00:00|2025-04-10 16:45:00|Session: Final Discussions and Recommendations"
  "2025-04-10 16:45:00|2025-04-10 17:00:00|Closing Remarks"
  "2025-04-10 19:00:00|2025-04-10 22:00:00|Closing Reception & Dinner"
)

# Iterate over each event and create it using WP-CLI and the Events Calendar ORM API
for event in "${events[@]}"; do
  IFS='|' read -r start_date end_date title <<< "$event"
  
  # Escape any single quotes in the title
  title_escaped=$(printf '%s' "$title" | sed "s/'/\\\'/g")
  
  # Extract the event day from start_date to use as a tag
  day_tag=$(echo "$start_date" | cut -d ' ' -f 1)
  
  # Create a short title (max 12 characters) for the featured image text
  short_title="${title:0:12}"
  # Replace spaces with '+' for the image text URL parameter
  short_title_url=$(echo "$short_title" | sed 's/ /+/g')
  
  # Define a long, detailed description for the event
  description="This event, titled \"$title_escaped\", presents a unique opportunity to explore topics of significant relevance in today’s dynamic landscape. Throughout the session, participants will deeply analyze challenges and opportunities in both public and private management, fostering a debate-rich environment conducive to reflection and collaboration. The agenda is carefully structured with keynote presentations, roundtable discussions, and interactive sessions that encourage the exchange of ideas and experiences. It is anticipated that the day will catalyze the development of innovative proposals and strengthen collaborative networks across various sectors."
  
  # Additional event details
  organizer="FreeBalance"
  # IMPORTANT: Instead of a venue name, pass the venue ID. Here we use 253 as the venue ID.
  venue=253
  location="Timor Leste"
  
  # Create the event using wp eval and the Events Calendar ORM API, including all event details and a tag for the day
  event_id=$(wp eval "
    \$args = [
      'title'       => '$title_escaped',
      'start_date'  => '$start_date',
      'end_date'    => '$end_date',
      'description' => '$description',
      'status'      => 'publish',
      'tag'         => array(\"$day_tag\"),
      'organizer'   => '$organizer',
      'venue'       => $venue,
      'location'    => '$location'
    ];
    \$result = tribe_events()->set_args(\$args)->create();
    if ( is_wp_error(\$result) ) {
      echo '0';
    } else {
      echo \$result;
    }
  ")
  
  if [ "$event_id" -eq "0" ]; then
    echo "Error creating event: $title"
  else
    echo "Created event with ID: $event_id"
    
    # Prepare the featured image URL using the placeholder service
    image_url="https://placehold.co/600x400?text=$short_title_url"
    
    # Download (save) the image locally to a temporary file
    tmp_image="/tmp/featured_${short_title_url}.jpg"
    curl -s -o "$tmp_image" "$image_url"
    
    # Import the saved image as the featured image for the event using WP-CLI
    attachment_id=$(wp media import "$tmp_image" --post_id=$event_id --porcelain)
    
    # Remove the temporary image file
    rm "$tmp_image"
    
    if [ -n "$attachment_id" ]; then
      # Set the imported image as the featured image (thumbnail) for the event
      wp post meta update $event_id _thumbnail_id $attachment_id
      echo "Assigned featured image (ID: $attachment_id) to event: $title"
    else
      echo "Failed to import featured image for event: $title"
    fi
  fi
  
  echo "Processed event: $title"
done

echo "All events have been created."
