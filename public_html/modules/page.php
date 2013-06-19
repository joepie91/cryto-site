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

try
{
	$sPage = Page::CreateFromQuery("SELECT * FROM pages WHERE `Slug` = :Slug", array(":Slug" => $router->uParameters[1]), 60, true);
}
catch (NotFoundException $e)
{
	throw new RouterException("Page does not exist.");
}

$sPageContents = Michelf\MarkdownExtra::defaultTransform($sPage->uBody);
