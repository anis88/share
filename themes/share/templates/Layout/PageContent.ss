<section class="row">
	
	<section class="columns large-12">
		
		<h1>$Title</h1>
		
		$Text
		
	</section>
	
	<section class="columns large-12 member-list">
		
		<h3>Member</h3>
		
		<% loop getMember %>
			<div class="row">
				<div class="columns large-1 small-6">
					<div class="user-color" style="background-color: #$Color.Hex"></div>
				</div>
				<div class="columns large-11 small-6">
					<h4>
						<a href="/posts/user/$FirstName">$FirstName</a>
					</h4>
					<p>$Posts.Count posts / joined $Created.Format(d/m/Y)</p>
				</div>
			</div>
		<% end_loop %>
		
	</section>
	
</section>