<?php require_once ("head-utils.php");?>

<main>
	<!-- Button trigger modal -->
	<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
		Launch demo modal
	</button>

	<!-- Modal -->
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Sign Up</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">

					<form>
						<div class="form-row">
							<div class="form-group col-md-6">
								<label for="inputEmail">Email</label>
								<input type="email" class="form-control" id="inputEmail">
							</div>
							<div class="form-group col-md-6">
								<label for="inputUsername">Username</label>
								<input type="text" class="form-control" id="inputUsername">
							</div>

							<div class="form-group col-md-6">
								<label for="inputPassword4">Password</label>
								<input type="password" class="form-control" id="inputPassword4">
							</div>
							<div class="form-group col-md-6">
								<label for="inputPassword2">Confirm Password</label>
								<input type="password" class="form-control" id="inputPassword2">
							</div>

							<div class="form-group col-md-6">
								<label for="firstName">First Name</label>
								<input type="text" class="form-control" id="firstName">
							</div>
							<div class="form-group col-md-6">
								<label for="lastName">Last Name</label>
								<input type="Text" class="form-control" id="lastName">
							</div>
								<button type="button" class="btn btn-secondary">Add a photo</button>
						</form>
				</div>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary">Submit</button>
				</div>
			</div>
		</div>
	</div>



</main>