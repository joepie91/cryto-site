<h3>Register</h3>

<form method="post" action="/register" class="pure-form pure-form-aligned">
	<div class="pure-control-group">
		<label>Username</label>
		{%input type="text" name="username"}
	</div>
	
	<div class="pure-control-group">
		<label>E-mail address</label>
		{%input type="text" name="email"}
	</div>
	
	<div class="pure-control-group">
		<label>Password</label>
		{%input type="password" name="password"}
	</div>
	
	<div class="pure-control-group">
		<label>Password (again)</label>
		{%input type="password" name="password2"}
	</div>
	
	<div class="pure-control-group">
		<label></label>
		<button type="submit" class="pure-button pure-button-primary">Register</button>
	</div>
</form>
