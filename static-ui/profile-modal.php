<?php require_once ("head-utils.php");?>

<?php require_once("navbar.php");?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
	<a class="navbar-brand" href="#">Navbar</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>

	<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav mr-auto">
			<li class="nav-item active">
				<a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#">Link</a>
			</li>
			<li class="nav-item">
				<a class="nav-link disabled" href="#">Disabled</a>
			</li>
		</ul>
		<form class="form-inline my-2 my-lg-0">
			<input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
			<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
		</form>
	</div>
</nav>


<main>
	<div class="container-fluid">
		<h1 class="text-center">Update Profile</h1>
		<form class="form-control-lg" id="form" action="" method="post">
			<div class="info">
				<input class="form-control" id="email" type="email" name="email" placeholder=" Email"/>
				<input class="form-control" id="password" type="text" name="password" placeholder=" Password"/>
				<input class="form-control" id="password-confirm" type="text" name="password-confirm" placeholder=" Re-enter Password"/>
			</div>
			<button type="button" class="btn pull-right m-2" data-dismiss="modal">Cancel</button>
			<button type="button" class="btn green pull-right m-2">Save changes</button>
		</form>
	</div>
</main>