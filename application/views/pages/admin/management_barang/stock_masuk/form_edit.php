<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-12 col-md-4">
				<h1>Edit Stock Masuk</h1>
			</div>
			<div class="col-sm-12 col-md-8">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Management Stock Masuk</a></li>
					<li class="breadcrumb-item"><a href="<?= base_url('management_barang/stock_masuk'); ?>">Management Stock Masuk</a></li>
					<li class="breadcrumb-item active">Edit Stock Masuk</li>
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
											<?php
											$request_datetime_obj = new DateTime($arr[0]['request_datetime']);
											?>
											<input type="date" class="form-control" id="request_date" name="request_date" placeholder="Tanggal Request" value="<?= $request_datetime_obj->format('Y-m-d'); ?>" required />
											<input type="time" class="form-control" id="request_time" name="request_time" placeholder="Jam Request" value="<?= $request_datetime_obj->format('H:i'); ?>" required />
										</div>
									</div>
									<div class="form-group">
										<label for="code">Kode Stock Masuk <span class="text-danger">*</span></label>
										<?php $readonly = ($arr[0]['state'] == "Proses") ? "readonly" : null; ?>
										<input type="text" class="form-control" id="code" name="code" placeholder="Kode Stock Masuk" value="<?= $arr[0]['code']; ?>" <?= $readonly; ?> required />
										<input type="hidden" id="old_code" name="old_code" value="<?= $arr[0]['code']; ?>" required />
										<?php $disabled = ($arr[0]['state'] == "Proses") ? "disabled" : null; ?>
										<div class="form-check">
											<input type="checkbox" class="form-check-input" id="auto_generate_code" name="auto_generate_code" value="yes" <?= $disabled; ?> />
											<label for="auto_generate_code" class="form-check-label">Auto Generate Code</label>
										</div>
									</div>
									<div class="form-group">
										<label for="no_po">No PO</label>
										<input type="text" class="form-control" id="no_po" name="no_po" placeholder="No PO" value="<?= $arr[0]['no_po']; ?>" />
									</div>
									<div class="form-group">
										<label for="no_do">No DO</label>
										<input type="text" class="form-control" id="no_do" name="no_do" placeholder="No DO" value="<?= $arr[0]['no_do']; ?>" />
									</div>
									<div class="form-group">
										<label for="description">Keterangan</label>
										<textarea class="form-control" id="description" name="description" placeholder="Keterangan"><?= $arr[0]['description']; ?></textarea>
									</div>
								</div>
								<?php if (!$arr[0]['no_po']) { ?>
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
												<i class="fas fa-plus"></i> Edit Barang
											</button>
										</div>
									</div>
								<?php } ?>
								<?php $col = (!$arr[0]['no_po']) ? "col-md-5" : "col-md-8" ?>
								<div class="col-sm-12 <?= $col; ?>">
									<div class="table-responsive">
										<?php $width = ($arr[0]['no_po']) ? "min-width: 950px;" : null ?>
										<table class="table table-bordered table-sm" style="<?= $width; ?>">
											<caption>List Stock Masuk</caption>
											<thead class="bg-info">
												<tr>
													<?php if (!$arr[0]['no_po']) { ?>
														<th class="text-center"><i class="fas fa-cog"></i></th>
													<?php } ?>
													<th>Barang</th>
													<th>Qty Request</th>
													<?php if ($arr[0]['no_po']) { ?>
														<th style="min-width: 120px;">Qty Diterima</th>
														<th style="min-width: 250px;">Tanggal & Jam Diterima</th>
														<th>Keterangan</th>
													<?php } ?>
												</tr>
											</thead>
											<tbody id="v_list">
												<tr>
													<?php $colspan = ($arr[0]['no_po']) ? 5 : 3 ?>
													<td colspan="<?= $colspan; ?>" class="text-center">Data Kosong</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
						<div class="card-footer">
							<input type="hidden" id="id_edit" name="id" value="<?= $arr[0]['id']; ?>" />
							<input type="hidden" id="state" value="<?= $arr[0]['state']; ?>" />
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