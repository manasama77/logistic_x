<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1>Profile</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Home</a></li>
					<li class="breadcrumb-item active">Profile</li>
				</ol>
			</div>
		</div>
	</div>
</section>

<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-3">

				<!-- Profile Image -->
				<div class="card card-primary card-outline">
					<div class="card-body box-profile">
						<div class="text-center">
							<img class="profile-user-img img-fluid img-circle" src="<?= base_url('public/plugin/adminlte/dist/img/avatar5.png'); ?>" alt="Profile Picture">
						</div>

						<h3 class="profile-username text-center"><?= $this->session->userdata(SESI . 'name'); ?><br><small>(<?= strtoupper($this->session->userdata(SESI . 'role')); ?>)</small></h3>
					</div>
				</div>

				<div class="card card-primary">
					<div class="card-header">
						<h3 class="card-title">About Me</h3>
					</div>
					<div class="card-body">

						<strong><i class="fas fa-envelope mr-1"></i> Email</strong>

						<p class="text-muted mb-0">
							<?= $this->session->userdata(SESI . 'email'); ?>
						</p>

					</div>
				</div>
			</div>

			<div class="col-md-9">
				<div class="card">
					<div class="card-header p-2">
						<ul class="nav nav-pills">
							<li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Settings</a></li>
							<li class="nav-item"><a class="nav-link" href="#reset_password" data-toggle="tab">Reset Password</a></li>
						</ul>
					</div>
					<div class="card-body">
						<div class="tab-content">

							<div class="tab-pane active" id="settings">
								<form class="form-horizontal" id="form_setting">
									<div class="form-group row">
										<label for="name" class="col-sm-2 col-form-label">Name</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" id="name" name="name" placeholder="Name" value="<?= $arr->row()->name; ?>">
										</div>
									</div>
									<div class="form-group row">
										<label for="email" class="col-sm-2 col-form-label">Email</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" id="email" placeholder="Email" value="<?= $arr->row()->email; ?>" readonly>
										</div>
									</div>
									<div class="form-group row">
										<div class="offset-sm-2 col-sm-10">
											<button type="submit" class="btn btn-danger btn-block">Submit</button>
										</div>
									</div>
								</form>
							</div>

							<div class="tab-pane" id="reset_password">
								<form class="form-horizontal" id="form_reset_password">
									<div class="form-group row">
										<label for="current_password" class="col-sm-2 col-form-label">Current Password</label>
										<div class="col-sm-10">
											<input type="password" class="form-control" id="current_password" name="current_password" placeholder="Current Password" required>
										</div>
									</div>
									<div class="form-group row">
										<label for="new_password" class="col-sm-2 col-form-label">New
											Password</label>
										<div class="col-sm-10">
											<input type="password" class="form-control" id="new_password" name="new_password" placeholder="New Password" required>
										</div>
									</div>
									<div class="form-group row">
										<label for="verify_password" class="col-sm-2 col-form-label">Verify
											Password</label>
										<div class="col-sm-10">
											<input type="password" class="form-control" id="verify_password" name="verify_password" placeholder="Verify Password" required>
										</div>
									</div>
									<div class="form-group row">
										<div class="offset-sm-2 col-sm-10">
											<button type="submit" class="btn btn-danger btn-block">Submit</button>
										</div>
									</div>
								</form>
							</div>

						</div>
						<!-- /.tab-content -->
					</div><!-- /.card-body -->
				</div>
				<!-- /.card -->
			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->
	</div><!-- /.container-fluid -->
</section>
