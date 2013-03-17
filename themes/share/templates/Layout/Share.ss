<% if LikesPage || SearchTerm || UserName || Genre %>
	<section class="row">
		<div class="columns large-12">
			<% if UserName %>
				<h1><%t Title.usershares "All shares from  {username}" username=$UserName %></h1>
			<% else_if SearchTerm %>
				<h1><%t Title.results "{resultcount} results for {searchterm}" resultcount=$Posts.Count searchterm=$SearchTerm %></h1>
			<% else_if LikesPage %>
				<h1><%t Title.yourlikes "Your Likes" %></h1>
			<% else_if Genre %>
				<h1><%t Title.genre "All posts in {genre}" genre=$Genre %></h1>
			<% end_if %>
		</div>
	</section>
<% end_if %>
	
<section id="Posts" class="row">

	<% if Posts %>
		<% loop Posts %>
			<article class="columns large-4">
				<div class="content" style="background-color:#$Member.Color.Hex;">
					<div class="margin">
						<h2><a href="/view/post/$ID">$Title</a></h2>
						<p class="date<% if $Genre.Title %> toggle<% end_if %>">$Created.Format(d/m/y)</p>
                        <% if $Genre.Title %><p class="genre"><a href="/share/bygenre/$Genre.ID">$Genre.Title</a></p><% end_if %>
						<p class="author">
							<a href="/posts/user/$Member.FirstName" class="posts von $Member.FirstName">$Member.FirstName</a>
						</p>
					</div>
				</div>
			</article>
		<% end_loop %>
	<% end_if %>
	
	<div class="clear"></div>
	
</section>

<% if Posts.MoreThanOnePage %>
	<section class="pagination-buttons row">	
		<% if Posts.NotFirstPage %>
			<section class="columns large-6">
				<a class="button" href="$Posts.PrevLink">Prev</a>
			</section>
		<% end_if %>
		<% if Posts.NotLastPage %>
			<section class="columns large-6<% if Posts.NotFirstPage %><% else %> large-offset-6<% end_if %>">
				<a class="button right" href="$Posts.NextLink">Next</a>
			</section>
		<% end_if %>
	</section>
<% end_if %>