<!DOCTYPE html>
<html lang="$ContentLocale">
<head>
    <% base_tag %>
    <title><% if MetaTitle %>$MetaTitle<% else %>$Title<% end_if %> - $SiteConfig.Title</title>
    $MetaTags(false)
	<% require themedCSS(foundation/stylesheets/foundation.min) %>
	<% require themedCSS(app) %>
	<% require themedCSS(form) %>
    <% require themedCSS(login) %>
</head>
<body class="$ClassName LoginPage typography">
    
	<header>
		<div class="row">
	        <div class="column twelve">
				<h1>Login</h1>
			</div>
		</div>
	</header>
	
    <% if Content %>
		<div class="row">
	        <div class="column twelve">
			    <div class="PageContent">$Content</div>
			</div>
		</div>
    <% end_if %>

    <div id="CMSLogin" class="row">
        <div class="column twelve">
            $Form
        </div>
    </div>

	<script>
		document.getElementById('MemberLoginForm_LoginForm_Email').focus();
	</script>
	<script src="/themes/share/javascript/mootools-core-1.4.5-full-nocompat-yc.js"></script>
	<script src="/themes/share/javascript/init.js"></script>
	
</body>
</html>