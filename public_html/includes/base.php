<?php
/*
 * projectname is more free software. It is licensed under the WTFPL, which
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

$_CPHP = true;
$_CPHP_CONFIG = "../config.json";
require("cphp/base.php");

require("lib/Markdown.php");
require("lib/MarkdownExtra.php");

if(!empty($_SESSION['user_id']))
{
	try
	{
		$sCurrentUser = new User($_SESSION['user_id']);
		NewTemplater::SetGlobalVariable("logged-in", true);
	}
	catch (NotFoundException $e)
	{
		NewTemplater::SetGlobalVariable("logged-in", false);
		/* Pass */
	}
}
else
{
	NewTemplater::SetGlobalVariable("logged-in", false);
}

NewTemplater::RegisterVariableHook("errors", "get_errors");
NewTemplater::RegisterVariableHook("notices", "get_notices");

function get_errors($fetch)
{
	if(isset($_SESSION['errors']))
	{
		$errors = $_SESSION['errors'];
		
		if($fetch === true)
		{
			/* We only want to clear out errors if a call to
			 * actually retrieve the errors was made, not just
			 * something like an isempty. */
			$_SESSION['errors'] = array();
		}
		
		return $errors;
	}
	else
	{
		return array();
	}
}

function get_notices($fetch)
{
	if(isset($_SESSION['notices']))
	{
		$notices = $_SESSION['notices'];
		
		if($fetch === true)
		{
			$_SESSION['notices'] = array();
		}
		
		return $notices;
	}
	else
	{
		return array();
	}
}

function flash_error($message)
{
	$_SESSION['errors'][] = $message;
}

function flash_notice($message)
{
	$_SESSION['notices'][] = $message;
}
