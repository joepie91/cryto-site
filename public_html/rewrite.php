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

$_APP = true;
require("includes/base.php");

$sPageTitle = "";
$sPageContents = "";

$router = new CPHPRouter();

$router->allow_slash = true;
$router->ignore_query = true;

$router->routes = array(
	0 => array(
		"^/$"		=> "modules/homepage.php",
		"^/(.*)$"	=> "modules/page.php"
	)
);

try
{
	$router->RouteRequest();
}
catch (RouterException $e)
{
	http_status_code(404);
	die("404 Not Found");
}

echo(NewTemplater::Render("layout", $locale->strings, array(
	"title"		=> $sPageTitle,
	"contents"	=> $sPageContents
)));
