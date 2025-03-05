/**
 * Video Background Handler
 * 
 * This module handles video playback for both background videos and event videos
 * using native browser video APIs without depending on Video.js
 */

/**
 * Initialize YouTube API if needed
 */
function loadYouTubeAPI() {
  return new Promise((resolve) => {
    // Check if API is already loaded
    if (window.YT && window.YT.Player) {
      return resolve(window.YT);
    }
    
    // If not loaded and script is not added yet
    if (!document.querySelector('script[src="https://www.youtube.com/iframe_api"]')) {
      // Create script element
      const tag = document.createElement('script');
      tag.src = "https://www.youtube.com/iframe_api";
      
      // Set up callback for when API is ready
      window.onYouTubeIframeAPIReady = () => {
        resolve(window.YT);
      };
      
      // Add script to page
      const firstScriptTag = document.getElementsByTagName('script')[0];
      firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
    } else {
      // Script already added but not loaded yet, wait for onYouTubeIframeAPIReady
      window.onYouTubeIframeAPIReady = () => {
        resolve(window.YT);
      };
    }
  });
}

/**
 * Extracts YouTube video ID from various YouTube URL formats
 */
function extractYouTubeID(url) {
  if (!url) return null;
  
  // Handle youtu.be format
  if (url.includes('youtu.be/')) {
    const urlObj = new URL(url);
    return urlObj.pathname.split('/')[1];
  }
  
  // Handle youtube.com/watch format
  if (url.includes('youtube.com/watch')) {
    const urlObj = new URL(url);
    return urlObj.searchParams.get('v');
  }
  
  // Handle youtube.com/embed format
  if (url.includes('youtube.com/embed/')) {
    const urlObj = new URL(url);
    return urlObj.pathname.split('/')[2];
  }
  
  // If it's just the ID (11 characters)
  if (/^[a-zA-Z0-9_-]{11}$/.test(url)) {
    return url;
  }
  
  return null;
}

/**
 * Initialize YouTube Background Player
 */
async function initBackgroundYouTubePlayer(elementId, videoUrl) {
  const videoId = extractYouTubeID(videoUrl);
  if (!videoId) {
    console.error('Invalid YouTube URL or ID');
    return null;
  }
  
  try {
    // Load YouTube API
    const YT = await loadYouTubeAPI();
    
    const backgroundElement = document.getElementById(elementId);
    if (!backgroundElement) {
      console.error(`Element with ID "${elementId}" not found`);
      return null;
    }
    
    // Create player container if it doesn't exist
    let playerContainer = backgroundElement.querySelector('.youtube-container');
    if (!playerContainer) {
      playerContainer = document.createElement('div');
      playerContainer.className = 'youtube-container';
      playerContainer.style.position = 'absolute';
      playerContainer.style.top = '0';
      playerContainer.style.left = '0';
      playerContainer.style.width = '100%';
      playerContainer.style.height = '100%';
      playerContainer.style.overflow = 'hidden';
      
      // Create player div
      const playerDiv = document.createElement('div');
      playerDiv.id = `${elementId}-youtube-player`;
      playerContainer.appendChild(playerDiv);
      backgroundElement.appendChild(playerContainer);
    }
    
    // Initialize player
    const player = new YT.Player(`${elementId}-youtube-player`, {
      videoId: videoId,
      playerVars: {
        autoplay: 1,
        loop: 1,
        mute: 1,
        controls: 0,
        showinfo: 0,
        modestbranding: 1,
        rel: 0,
        iv_load_policy: 3,
        fs: 0,
        playsinline: 1,
        disablekb: 1,
        playlist: videoId // Required for looping
      },
      events: {
        'onReady': (event) => {
          event.target.mute();
          event.target.playVideo();
          
          // Ensure it fills the container
          updatePlayerSize(player, playerContainer);
        },
        'onStateChange': (event) => {
          // Restart video if it ends
          if (event.data === YT.PlayerState.ENDED) {
            player.playVideo();
          }
          
          // For some browsers, we need to re-mute on state change
          if (event.data === YT.PlayerState.PLAYING) {
            event.target.mute();
          }
        }
      }
    });
    
    // Update size when window resizes
    window.addEventListener('resize', () => updatePlayerSize(player, playerContainer));
    
    console.log('✅ Background YouTube video initialized!');
    return player;
  } catch (error) {
    console.error('Error initializing YouTube player:', error);
    return null;
  }
}

