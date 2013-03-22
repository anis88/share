<section class="Playlist row">
	
	<section class="columns large-12">
		<h1><%t Title.playlist "your playlist" %></h1>
	</section>
	
	<section class="columns large-8">
		<div class="player-wrapper">
			<%-- the <iframe> (and video player) will replace this <div> tag --%>
			<div id="Player"></div>
		</div>
		<div class="post-info"></div>
	</section>
	<section class="columns large-4 video-list">
		<h3>Videos</h3>
		<% loop Likes %>
			<a href="#$YouTubeID" data-postId="$ID" data-youtubeId="$YouTubeID">$Title</a>	
		<% end_loop %>
	</section>
</section>

<script>
	// this code loads the IFrame Player API code asynchronously.
	var tag = document.createElement('script');
	tag.src = "//www.youtube.com/iframe_api";
	var firstScriptTag = document.getElementsByTagName('script')[0];
	firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

	// this function creates an <iframe> (and YouTube player) after the API code downloads.
	var player;
	function onYouTubeIframeAPIReady() {
		playVideo('<% control Likes.First %>$YoutubeID<% end_control %>');
	}
	
	function playVideo(id) {
		if (window.location.hash) {
			id = window.location.hash.substr(1);
		}
		//YouTubePlayer.youtubeId = id;
		
		player = new YT.Player('Player', {
			height: '390',
			width: '100%',
			videoId: id,
			events: {
				'onReady': onPlayerReady,
				'onStateChange': onPlayerStateChange
			}
		});
	}

	// the API will call this function when the video player is ready.
	function onPlayerReady(event) {
		event.target.playVideo();
    }

	// the API calls this function when the player's state changes.
	function onPlayerStateChange(event) {
		// play next when the video has ended
        if (player.getPlayerState() === 0) {
			YouTubePlayer.next();
        }
	}
	
	// init Playlist functions
	$(document).ready(function  () {
		YouTubePlayer.init();
	});
</script>