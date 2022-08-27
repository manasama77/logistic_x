<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-12 col-md-4">
				<h1>Tambah Master Barang</h1>
			</div>
			<div class="col-sm-12 col-md-8">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Management Barang</a></li>
					<li class="breadcrumb-item"><a href="<?= base_url('management_barang/master_barang'); ?>">Management Barang</a></li>
					<li class="breadcrumb-item active">Tambah Master Barang</li>
				</ol>
			</div>
		</div>
	</div>
</section>

<section class="content">
	<div class="container-fluid">
		<div class="row">

			<div class="col-sm-12">
				<form id="form" enctype="multipart/form-data">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">Form Barang</h3>
							<div class="card-tools">
								<a href="<?= base_url('management_barang/master_barang'); ?>" class="btn btn-secondary">
									<i class="fas fa-chevron-left"></i> Kembali Ke List Barang
								</a>
							</div>

						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-sm-12 col-md-3">
									<div class="form-group">
										<label for="code">Kode Barang <span class="text-danger">*</span></label>
										<input type="text" class="form-control" id="code" name="code" placeholder="Kode Barang" required />
									</div>
									<div class="form-group">
										<label for="name">Nama Barang <span class="text-danger">*</span></label>
										<input type="text" class="form-control" id="name" name="name" placeholder="Nama Barang" required />
									</div>
									<div class="form-group">
										<label for="merk">Merk Barang <span class="text-danger">*</span></label>
										<input type="text" class="form-control" id="merk" name="merk" placeholder="Merk Barang" required />
									</div>
								</div>
								<div class="col-sm-12 col-md-3">
									<div class="form-group">
										<label for="category_id">Kategori <span class="text-danger">*</span></label>
										<select class="form-control" id="category_id" name="category_id" required>
											<option value=""></option>
											<?php foreach ($category->result() as $key) { ?>
												<option value="<?= $key->id; ?>"><?= $key->name; ?></option>
											<?php } ?>
										</select>
									</div>
									<div class="form-group">
										<label for="unit_id">Satuan <span class="text-danger">*</span></label>
										<select class="form-control" id="unit_id" name="unit_id" required>
											<option value=""></option>
											<?php foreach ($unit->result() as $key) { ?>
												<option value="<?= $key->id; ?>"><?= $key->name; ?></option>
											<?php } ?>
										</select>
									</div>
									<div class="form-group">
										<label for="supplier_id">Supplier <span class="text-danger">*</span></label>
										<select class="form-control" id="supplier_id" name="supplier_id" required>
											<option value=""></option>
											<?php foreach ($supplier->result() as $key) { ?>
												<option value="<?= $key->id; ?>"><?= $key->name; ?></option>
											<?php } ?>
										</select>
									</div>
									<div class="form-group">
										<label for="location_id">Lokasi <span class="text-danger">*</span></label>
										<select class="form-control" id="location_id" name="location_id" required>
											<option value=""></option>
											<?php foreach ($location->result() as $key) { ?>
												<option value="<?= $key->id; ?>"><?= $key->name; ?> - <?= $key->shelf_number; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="col-sm-12 col-md-3">
									<div class="form-group">
										<label for="image_path">Gambar</label>
										<input type="file" class="form-control" id="image_path" name="image_path" accept="image/*" />
									</div>
								</div>
								<div class="col-sm-12 col-md-3">
									<img src="<?= base_url('public/img/barang/default.jpg'); ?>" class="img-thumbnail elevation-2" id="preview_image" alt="Preview Image" />
									<button type="button" class="btn btn-danger btn-sm btn-block mt-2 elevation-2" id="btn_reset_image" disabled>
										<i class="fas fa-times"></i> Delete Gambar
									</button>
								</div>
							</div>
						</div>
						<div class="card-footer">
							<button type="submit" class="btn btn-success">
								<i class="fas fa-save" id="btn_save"></i> Simpan
							</button>
						</div>
					</div>
				</form>
			</div>

		</div>
	</div>
</section>