<?php require_once ("head-utils.php");?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
	<a class="navbar-brand" href="#"><i class="fas fa-mountain"></i></a>

	<form class="form-inline ">
		<input class="form-control" type="search" placeholder="Search" aria-label="Search">
		<button class="btn" type="submit"><i class="fas fa-search"></i></button>
	</form>

	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>

	<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav ml-auto">
			<li class="nav-item active">
				<a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#">Trails</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#">Photos</a>
			</li>
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="fas fa-user"></i>
				</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdown">
					<a class="dropdown-item" href="#">Login</a>
					<a class="dropdown-item" href="#">Sign Out</a>
				</div>
			</li>
		</ul>
	</div>
</nav>
