<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1>Stock Masuk</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Management Stock Masuk</a></li>
					<li class="breadcrumb-item active">Stock Masuk</li>
				</ol>
			</div>
		</div>
	</div>
</section>

<section class="content">
	<div class="container-fluid">
		<div class="row">

			<div class="col-12">
				<form id="form_filter" method="get">
					<div class="row mb-3">
						<div class="col">
							<div class="input-group">
								<div class="input-group-prepend">
									<label class="input-group-text" for="from_request_datetime"><i class="fas fa-calendar"></i></label>
								</div>
								<input type="text" class="form-control form-control-sm" id="from_request_datetime" name="from_request_datetime" placeholder="Dari Tanggal" value="<?= $from_date; ?>" />
							</div>
						</div>
						<div class="col">
							<div class="input-group">
								<div class="input-group-prepend">
									<label class="input-group-text" for="to_request_datetime"><i class="fas fa-calendar"></i></label>
								</div>
								<input type="text" class="form-control form-control-sm" id="to_request_datetime" name="to_request_datetime" placeholder="Sampai Tanggal" value="<?= $to_date; ?>" />
							</div>
						</div>
						<div class="col">
							<input type="text" class="form-control form-control-sm" id="no_po" name="no_po" placeholder="No PO" value="<?= $no_po; ?>" />
						</div>
						<div class="col">
							<input type="text" class="form-control form-control-sm" id="no_do" name="no_do" placeholder="No DO" value="<?= $no_do; ?>" />
						</div>
						<div class="col">
							<select class="form-control form-control-sm" id="state" name="state">
								<option <?= ($state == "All") ? "selected" : null; ?> value="All">Semua Status</option>
								<option <?= ($state == "Menunggu") ? "selected" : null; ?> value="Menunggu">Menunggu</option>
								<option <?= ($state == "Proses") ? "selected" : null; ?> value="Proses">Proses</option>
								<option <?= ($state == "Tolak") ? "selected" : null; ?> value="Tolak">Tolak</option>
								<option <?= ($state == "Partial") ? "selected" : null; ?> value="Partial">Partial</option>
								<option <?= ($state == "Selesai") ? "selected" : null; ?> value="Selesai">Selesai</option>
							</select>
						</div>
						<div class="col">
							<select class="form-control form-control-sm" id="item_id" name="item_id">
								<option <?= ($state == "All") ? "selected" : null; ?> value="All">Semua Barang</option>
								<?php foreach ($item->result() as $key) { ?>
									<option <?= ($item_id == $key->id) ? "selected" : null; ?> value="<?= $key->id; ?>">(<?= $key->code; ?>) <?= $key->name; ?></option>
								<?php } ?>
							</select>
						</div>
						<div class="col">
							<button type="submit" class="btn btn-primary btn-sm" title="Filter Data">
								<i class="fas fa-search"></i>
							</button>
							<a href="<?= base_url('management_barang/stock_masuk'); ?>" class="btn btn-dark btn-sm" title="Reset Data">
								<i class="fas fa-redo-alt"></i>
							</a>
						</div>
					</div>
				</form>
			</div>

			<div class="col-sm-12">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">List Stock Masuk</h3>
						<div class="card-tools">
							<a href="<?= base_url('management_barang/stock_masuk/add'); ?>" class="btn btn-primary">
								<i class="fas fa-plus"></i> Tambah Stock Masuk
							</a>
						</div>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-bordered table-striped" id="table_data" style="min-width: 1500px;">
								<thead>
									<tr>
										<th class="text-center" style="min-width: 80px;">
											Aksi
										</th>
										<th>Tanggal & Jam Request</th>
										<th style="min-width: 100px;">Kode Request</th>
										<th>No PO</th>
										<th>No DO</th>
										<th>Status</th>
										<th>Barang Masuk</th>
										<th>Qty Request</th>
										<th>Qty Diterima</th>
										<th>Tanggal & Jam Diterima</th>
									</tr>
								</thead>
								<tbody>
									<?php
									if (count($arr) > 0) :
										foreach ($arr as $key) :
									?>
											<tr>
												<td class="text-center">
													<?php
													$rules_edit    = ["Selesai", "Partial", "Tolak", "Proses"];
													$disabled_edit = (in_array($key['state'], $rules_edit) === true) ? "disabled" : null;

													$rules_delete    = ["Selesai", "Partial", "Tolak", "Proses"];
													$disabled_delete = (in_array($key['state'], $rules_delete) === true) ? "disabled" : null;
													?>
													<a href="<?= base_url('management_barang/stock_masuk/edit/' . $key['id']); ?>" class="btn btn-info btn-sm <?= $disabled_edit; ?>" title="Edit">
														<i class="fas fa-pencil-alt"></i>
													</a>
													<button type="button" class="btn btn-danger btn-sm" title="Delete" name="btn_delete_<?= $key['id']; ?>" onclick="deleteData('<?= $key['id']; ?>', '<?= $key['code']; ?>')" <?= $disabled_delete; ?>>
														<i class="fas fa-trash"></i>
													</button>
													<button type="button" class="btn btn-success btn-sm" title="Detail" name="btn_detail_<?= $key['id']; ?>" onclick="viewDetail('<?= $key['id']; ?>')">
														<i class="fas fa-eye"></i>
													</button>
												</td>
												<td><?= $key['request_datetime_formated']; ?></td>
												<td><?= $key['code']; ?></td>
												<td><?= $key['no_po']; ?></td>
												<td><?= $key['no_do']; ?></td>
												<td><?= $key['state']; ?></td>
												<td><?= $key['items']; ?></td>
												<td><?= $key['qty_requests']; ?></td>
												<td><?= $key['qty_receives']; ?></td>
												<td><?= $key['datetime_receives']; ?></td>
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

		</div>
	</div>