/**
 * Update YouTube player size to ensure it covers the container
 */
function updatePlayerSize(player, container) {
  if (!player || !player.getIframe || !container) return;
  
  const iframe = player.getIframe();
  if (!iframe) return;
  
  // Get container dimensions
  const containerWidth = container.offsetWidth;
  const containerHeight = container.offsetHeight;
  
  // YouTube's aspect ratio is 16:9
  const videoRatio = 16/9;
  const containerRatio = containerWidth/containerHeight;
  
  let newWidth, newHeight;
  
  if (containerRatio > videoRatio) {
    // Container is wider than the video's aspect ratio
    newWidth = containerWidth * 1.2;
    newHeight = newWidth / videoRatio;
  } else {
    // Container is taller than the video's aspect ratio
    newHeight = containerHeight * 1.2;
    newWidth = newHeight * videoRatio;
  }
  
  // Position the iframe in the center
  iframe.style.position = 'absolute';
  iframe.style.top = '50%';
  iframe.style.left = '50%';
  iframe.style.width = `${newWidth}px`;
  iframe.style.height = `${newHeight}px`;
  iframe.style.transform = 'translate(-50%, -50%)';
  iframe.style.pointerEvents = 'none'; // Prevent interaction
}

/**
 * Initialize native HTML5 video element for background
 */
function initNativeBackgroundVideo(elementId, videoUrl) {
  const element = document.getElementById(elementId);
  if (!element) {
    console.error(`Element with ID "${elementId}" not found`);
    return null;
  }
  
  // Create video element if it doesn't exist
  let videoElement = element.querySelector('video');
  if (!videoElement) {
    videoElement = document.createElement('video');
    videoElement.className = 'background-video';
    videoElement.style.position = 'absolute';
    videoElement.style.width = '100%';
    videoElement.style.height = '100%';
    videoElement.style.objectFit = 'cover';
    videoElement.style.top = '0';
    videoElement.style.left = '0';
    
    element.appendChild(videoElement);
  }
  
  // Set video attributes
  videoElement.autoplay = true;
  videoElement.loop = true;
  videoElement.muted = true;
  videoElement.playsInline = true;
  videoElement.setAttribute('playsinline', '');
  videoElement.controls = false;
  
  // Set source if different from current
  if (videoElement.src !== videoUrl) {
    videoElement.src = videoUrl;
  }
  
  // Handle errors
  videoElement.addEventListener('error', (e) => {
    console.error('Video error:', e);
  });
  
  // Make sure it plays
  videoElement.play().catch(error => {
    console.error('Error playing video:', error);
  });
  
  console.log('✅ Native background video initialized!');
  return videoElement;
}

/**
 * Initialize event video player (non-background)
 */
