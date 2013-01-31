<!doctype html>
<html lang="$ContentLocale">
<head>
	<meta charset="UTF-8">
	<title>share</title>
</head>
<body>
	
	<header class="die-in-the-moonlyt">
	    <div class="row">
	        <div class="column four">
	            <h1><a href="/">share</a></h1>
	        </div>
	        <div class="column four search-form">
	            <form action="{$BaseURL}share/search/">
	                <input type="search" class="twelve" placeholder="search"<% if SearchTerm %> value="$SearchTerm"<% end_if %>>
                </form>
	        </div>
	        <div class="column two offset-by-two">
				<% if CurrentMember %>
					<a href="#" class="notifications unread">3</a>
					<a href="#" class="user-menue">$CurrentMember.FirstName</a>
					<ul class="dropdown">
						<li>
							<a href="/admin">admin</a>
							<a href="/profile/edit">edit profile</a>
							<a href="/Security/logout?BackURL=/">logout</a>
						</li>
					</ul>
				<% else %>
					<a href="/Security/login?BackURL=/" class="sign-in">sign in</a>
				<% end_if %>
	        </div>
	    </div>
	</header>