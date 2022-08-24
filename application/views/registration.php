<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= $title; ?></title>

	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?= base_url(); ?>public/plugin/adminlte/plugins/fontawesome-free/css/all.min.css">
	<!-- icheck bootstrap -->
	<link rel="stylesheet" href="<?= base_url(); ?>public/plugin/adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="<?= base_url(); ?>public/plugin/adminlte/dist/css/adminlte.min.css">
	<style>
		.login-box,
		.register-box {
			max-width: 750px !important;
		}

		@media (min-width: 768px) {

			.login-box,
			.register-box {
				min-width: 750px !important;
			}
		}
	</style>
</head>

<body class="hold-transition register-page">
	<div class="register-box">
		<div class="register-logo">
			<a href="javascript:void(0)"><b>EDI</b>TRADE</a>
		</div>


		<div class="card">
			<div class="card-body register-card-body">
				<p class="login-box-msg">Register a new membership</p>

				<form action="<?= site_url('registration_success'); ?>" method="post">
					<div class="row">
						<div class="col-sm-12 col-md-6">

							<div class="input-group mb-3">
								<input type="text" class="form-control" placeholder="Full name">
								<div class="input-group-append">
									<div class="input-group-text">
										<span class="fas fa-user"></span>
									</div>
								</div>
							</div>

							<div class="input-group mb-3">
								<input type="text" class="form-control" placeholder="Phone Number">
								<div class="input-group-append">
									<div class="input-group-text">
										<span class="fas fa-phone"></span>
									</div>
								</div>
							</div>

							<div class="input-group mb-3">
								<input type="text" class="form-control" placeholder="ID Card Number">
								<div class="input-group-append">
									<div class="input-group-text">
										<span class="fas fa-id-card"></span>
									</div>
								</div>
							</div>

							<div class="input-group mb-3">
								<input type="text" class="form-control" placeholder="Reffered By" value="Adam PM" readonly>
								<div class="input-group-append">
									<div class="input-group-text">
										<span class="fas fa-user-tie"></span>
									</div>
								</div>
							</div>

						</div>
						<div class="col-sm-12 col-md-6">

							<div class="input-group mb-3">
								<input type="email" class="form-control" placeholder="Email">
								<div class="input-group-append">
									<div class="input-group-text">
										<span class="fas fa-envelope"></span>
									</div>
								</div>
							</div>
							<div class="input-group mb-3">
								<input type="password" class="form-control" placeholder="Password">
								<div class="input-group-append">
									<div class="input-group-text">
										<span class="fas fa-lock"></span>
									</div>
								</div>
							</div>
							<div class="input-group mb-3">
								<input type="password" class="form-control" placeholder="Retype password">
								<div class="input-group-append">
									<div class="input-group-text">
										<span class="fas fa-lock"></span>
									</div>
								</div>
							</div>

							<div class="icheck-primary">
								<input type="checkbox" id="agreeTerms" name="terms" value="agree">
								<label for="agreeTerms">
									I agree to the <a href="javascript:;" onclick="showModalTerm();">Terms</a>
								</label>
							</div>
							<button type="submit" class="btn btn-primary btn-block">Register</button>
							<a href="<?= site_url('login'); ?>" class="text-center">I already have a membership</a>

						</div>
					</div>

				</form>
			</div>
			<!-- /.form-box -->
		</div><!-- /.card -->

	</div>

	<div class="modal fade" id="term_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Term</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto sequi nemo voluptates
						nesciunt quis tempore dolor, repudiandae consequuntur nobis pariatur!</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

	<!-- jQuery -->
	<script src="<?= base_url(); ?>public/plugin/adminlte/plugins/jquery/jquery.min.js"></script>
	<!-- Bootstrap 4 -->
	<script src="<?= base_url(); ?>public/plugin/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- AdminLTE App -->
	<script src="<?= base_url(); ?>public/plugin/adminlte/dist/js/adminlte.min.js"></script>
</body>

</html>

<script>
	$(document).ready(function() {
		//
	});

	function showModalTerm() {
		$('#term_modal').modal('show');
	}
</script>
