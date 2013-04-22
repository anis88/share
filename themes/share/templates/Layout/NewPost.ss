<section class="row">
	<div class="columns large-12">
		<h1><%t Title.Newpost "Add Post" %></h1>
	</div>
</section>
	
<section class="row">

	<section class="columns large-12">
		<form action="/share/savepost" method="post" id="NewPost" class="custom">
			
			<label for="Title"><%t Form.Title "Title" %></label>
			<input type="text" name="Title" id="Title" required>
			
			<label for="Text"><%t Form.Description "Description" %></label>
			<textarea name="Text" id="Text" cols="30" rows="10"></textarea>
			
			<label for="Genre"><%t Form.Genre "Genre" %></label>
			<select name="Genre" id="Genre" class="medium">
				<option value="">-- select genre --</option>
				<% loop Genres %>
					<option value="$ID">$Title</option>
				<% end_loop %>
			</select>
			
			<label for="Link"><%t Form.Link "YouTube, Soundcloud, Vimeo or Dailymotion Link" %></label>
			<input type="text" name="Link" id="Link" required>
			
			<input type="submit" class="button" value="<%t Form.Submit "save" %>">
		</form>
	</section>
	
</section>