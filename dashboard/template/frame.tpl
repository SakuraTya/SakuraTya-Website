<!DOCTYPE html>
<html>
	<head>
		{include file="./header.tpl" debug=true}
	</head>
	<body>
		<div class="navbar navbar-inverse">
			<div class="navbar-inner">
				<ul class="nav">
					<a href="#" class="brand">用户面板</a>
				</ul>
				<ul class="nav pull-right">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							加大号的猫
							<b class="caret"></b>
						</a>
						<ul class="dropdown-menu">
							<li><a href="#">退出</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
		<div class="container-fluid">
			<div class="row-fluid">
				<div class="span2">
					{include file="./$env/navbar.tpl"}
				</div>
				<div class="span10 well">
					{include file="./$env/$mod.tpl"}
				</div>
			</div>
		</div>
	</body>
</html>