async function initEventVideo(elementId, videoUrl, posterUrl = null) {
  const element = document.getElementById(elementId);
  if (!element) {
    console.error(`Element with ID "${elementId}" not found`);
    return null;
  }
  
  // Check if it's a YouTube URL
  const youtubeId = extractYouTubeID(videoUrl);
  
  if (youtubeId) {
    // Handle YouTube video
    try {
      // Load YouTube API
      const YT = await loadYouTubeAPI();
      
      // Create container with proper aspect ratio
      const container = document.createElement('div');
      container.className = 'aspect-video aspect-video relative border rounded-lg shadow-md overflow-hidden relative';
      
      // If poster is provided, create a poster with play button
      if (posterUrl) {
        const poster = document.createElement('div');
        poster.className = 'youtube-poster absolute inset-0 bg-cover bg-center flex items-center justify-center cursor-pointer';
        poster.style.backgroundImage = `url('${posterUrl}')`;
        
        // Add play button
        const playButton = document.createElement('div');
        playButton.className = 'play-button w-16 h-16 md:w-24 md:h-24 rounded-full bg-primary/80 flex items-center justify-center transition-transform hover:scale-110';
        playButton.innerHTML = `
          <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" viewBox="0 0 24 24" fill="currentColor">
            <path d="M8 5v14l11-7z"/>
          </svg>
        `;
        
        poster.appendChild(playButton);
        container.appendChild(poster);
        
        // Create hidden player div
        const playerDiv = document.createElement('div');
        playerDiv.id = `${elementId}-youtube-player`;
        playerDiv.className = 'hidden w-full h-full';
        container.appendChild(playerDiv);
        
        // Replace the original element
        element.parentNode.replaceChild(container, element);
        
        // Set up click handler to initialize player when clicked
        poster.addEventListener('click', () => {
          poster.classList.add('hidden');
          playerDiv.classList.remove('hidden');
          
          // Initialize player
          new YT.Player(playerDiv.id, {
            videoId: youtubeId,
            playerVars: {
              autoplay: 1,
              modestbranding: 1,
              rel: 0,
              showinfo: 0,
              controls: 1,
              playsinline: 1
            }
          });
        });
      } else {
        // No poster, create player immediately
        const playerDiv = document.createElement('div');
        playerDiv.id = `${elementId}-youtube-player`;
        container.appendChild(playerDiv);
        
        // Replace the original element
        element.parentNode.replaceChild(container, element);
        
        // Initialize player
        new YT.Player(playerDiv.id, {
          videoId: youtubeId,
          playerVars: {
            modestbranding: 1,
            rel: 0,
            showinfo: 0,
            controls: 1,
            playsinline: 1
          }
        });
      }
      
      console.log('✅ Event YouTube video initialized!');
    } catch (error) {
      console.error('Error initializing YouTube player:', error);
    }
  } else {
    // Handle native HTML5 video
    // Create container with proper aspect ratio
    const container = document.createElement('div');
    container.className = 'aspect-video aspect-video relative border rounded-lg shadow-md overflow-hidden';
    
    // Create video element
    const video = document.createElement('video');
    video.className = 'rounded-lg w-full h-full object-cover';
    video.controls = true;
    video.playsInline = true;
    video.setAttribute('playsinline', '');
    
    // Add poster if provided
    if (posterUrl) {
      video.poster = posterUrl;
    }
    
    // Add source
    const source = document.createElement('source');
    source.src = videoUrl;
    source.type = 'video/mp4';
    video.appendChild(source);
    
    // Add fallback text
    video.appendChild(document.createTextNode('Your browser does not support the video tag.'));
    
    // Add to container
    container.appendChild(video);
    
    // Replace the original element
    element.parentNode.replaceChild(container, element);
    
    console.log('✅ Native event video initialized!');
  }
}

/**
 * Initialize various video elements in the page
 */
export async function setupVideoBackground() {
  try {
    // Handle background video (if exists)
    const backgroundVideoElement = document.getElementById('background-video');
    if (backgroundVideoElement) {
      const videoUrl = backgroundVideoElement.getAttribute('data-src') || backgroundVideoElement.getAttribute('src');
      
      if (videoUrl) {
        if (extractYouTubeID(videoUrl)) {
          // YouTube background
          await initBackgroundYouTubePlayer('background-video', videoUrl);
        } else {
          // Native video background
          initNativeBackgroundVideo('background-video', videoUrl);
        }
      }
    }
    
    // Handle event video (if exists)
    const eventVideoElement = document.getElementById('event-video');
    if (eventVideoElement) {
      const videoSrc = eventVideoElement.getAttribute('data-src');
      const posterUrl = eventVideoElement.getAttribute('poster');
      
      if (videoSrc) {
        await initEventVideo('event-video', videoSrc, posterUrl);
      } else {
        console.log('No video source specified for event video');
      }
    }
  } catch (error) {
    console.error('Error setting up videos:', error);
  }
}

// Initialize when the DOM is fully loaded
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', () => {
    setupVideoBackground().catch(error => {
      console.error('Failed to initialize video:', error);
    });
  });
} else {
  // DOM already loaded, run immediately
  setupVideoBackground().catch(error => {
    console.error('Failed to initialize video:', error);
  });
}