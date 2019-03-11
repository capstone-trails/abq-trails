
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
		<ul class="navbar-nav">
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

<main>
	<!-- Button trigger modal -->
	<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#sign-in">
		Launch demo modal
	</button>

	<!-- Modal -->
	<div class="modal fade" id="sign-in" tabindex="-1" role="dialog" aria-labelledby="sign-in" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalCenterTitle">Sign In</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form>
						<div class="form-group">
							<label for="exampleInputEmail1">Email address</label>
							<input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
							<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
						</div>
						<div class="form-group">
							<label for="exampleInputPassword1">Password</label>
							<input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
						</div>
						<button type="submit" class="btn btn-primary">Submit</button>
					</form>
				</div>
				<div class="modal-footer">
					<p>Don't have a profile yet?</p>
					<button type="button" class="btn btn-primary">Sign Up</button>
				</div>
			</div>
		</div>
	</div>
</main>
