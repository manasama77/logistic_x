<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1>Master Barang</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Management Barang</a></li>
					<li class="breadcrumb-item active">Master Barang</li>
				</ol>
			</div>
		</div>
	</div>
</section>

<section class="content">
	<div class="container-fluid">
		<div class="row">

			<div class="col-sm-12">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">List Barang</h3>
						<div class="card-tools">
							<a href="<?= base_url('management_barang/master_barang/add'); ?>" class="btn btn-primary">
								<i class="fas fa-plus"></i> Tambah Barang
							</a>
						</div>

					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-bordered table-striped" id="table_data" style="min-width: 900px;">
								<thead>
									<tr>
										<th class="text-center" style="max-width: 80px;">
											<i class="fas fa-cogs"></i>
										</th>
										<th>Kode Barang</th>
										<th>Nama Barang</th>
										<th>Merk</th>
										<th>Qty</th>
										<th>Satuan</th>
										<th>Kategori</th>
										<th>Lokasi</th>
										<th>Supplier</th>
									</tr>
								</thead>
								<tbody>
									<?php
									if ($arr->num_rows() > 0) :
										foreach ($arr->result() as $key) :
									?>
											<tr>
												<td class="text-center">
													<a href="<?= base_url('management_barang/master_barang/edit/' . $key->id); ?>" class="btn btn-info btn-sm" title="Edit">
														<i class="fas fa-pencil-alt"></i>
													</a>
													<button type="button" class="btn btn-danger btn-sm" title="Delete" name="btn_delete_<?= $key->id; ?>" onclick="deleteData('<?= $key->id; ?>', '<?= $key->code; ?>', '<?= $key->name; ?>')">
														<i class="fas fa-trash"></i>
													</button>
												</td>
												<td><?= $key->code; ?></td>
												<td><?= $key->name; ?></td>
												<td><?= $key->merk; ?></td>
												<td><?= $key->qty; ?></td>
												<td><?= $key->unit_name; ?></td>
												<td><?= $key->category_name; ?></td>
												<td><?= $key->location_name; ?></td>
												<td><?= $key->supplier_name; ?></td>
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