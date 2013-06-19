<!DOCTYPE html>
<html>
	<head>
		<title>Cryto Coding Collective :: {%?title}</title>
		<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.2.0/pure-min.css">
		<link rel="stylesheet" type="text/css" href="/static/pure.css">
		<link rel="stylesheet" type="text/css" href="/static/style.css">
	</head>
	<body class="pure-skin-cryto">
		<div class="wrapper">
			<div class="header">
				<h1>Cryto Coding Collective</h1>
				<h2>{%?header}</h2>
			</div>
			<div class="menu">
				<div class="login">
					{%if logged-in == false}
						<form method="post" action="/login">
							<input type="text" name="username" placeholder="Username">
							<input type="password" name="password" placeholder="Password">
							<button type="submit">Login</button>
						</form>
					{%else}
						You are already logged in.
					{%/if}
				</div>
				<a href="/">Home</a>
				<a href="/projects/">Projects</a>
				<a href="/guides/">Guides</a>
				<a href="/mirrors/">Mirrors</a>
				<a href="/irc/">IRC</a>
				<a href="/donate/">Donate</a>
			</div>
			<div class="content">
				{%if isempty|errors == false}
					<div class="error">
						<p>One or more errors occurred:</p>
						<ul>
							{%foreach error in errors}
								<li>{%?error}</li>
							{%/foreach}
						</ul>
					</div>
				{%/if}
				{%?contents}
			</div>
			<div class="footer">
				The design and contents of this website are, unless specified otherwise, licensed under 
				WTFPL - which essentially means you can do with it whatever you want. Individual downloads 
				may be licensed under a different license. Be sure to check the LICENSE file when 
				downloading an archive.
			</div>
		</div>
	</body>
</html>
