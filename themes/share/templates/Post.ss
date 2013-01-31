<% include Header %>

	<div class="post row">
		
		<div class="columns twelve">
			<h1>$Post.Title</h1>
			
			<p>gepostet von <a href="/posts/user/$Post.Member.FirstName">$Post.Member.FirstName</a></p>
		
			$Post.Content
		
			<% if Post.YouTubeLink %>
				<iframe width="560" height="315" src="http://www.youtube.com/embed/$Post.getYouTubeID" frameborder="0" allowfullscreen></iframe>
			<% end_if %>
		
			<% if Post.File %>
				<audio controls autobuffer>
					<source src="$Post.File.Link">
				</audio>
				<a href="$Post.File.Link">Lied runterladen</a>
			<% end_if %>
			
			<section>
				<% if Post.Likes %>
					<p><a href="/share/likes/$Post.ID" class="show-tooltip">$Post.Likes.Count <% if $Post.Likes.Count = "1" %>Person<% else %>Leuten<% end_if %></a> gefaellt das</p>
				<% end_if %>
				<a href="/share/like/$Post.ID" class="button star">Like</a>
			</section>	
		</div>
	</div>
	
<% include Footer %>