</section>

<form id="form_detail">
	<div class="modal fade" id="modal_detail" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="staticBackdropLabel">Detail</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<h3>Info Request</h3>
					<div class="table-responsive">
						<table class="table">
							<tbody>
								<tr>
									<td style="width: 180px;">Tanggal & Jam Request</td>
									<td style="width: 10px;">:</td>
									<td id="v_request_datetime"></td>
								</tr>
								<tr>
									<td>Kode Request</td>
									<td>:</td>
									<td id="v_code"></td>
								</tr>
								<tr>
									<td>Status</td>
									<td>:</td>
									<td>
										<select class="form-control col-md-4" id="v_state" name="state">
											<option value="Menunggu">Menunggu</option>
											<option value="Proses">Proses</option>
											<option value="Tolak">Tolak</option>
											<option value="Partial">Partial</option>
											<option value="Selesai">Selesai</option>
										</select>
									</td>
								</tr>
								<tr>
									<td>Nomor PO</td>
									<td>:</td>
									<td>
										<input type="text" class="form-control col-md-4" id="v_no_po" name="no_po" />
									</td>
								</tr>
								<tr>
									<td>Nomor DO</td>
									<td>:</td>
									<td>
										<input type="text" class="form-control col-md-4" id="v_no_do" name="no_do" disabled />
									</td>
								</tr>
								<tr>
									<td>Keterangan</td>
									<td>:</td>
									<td id="v_description"></td>
								</tr>
							</tbody>
						</table>
					</div>
					<hr />
					<h3>List Barang</h3>
					<div class="table-responsive">
						<table class="table table-bordered table-sm">
							<thead class="bg-black">
								<tr>
									<th>Barang</th>
									<th>Qty Request</th>
									<th class="text-center">Qty Diterima</th>
									<th class="text-center">Tanggal Diterima</th>
									<th class="text-center">Status</th>
								</tr>
							</thead>
							<tbody id="v_items">
								<tr>
									<td colspan="5" class="text-center">Data Kosong</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="modal-footer">
					<input type="hidden" id="v_id" name="id" />
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary" id="btn_save">
						<i class="fas fa-save"></i> Simpan
					</button>
				</div>
			</div>
		</div>
	</div>
</form>