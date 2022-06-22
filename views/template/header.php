<!DOCTYPE html>
<html>
<head>
	<title>Pointage CEPI</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="assets/css/style.css?version=<?php echo $this->version; ?>">
	<link rel="stylesheet" type="text/css" href="assets/css/icons/icons.css">
	<?php
		if(isset($css) && !empty($css)){
			foreach($css as $file){
				echo '<link rel="stylesheet" type="text/css" href="assets/css/'.$file.'?version='.$this->version.'">';
			}
		}
	?>
</head>
<body>

<section id="main"<?php echo !isset($_SESSION['USER']) || empty($_SESSION['USER']) ? ' class="connect"' : ''; ?>>
	<header>
		<nav>
			<div class="top">
				<a class="user" data-href="user"><i class="icon-user"></i></a>
			</div>
			<div class="medium">
				<a class="clock" data-href="workTime"><i class="icon-clock"></i></a>
				<a class="calendar" data-href="calendar"><i class="icon-calendar"></i></a>
				<a class="stats" data-href="stats"><i class="icon-stats"></i></a>
			</div>
			<div class="bottom">
				<a class="user" data-href="user"><i class="icon-user"></i></a>
			</div>
		</nav>
	</header>
	<section id="window">