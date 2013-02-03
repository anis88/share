<!doctype html>
<html lang="$ContentLocale">
<head>
	<meta charset="UTF-8">
	<title>share</title>
	<meta name="viewport" content="width=device-width">
</head>
<body>
	
	<header>
	    <div class="row">
	        <div class="column four">
	            <h1><a href="/">share</a></h1>
	        </div>
	        <div class="column four search-form">
	            <form action="{$BaseURL}share/search/">
	                <input type="search" class="twelve" placeholder="search"<% if SearchTerm %> value="$SearchTerm"<% end_if %>>
                </form>
	        </div>
	        <div class="column three offset-by-one">
				<div class="menue">
					<% if CurrentMember %>
						<!--<a href="#" class="notifications unread">3</a>-->
						<a href="#" class="user-menue">$CurrentMember.FirstName</a>
						<a href="#" class="notification-count" title="Hier kommen die Benachrichtungen">(3)</a>
						<div class="row">
							<div class="columns twelve">
								<ul class="dropdown hidden">
									<li>
										<a href="/admin" class="new-window">admin</a>
										<!--<a href="/profile/edit">edit profile</a>
										<a href="/about">about share</a>-->
										<a href="/Security/logout?BackURL=/">logout</a>
									</li>
								</ul>
							</div>
						</div>
					<% else %>
						<a href="/Security/login?BackURL=/" class="sign-in">sign in</a>
					<% end_if %>
				</div>
	        </div>
	    </div>
	</header>