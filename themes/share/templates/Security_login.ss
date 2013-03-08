<!DOCTYPE html>
<html lang="$ContentLocale">
<head>
    <% base_tag %>
    <title>share :: sign in</title>
	<% require themedCSS(foundation/css/normalize) %>
	<% require themedCSS(foundation/css/foundation.min) %>
	<% require themedCSS(app) %>
	<meta name="viewport" content="width=device-width">
	<meta name="robots" content="noindex, nofollow">
</head>
<body class="$ClassName LoginPage typography">
    
	<header>
		<div class="row">
	        <div class="column large-12">
				<h1>login</h1>
			</div>
		</div>
	</header>
	
    <% if Content %>
		<div class="row">
	        <div class="column large-12">
			    <div class="PageContent">$Content</div>
			</div>
		</div>
    <% end_if %>

    <div id="CMSLogin" class="row">
        <div class="column large-12">
            $Form
        </div>
    </div>

	<script src="/themes/share/javascript/third-party/jquery-1.9.1.min.js"></script>
	<script src="/themes/share/javascript/init.js"></script>
	
</body>
</html>