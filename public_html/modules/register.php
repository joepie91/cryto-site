<?php
/*
 * Cryto is more free software. It is licensed under the WTFPL, which
 * allows you to do pretty much anything with it, without having to
 * ask permission. Commercial use is allowed, and no attribution is
 * required. We do politely request that you share your modifications
 * to benefit other developers, but you are under no enforced
 * obligation to do so :)
 * 
 * Please read the accompanying LICENSE document for the full WTFPL
 * licensing text.
 */

if(!isset($_APP)) { die("Unauthorized."); }

if($router->uMethod == "post")
{
	if(empty($_POST['username']))
	{
		flash_error("You did not enter a username.");
	}
	elseif(User::CheckIfUsernameExists($_POST['username']) === true)
	{
		flash_error("That username is already in use.");
	}
	
	if(empty($_POST['email']))
	{
		flash_error("You did not enter an e-mail address.");
	}
	elseif(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false)
	{
		flash_error("The e-mail address you entered is invalid.");
	}
	elseif(User::CheckIfEmailAddressExists($_POST['email']) === true)
	{
		flash_error("That e-mail address is already in use.");
	}
	
	if(empty($_POST['password']))
	{
		flash_error("You did not enter a password.");
	}
	elseif(empty($_POST['password2']))
	{
		flash_error("You did not enter a password confirmation.");
	}
	elseif($_POST['password'] != $_POST['password2'])
	{
		flash_error("The passwords you entered do not match.");
	}
	
	if(count(get_errors(false)) == 0)
	{
		$sUser = new User();
		$sUser->uUsername = $_POST['username'];
		$sUser->uPassword = $_POST['password'];
		$sUser->uEmailAddress = $_POST['email'];
		$sUser->uRegistrationDate = time();
		$sUser->uIsAdmin = false;
		$sUser->uIsBanned = false;
		$sUser->GenerateSalt();
		$sUser->GenerateHash();
		$sUser->InsertIntoDatabase();
		$sUser->Authenticate();
		redirect("/");
	}
}

$sPageTitle = "Register a new account";
$sPageHeader = "Register";
$sPageContents = NewTemplater::Render("register", $locale->strings, array());
