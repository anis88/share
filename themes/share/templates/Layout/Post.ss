<section class="post row">
	
	<section class="columns twelve">
		
		<h1>$Post.Title</h1>
		
		<p><% if Post.Genre.Title %>$Post.Genre.Title &ndash; <% end_if %><%t Content.PostedOn "posted on" %> $Post.Created.Format(d/m/y) <%t Content.By "by" %> <a href="/posts/user/$Post.Member.FirstName">$Post.Member.FirstName</a></p>
	
		<section class="post-content">
			$Post.Content
		</section>
	
		<% if Post.hasYouTubeID %>
			<iframe width="560" height="315" src="http://www.youtube.com/embed/$Post.YouTubeID" frameborder="0" allowfullscreen></iframe>
		<% end_if %>
		
		<% if $SoundcloudClientID && Post.hasSoundcloudLink %>
			<div id="SoundcloudPlayer"></div>
			<script src="http://connect.soundcloud.com/sdk.js"></script>
			<script>					
				embedSoundcloud('$SoundcloudClientID', '$Post.Link');
			</script>
		<% end_if %>
		
		<% if Post.Likes %>
			<p>
				<% if Post.hasLiked %>
					<%t Content.You "You" %>
					<% if Post.Likes.Count = 1 %><% else %>, <% end_if %>
				<% end_if %>				
				<% loop Post.getLikes %>
					<% if not First && Last %><%t Content.And "and" %><% end_if %>
					<% if not First && not Last %>, <% end_if %>
					<a href="/share/user/$FirstName">$FirstName</a>
				<% end_loop %>
				<% if Post.Likes.Count = 1 %>
					<% if Post.hasLiked %>
						<%t Content.LikeThis "like this" %>
					<% else %>
						<%t Content.LikeThisSingular "likes this" %>
					<% end_if %>
				<% else %>
					<%t Content.LikeThis "like this" %>
				<% end_if %>
			</p>
		<% end_if %>
		
		<% if Post.hasLiked %>
			<a href="/post/unlike/$Post.ID" class="button like xhr">Unlike</a>
		<% else %>
			<a href="<% if CurrentMember %>/post/like/$Post.ID<% else %>/Security/login?BackURL=/view/post/$Post.ID<% end_if %>" class="button like<% if CurrentMember %> xhr<% end_if %>">Like</a>				
		<% end_if %>
		
		<% if Post.File %>
			<!-- check for mp3 support
			<audio controls autobuffer>
				<source src="$Post.File.Link">
			</audio>
			-->
			<a href="/download/file/$Post.File.ID" class="button download">Download</a>
		<% end_if %>
		
	</section>
</section>