<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1>Admin Management</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Home</a></li>
					<li class="breadcrumb-item active">Admin Management</li>
				</ol>
			</div>
		</div>
	</div>
</section>

<section class="content">
	<div class="container-fluid">
		<div class="row">

			<div class="col-sm-12 col-md-8">
				<div class="card">
					<div class="card-header">
						List Admin
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-bordered table-striped" id="table_admin">
								<thead>
									<tr>
										<th>Email</th>
										<th>Name</th>
										<th>Role</th>
										<th class="text-center">Status</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($arr->result() as $key) : ?>
										<tr>
											<td>
												<?= $key->email; ?>
												<?php
												$in_array = ['developer', 'owner'];
												if (in_array($this->session->userdata(SESI . 'role'), $in_array)) {
													echo '<div class="float-right btn-group"><button type="button" class="btn btn-xs btn-danger" onclick="deleteData(' . $key->id . ', \'' . $key->email . '\');" title="Delete"><i class="fas fa-trash fa-fw"></i></button><button type="button" class="btn btn-xs btn-warning" onclick="resetPassword(' . $key->id . ', \'' . $key->email . '\');" title="Reset"><i class="fas fa-key fa-fw"></i></button></div>';
												}
												?>
											</td>
											<td><?= $key->name; ?></td>
											<td class="text-center"><?= '<span class="badge badge-info" style="cursor: pointer;" onclick="modalRole(' . $key->id . ', \'' . $key->email . '\', \'' . $key->role . '\')">' . strtoupper($key->role) . '</span>'; ?></td>
											<td class="text-center">
												<?php
												$badge_color = ($key->is_active == "yes") ? 'badge-success' : 'badge-dark';
												$badge_text = ($key->is_active == "yes") ? 'Active' : 'Disabled';
												echo '<span class="badge ' . $badge_color . '" style="cursor: pointer;" onclick="changeStatus(' . $key->id . ', \'' . $key->email . '\', \'' . $key->is_active . '\')">' . $badge_text . '</span>';
												?>
											</td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>

			<div class="col-sm-12 col-md-4">
				<div class="card">
					<div class="card-header">
						Add Admin
					</div>
					<div class="card-body">
						<form id="form_add">
							<div class="form-group">
								<label for="email">Email</label>
								<input type="email" class="form-control" id="email" name="email" autocomplete="email" required>
							</div>
							<div class="form-group">
								<label for="password">Password</label>
								<input type="password" class="form-control" id="password" name="password" autocomplete="new-password" required>
							</div>
							<hr>
							<div class="form-group">
								<label for="name">Name</label>
								<input type="text" class="form-control" id="name" name="name" required>
							</div>
							<div class="form-group">
								<label for="role">Role</label>
								<select class="form-control" name="role" id="role" required>
									<option value="staff">Staff</option>
									<option value="marketing">Marketing</option>
									<option value="admin">Admin</option>
									<option value="owner">Owner</option>
									<option value="developer">Developer</option>
								</select>
							</div>
							<button type="submit" class="btn btn-primary btn-block">Submit</button>
						</form>
					</div>
				</div>
			</div>

		</div>
	</div>
</section>

<form id="form_role">
	<div class="modal fade" id="modal_role" data-backdrop="static" data-keyboard="false" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="staticBackdropLabel">Change Role</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="email_role">Email</label>
						<input type="text" class="form-control" id="email_role" name="email_role" required readonly>
					</div>
					<div class="form-group">
						<label for="email_role">Role</label>
						<select class="form-control" id="change_role" name="change_role">
							<option value="developer">Developer</option>
							<option value="owner">Owner</option>
							<option value="admin">Admin</option>
							<option value="marketing">Marketing</option>
							<option value="staff">Staff</option>
						</select>
					</div>
				</div>
				<div class="modal-footer">
					<input type="hidden" id="id_role" name="id_role">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Submit</button>
				</div>
			</div>
		</div>
	</div>
</form>

<form id="form_reset">
	<div class="modal fade" id="modal_reset" data-backdrop="static" data-keyboard="false" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="staticBackdropLabel">Reset Password</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="email_reset">Email</label>
						<input type="text" class="form-control" id="email_reset" name="email_reset" required readonly>
					</div>
					<div class="form-group">
						<label for="password_reset">New Password</label>
						<input type="password" class="form-control" id="password_reset" name="password_reset" required>
					</div>
				</div>
				<div class="modal-footer">
					<input type="hidden" id="id_reset" name="id_reset">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Submit</button>
				</div>
			</div>
		</div>
	</div>
</form>
