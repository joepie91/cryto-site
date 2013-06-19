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

if(empty($_POST['username']))
{
	flash_error("You did not enter a username.");
}

if(empty($_POST['password']))
{
	flash_error("You did not enter a password.");
}

if(count(get_errors(false)) == 0)
{
	try
	{
		$sUser = User::CreateFromQuery("SELECT * FROM users WHERE `Username` = :Username", array(":Username" => $_POST['username']), 30, true);
	}
	catch (NotFoundException $e)
	{
		flash_error("Invalid username.");
		redirect("/");
	}
	
	if($sUser->VerifyPassword($_POST['password']))
	{
		$sUser->Authenticate();
	}
	else
	{
		flash_error("Invalid password.");
		redirect("/");
	}
}

redirect("/");
