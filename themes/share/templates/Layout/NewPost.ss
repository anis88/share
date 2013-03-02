<section class="row">
	<div class="columns twelve">
		<h1><%t Title.newpost "Add Post" %></h1>
	</div>
</section>
	
<section class="row">

	<section class="columns twelve">
		<form action="/share/savepost" method="post" id="NewPost" class="custom">
			
			<label for="Title">Title</label>
			<input type="text" name="Title" id="Title" required>
			
			<label for="Text">Description</label>
			<textarea name="Text" id="Text" cols="30" rows="10"></textarea>
			
			<label for="Genre">Genre</label>
			<select name="Genre" id="Genre" class="medium">
				<option value="">-- select genre --</option>
				<% loop Genres %>
					<option value="$ID">$Title</option>
				<% end_loop %>
			</select>
			
			<label for="Link">YouTube or Soundcloud Link</label>
			<input type="text" name="Link" id="Link" required>
			
			<input type="submit" class="button" value="save">
		</form>
	</section>
	
</section>