<!DOCTYPE html>
<html lang="$ContentLocale">
<head>
    <% base_tag %>
    <title><% if MetaTitle %>$MetaTitle<% else %>$Title<% end_if %> - $SiteConfig.Title</title>
    $MetaTags(false)
	<% require themedCSS(reset) %>
	<% require themedCSS(typography) %>
	<% require themedCSS(form) %>
    <% require themedCSS(login) %>
</head>
<body class="$ClassName LoginPage typography">
    
    <% if Content %>
        <div class="PageContent">$Content</div>
    <% end_if %>

    <div id="CMSLogin">
        <div class="head">Login</div>
        <div class="content">
            $Form
        </div>
    </div>

	<script>
		document.getElementById('MemberLoginForm_LoginForm_Email').focus();
	</script>
	
</body>
</html>