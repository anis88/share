<% if LikesPage || SearchTerm || UserName %>
	<section class="row">
		<div class="columns twelve">
			<% if UserName %>
				<h1><%t Title.usershares "All shares from  {username}" username=$UserName %></h1>
			<% else_if SearchTerm %>
				<h1><%t Title.results "{resultcount} results for {searchterm}" resultcount=$Posts.Count searchterm=$SearchTerm %></h1>
			<% else_if LikesPage %>
				<h1><%t Title.your "Your" %> Likes</h1>
			<% end_if %>
		</div>
	</section>
<% end_if %>
	
<section id="Posts" class="row">

	<% if Posts %>
		<% loop Posts %>
			<article class="columns four">
				<div class="content" style="background-color:#$Member.Color.Hex;">
					<div class="margin">
						<h2><a href="view/post/$ID">$Title</a></h2>
						<p class="date">$Created.Format(d/m/y)</p>
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
	<section class="pagination row">
		<section class="columns six">
			<% if Posts.NotFirstPage %>
				<a class="button" href="$Posts.PrevLink">Prev</a>
			<% end_if %>
		</section		
		<section class="columns six">
			<% if Posts.NotLastPage %>
				<a class="button right" href="$Posts.NextLink">Next</a>
			<% end_if %>
		</section>
	</section>
<% end_if %>