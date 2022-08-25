<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1>Master User</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Home</a></li>
					<li class="breadcrumb-item active">Master User</li>
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
						List User
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-bordered table-striped" id="table_admin" style="min-width: 1000px;">
								<thead>
									<tr>
										<th class="text-center">
											<i class="fas fa-cogs"></i>
										</th>
										<th>Username</th>
										<th>Nama</th>
										<th>Email</th>
										<th>Divisi</th>
										<th>Role</th>
										<th>Phone</th>
										<th class="text-center">Status</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($arr->result() as $key) : ?>
										<tr>
											<td class="text-center">
												<button type="button" class="btn btn-xs btn-danger" id="btn_delete_<?= $key->id; ?>" onclick="deleteData(<?= $key->id; ?>, '<?= $key->username; ?>');" title="Delete">
													<i class="fas fa-trash fa-fw"></i>
												</button>
												<button type="button" class="btn btn-xs btn-warning" onclick="resetPassword(<?= $key->id; ?>, '<?= $key->username; ?>');" title="Reset">
													<i class="fas fa-key fa-fw"></i>
												</button>
											</td>
											<td><?= $key->username; ?></td>
											<td><?= $key->name; ?></td>
											<td><?= $key->email; ?></td>
											<td><?= $key->division_name; ?></td>
											<td><?= $key->role; ?></td>
											<td><?= $key->phone; ?></td>
											<td class="text-center">
												<?php
												$badge_color = ($key->is_active == "yes") ? 'badge-success' : 'badge-dark';
												$badge_text = ($key->is_active == "yes") ? 'Active' : 'Disabled';
												?>
												<span class="badge <?= $badge_color; ?>" style="cursor: pointer;" onclick="changeStatus(<?= $key->id; ?>, '<?= $key->username; ?>', '<?= $key->is_active; ?>')"><?= $badge_text; ?></span>
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
						Tambah User
					</div>
					<div class="card-body">
						<form id="form_add">
							<div class="form-group">
								<label for="username">Username <span class="text-danger">*</span></label>
								<input type="text" class="form-control text-lowercase" id="username" name="username" autocomplete="username" placeholder="Username" required>
							</div>
							<div class="form-group">
								<label for="password">Password <span class="text-danger">*</span></label>
								<input type="password" class="form-control" id="password" name="password" autocomplete="new-password" minlength="4" placeholder="Password" required>
							</div>
							<hr>
							<div class="form-group">
								<label for="name">Nama <span class="text-danger">*</span></label>
								<input type="text" class="form-control" id="name" name="name" autocomplete="name" placeholder="Nama" required>
							</div>
							<div class="form-group">
								<label for="phone">Telepon <span class="text-danger">*</span></label>
								<input type="tel" class="form-control" id="phone" name="phone" autocomplete="name" placeholder="Telepon" required>
							</div>
							<div class="form-group">
								<label for="email">Email <span class="text-danger">*</span></label>
								<input type="email" class="form-control" id="email" name="email" autocomplete="email" placeholder="Email" required>
							</div>
							<div class="form-group">
								<label for="division_id">Divisi <span class="text-danger">*</span></label>
								<select class="form-control" name="division_id" id="division_id" required>
									<?php foreach ($division->result() as $key) { ?>
										<option value="<?= $key->id; ?>"><?= $key->name; ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="form-group">
								<label for="role">Role <span class="text-danger">*</span></label>
								<select class="form-control" name="role" id="role" required>
									<option value="Staff">Staff</option>
									<option value="Admin">Admin</option>
									<option value="IT">IT</option>
									<option value="SVP">SVP</option>
									<option value="Asmen">Asmen</option>
									<option value="Manager">Manager</option>
									<option value="Purchasing">Purchasing</option>
									<option value="HRD">HRD</option>
									<option value="General Manager">General Manager</option>
									<option value="Owner">Owner</option>
								</select>
							</div>
							<button type="submit" class="btn btn-primary btn-block" id="btn_add">
								<i class="fas fa-save"></i> Simpan
							</button>
						</form>
					</div>
				</div>
			</div>

		</div>
	</div>
</section>

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
						<label for="username_reset">Username</label>
						<input type="text" class="form-control" id="username_reset" name="username_reset" placeholder="Username" required readonly>
					</div>
					<div class="form-group">
						<label for="password_reset">Password Baru</label>
						<input type="password" class="form-control" id="password_reset" name="password_reset" placeholder="Password Baru" required>
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