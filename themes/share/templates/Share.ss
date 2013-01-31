<% include Header %>
	
	<% if SearchTerm || UserName %>
		<section class="row">
			<div class="columns twelve">
				<% if UserName %>
					<h1>alle shares von $UserName</h1>
				<% else_if SearchTerm %>
					<h1>$Posts.Count Titel zum Begriff $SearchTerm</h1>
				<% end_if %>
			</div>
		</section>
	<% end_if %>
	
	<section class="row">

		<% if Posts %>
			<% loop Posts %>
				<article class="columns four">
					<div class="content" style="background-color:#$Member.Color.Hex;">
						<div class="margin">
							<h2><a href="view/post/$ID">$Title</a></h2>
							<p class="date">$Created.Format(d/m/y)</p>
							<p class="author"><a href="/posts/user/$Member.FirstName">$Member.FirstName</a></p>
						</div>
					</div>
				</article>
			<% end_loop %>
		<% end_if %>
	    
	    <div class="clear"></div>
	    
	</section>
	
	<!--<section class="row">
	    <div class="columns twelve">
            <a href="#" class="load-more silk">mehr laden</a>
	    </div>
    </section>-->

<% include Footer %>