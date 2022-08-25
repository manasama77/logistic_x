<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1>Master Supplier</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Management Barang</a></li>
					<li class="breadcrumb-item active">Master Supplier</li>
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
						<h3 class="card-title">List Supplier</h3>
						<div class="card-tools"></div>

					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-bordered table-striped" id="table_data" style="min-width: 900px;">
								<thead>
									<tr>
										<th class="text-center" style="max-width: 80px;">
											<i class="fas fa-cogs"></i>
										</th>
										<th class=" text-center" style="max-width: 10px;">#</th>
										<th>Kode Supplier</th>
										<th>Nama Supplier</th>
										<th>No Handphone</th>
										<th>Email</th>
										<th class="text-center">Status</th>
									</tr>
								</thead>
								<tbody>
									<?php
									if ($arr->num_rows() > 0) :
										foreach ($arr->result() as $key) :
									?>
											<tr>
												<td class="text-center">
													<button type="button" class="btn btn-info btn-sm" title="Edit" onclick="editData('<?= $key->id; ?>', '<?= $key->code; ?>', '<?= $key->name; ?>', '<?= $key->phone; ?>', '<?= $key->email; ?>', '<?= $key->is_active; ?>')">
														<i class="fas fa-pencil-alt"></i>
													</button>
													<button type="button" class="btn btn-danger btn-sm" title="Delete" name="btn_delete_<?= $key->id; ?>" onclick="deleteData('<?= $key->id; ?>', '<?= $key->name; ?>')">
														<i class="fas fa-trash"></i>
													</button>
												</td>
												<td class="text-center"><?= $key->id; ?></td>
												<td><?= $key->code; ?></td>
												<td><?= $key->name; ?></td>
												<td><?= $key->phone; ?></td>
												<td><?= $key->email; ?></td>
												<td class="text-center">
													<?php $warna = ($key->is_active == "Aktif") ? "badge-success" : "badge-dark"; ?>
													<span class="badge <?= $warna; ?>"><?= $key->is_active; ?></span>
												</td>
											</tr>
									<?php
										endforeach;
									endif;
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>

			<div class="col-sm-12 col-md-4">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">Tambah Supplier</h3>
						<div class="card-tools"></div>
					</div>
					<div class="card-body">
						<form id="form_add">
							<div class="form-group">
								<label for="code">Kode Supplier</label>
								<input type="text" class="form-control" id="code" name="code" placeholder="Kode Supplier" required />
							</div>
							<div class="form-group">
								<label for="name">Nama Supplier</label>
								<input type="text" class="form-control" id="name" name="name" placeholder="Nama Supplier" required />
							</div>
							<div class="form-group">
								<label for="phone">No Handphone</label>
								<input type="tel" class="form-control" id="phone" name="phone" placeholder="No Handphone" required />
							</div>
							<div class="form-group">
								<label for="email">Email</label>
								<input type="email" class="form-control" id="email" name="email" placeholder="Email" required />
							</div>
							<div class="form-group">
								<label for="is_active">Status</label>
								<select class="form-control" id="is_active" name="is_active" required>
									<option value="Aktif">Aktif</option>
									<option value="Tidak Aktif">Tidak Aktif</option>
								</select>
							</div>
							<div class="form-group">
								<button type="submit" class="btn btn-primary btn-block" id="btn_add"><i class="fas fa-save"></i> Simpan</button>
							</div>
						</form>
					</div>
				</div>
			</div>

		</div>
	</div>
</section>

<!-- Modal -->
<form id="form_edit">
	<div class="modal fade" id="modal_edit" data-backdrop="static" data-keyboard="false" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="staticBackdropLabel">Edit Supplier</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="code_edit">Kode Supplier</label>
						<input type="text" class="form-control" id="code_edit" name="code" placeholder="Kode Supplier" required />
					</div>
					<div class="form-group">
						<label for="name_edit">Nama Supplier</label>
						<input type="text" class="form-control" id="name_edit" name="name" placeholder="Nama Supplier" required />
					</div>
					<div class="form-group">
						<label for="phone_edit">No Handphone</label>
						<input type="tel" class="form-control" id="phone_edit" name="phone" placeholder="No Handphone" required />
					</div>
					<div class="form-group">
						<label for="email_edit">Email</label>
						<input type="email" class="form-control" id="email_edit" name="email" placeholder="Email" required />
					</div>
					<div class="form-group">
						<label for="is_active_edit">Status</label>
						<select class="form-control" id="is_active_edit" name="is_active" required>
							<option value="Aktif">Aktif</option>
							<option value="Tidak Aktif">Tidak Aktif</option>
						</select>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary" id="btn_edit"><i class="fas fa-save"></i> Simpan</button>
				</div>
			</div>
		</div>
	</div>
</form>