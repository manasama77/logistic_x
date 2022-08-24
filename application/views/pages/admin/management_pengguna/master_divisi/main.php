<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1>Master Divisi</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Management Pengguna</a></li>
					<li class="breadcrumb-item active">Master Divisi</li>
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
						<h3 class="card-title">List Divisi</h3>
						<div class="card-tools"></div>

					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-bordered table-striped" id="table_data">
								<thead>
									<tr>
										<th class="text-center" style="max-width: 10px;">#</th>
										<th>Nama Divisi</th>
										<th class="text-center" style="max-width: 50px;">
											<i class="fas fa-cogs"></i>
										</th>
									</tr>
								</thead>
								<tbody>
									<?php
									if ($arr->num_rows() > 0) :
										foreach ($arr->result() as $key) :
									?>
											<tr>
												<td class="text-center"><?= $key->id; ?></td>
												<td><?= $key->name; ?></td>
												<td class="text-center">
													<button type="button" class="btn btn-info btn-sm" title="Edit" onclick="editData('<?= $key->id; ?>', '<?= $key->name; ?>')">
														<i class="fas fa-pencil-alt"></i>
													</button>
													<button type="button" class="btn btn-danger btn-sm" title="Delete" name="btn_delete_<?= $key->id; ?>" onclick="deleteData('<?= $key->id; ?>', '<?= $key->name; ?>')">
														<i class="fas fa-trash"></i>
													</button>
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
						<h3 class="card-title">Tambah Divisi</h3>
						<div class="card-tools"></div>
					</div>
					<div class="card-body">
						<form id="form_add">
							<div class="form-group">
								<label for="name">Nama Divisi</label>
								<input type="text" class="form-control" id="name" name="name" required />
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
					<h5 class="modal-title" id="staticBackdropLabel">Edit Divisi</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="name_edit">Nama Divisi</label>
						<input type="text" class="form-control" id="name_edit" name="name" required />
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