// JavaScript code
(function () {
  // Create a script element to load the YouTube Iframe API
  const tag = document.createElement("script");
  tag.src = "https://www.youtube.com/iframe_api";
  const firstScriptTag = document.getElementsByTagName("script")[0];
  firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

  // Function to extract video ID from YouTube URL
  function getVideoIdFromUrl(url) {
    const videoIdMatch = url.match(
      /(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/
    );
    if (videoIdMatch && videoIdMatch[1]) {
      return videoIdMatch[1];
    }
    return null;
  }

  // Initialize the YouTube player when the API is ready
  window.onYouTubeIframeAPIReady = function () {
    const embedContainer = document.querySelector(
      ".ql-youtube-embed .ql-youtube-embed-container"
    );
    const youtubeUrl = embedContainer.dataset.youtubeUrl;
    const videoId = getVideoIdFromUrl(youtubeUrl);
    console.log(videoId);

    if (videoId) {
      // Create a new YouTube player instance
      const player = new YT.Player("youtube-player", {
        videoId: videoId,
        events: {
          onReady: onPlayerReady,
        },
      });
    } else {
      console.error("Invalid YouTube URL provided.");
    }
  };

  // Function to initialize custom controls
  function onPlayerReady(event) {
    const player = event.target;

    // Add custom play button functionality
    const playButton = document.getElementById("custom-play-button");
    playButton.addEventListener("click", function () {
      player.playVideo();
    });
  }
})();
