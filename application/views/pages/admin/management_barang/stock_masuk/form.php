<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-12 col-md-4">
				<h1>Tambah Stock Masuk</h1>
			</div>
			<div class="col-sm-12 col-md-8">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Management Stock Masuk</a></li>
					<li class="breadcrumb-item"><a href="<?= base_url('management_barang/stock_masuk'); ?>">Management Stock Masuk</a></li>
					<li class="breadcrumb-item active">Tambah Stock Masuk</li>
				</ol>
			</div>
		</div>
	</div>
</section>

<section class="content">
	<div class="container-fluid">
		<div class="row">

			<div class="col-sm-12">
				<form id="form">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">Form Stock Masuk</h3>
							<div class="card-tools">
								<a href="<?= base_url('management_barang/stock_masuk'); ?>" class="btn btn-secondary">
									<i class="fas fa-chevron-left"></i> Kembali Ke List Stock Masuk
								</a>
							</div>

						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-sm-12 col-md-4">
									<div class="form-group">
										<label for="request_date">Tanggal Jam Request <span class="text-danger">*</span></label>
										<div class="input-group">
											<input type="date" class="form-control" id="request_date" name="request_date" placeholder="Tanggal Request" required />
											<input type="time" class="form-control" id="request_time" name="request_time" placeholder="Jam Request" required />
										</div>
									</div>
									<div class="form-group">
										<label for="code">Kode Stock Masuk <span class="text-danger">*</span></label>
										<input type="text" class="form-control" id="code" name="code" placeholder="Kode Stock Masuk" required />
										<div class="form-check">
											<input type="checkbox" class="form-check-input" id="auto_generate_code" name="auto_generate_code" value="yes" />
											<label for="auto_generate_code" class="form-check-label">Auto Generate Code</label>
										</div>
									</div>
									<div class="form-group">
										<label for="no_po">No PO</label>
										<input type="text" class="form-control" id="no_po" name="no_po" placeholder="No PO" />
									</div>
									<div class="form-group">
										<label for="no_do">No DO</label>
										<input type="text" class="form-control" id="no_do" name="no_do" placeholder="No DO" />
									</div>
									<div class="form-group">
										<label for="description">Keterangan</label>
										<textarea class="form-control" id="description" name="description" placeholder="Keterangan"></textarea>
									</div>
								</div>
								<div class="col-sm-12 col-md-3">
									<div class="form-group">
										<label for="item_id">Barang</label>
										<select class="form-control" id="item_id" name="item_id">
											<option value=""></option>
											<?php foreach ($item->result() as $key) { ?>
												<option value="<?= $key->id; ?>" data-satuan="<?= $key->unit_name; ?>">(<?= $key->code; ?>) <?= $key->name; ?></option>
											<?php } ?>
										</select>
									</div>
									<div class="form-group">
										<label for="qty">Qty</label>
										<input type="number" class="form-control" id="qty" name="qty" placeholder="Qty" />
									</div>
									<div class="form-group">
										<button type="button" class="btn btn-primary btn-block" id="btn_add">
											<i class="fas fa-plus"></i> Tambah Barang
										</button>
									</div>
								</div>
								<div class="col-sm-12 col-md-5">
									<div class="table-responsive">
										<table class="table table-bordered">
											<caption>List Stock Masuk</caption>
											<thead class="bg-info">
												<tr>
													<th class="text-center"><i class="fas fa-cog"></i></th>
													<th>Barang</th>
													<th>Qty</th>
												</tr>
											</thead>
											<tbody id="v_list">
												<tr>
													<td colspan="3" class="text-center">Data Kosong</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
						<div class="card-footer">
							<button type="submit" class="btn btn-success" id="btn_save">
								<i class="fas fa-save"></i> Simpan
							</button>
						</div>
					</div>
				</form>
			</div>

		</div>
	</div>
</section>