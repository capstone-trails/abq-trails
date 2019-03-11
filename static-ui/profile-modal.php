<?php require_once ("head-utils.php");?>

<main>
	<!-- Button trigger modal -->
	<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
		Launch demo modal
	</button>

	<!-- Modal -->
	<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalCenterTitle">Your Profile</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<table border="1"
					<table class="container-fluid">
						<img src="https://via.placeholder.com/85" class="rounded mx-auto d-block" alt="...">
						<h2 class="text-center">Profile Name</h2>

						<!-- Equal width cols, same on all screen sizes -->

						<div class="container">
							<div class="row">
								<div class="col">
									<p align="left">FirstLastName</p>
								</div>
								<div class="col">
								</div>
								<div class="col">
									<p align="right">Email@email.com</p>
								</div>
							</div>
						</div>


						<h2 align="center">My Photos</h2>
						<div class="container">
							<div class="row">
								<div class="col">
									<img src="https://via.placeholder.com/95" class="rounded mx-auto d-block" alt="...">
								</div>
								<div class="col order-12">
									<img src="https://via.placeholder.com/95" class="rounded mx-auto d-block" alt="...">
								</div>
								<div class="col order-1">
									<img src="https://via.placeholder.com/95" class="rounded mx-auto d-block" alt="...">
								</div>
							</div>
						</div>
					</table>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary">Save changes</button>
				</div>
			</div>
		</div>
	</div>
</main>