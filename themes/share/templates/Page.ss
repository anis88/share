<!doctype html>
<html lang="$ContentLocale">
<head>
	<meta charset="UTF-8">
	<title>share</title>
	<meta name="viewport" content="width=device-width">
	<meta name="robots" content="noindex, nofollow">
	<link rel="icon" type="image/png" href="/themes/share/images/share-logo.png">
</head>
<body>
	
	<header>
		
	    <div class="row">
	        <div class="column large-4">
	            <h1><a href="/">share</a></h1>
	        </div>
	        <div class="column large-4 hide-on-mobile search-form">
	            <form action="{$BaseURL}share/search/">
	                <input type="search" class="large-12" placeholder="search"<% if SearchTerm %> value="$SearchTerm"<% end_if %>>
                </form>
	        </div>
	        <div class="column hide-on-mobile large-3 large-offset-1">
				<div class="menue">
					<% if CurrentMember %>
						<a href="#" class="user-menue">$CurrentMember.FirstName</a>
						<!--
						<a href="#" class="notification-count" title="Hier kommen die Benachrichtungen">(3)</a>
						-->
					<% else %>
						<a href="/Security/login?BackURL=/" class="sign-in"><%t Menu.SignIn "sign in" %></a>
					<% end_if %>
				</div>
	        </div>
			
			<!-- menue for mobile view -->
			<a href="#" class="mobile-menue mobile-only">menu</a>
			
	    </div>
		
		<div class="hidden row">
			<div class="columns large-offset-9 large-3">
				<ul class="dropdown">
					<li class="hide-on-mobile">
						<a href="/admin" class="new-window">admin</a>
					</li>
					<% if CurrentMember %>
					<li>
						<a href="/share/newpost"><%t Title.newpost "add a post" %></a>
					</li>
					<li>
						<a href="/user/likes"><%t Title.likes "your likes" %></a>
					</li>
					<!--
					<li>
						<a href="/user/edit">edit profile</a>
					</li>
					-->
					<% end_if %>
					<li>
						<a href="/page/get/about"><%t Menu.About "about share" %></a>
					</li>
					<li>
						<% if CurrentMember %>
							<a href="/Security/logout?BackURL=/"><%t Menu.SignOut "sign out" %></a>
						<% else %>
							<a href="/Security/login?BackURL=/" class="sign-in"><%t Menu.SignIn "sign in" %></a>
						<% end_if %>
					</li>
				</ul>
			</div>
		</div>
		
	</header>

	$Layout
	
</body>
</html>