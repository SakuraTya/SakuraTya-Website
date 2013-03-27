<!DOCTYPE html>
<html {lang_attr}>
<head>
	{include file="./header.tpl"}
	{if $ext_header}
		{include file=$ext_header}
	{/if}
<body>
	{include file="./navbar.tpl"}
	{exec_main mod=$mod}
	{include file="./mods/$mod.tpl"}
</body>
</html>