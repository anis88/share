var embedSoundcloud = function (client_id, sc_track_url) {
	SC.initialize({
	  client_id: client_id
	});
	
	var track_url = 'http://soundcloud.com/forss/flickermood';
	SC.oEmbed(sc_track_url, { auto_play: false }, function(oEmbed) {
		$('SoundcloudPlayer').set('html', oEmbed.html);
	});	
};