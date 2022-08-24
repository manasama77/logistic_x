<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1>Member</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?= site_url('dashboard'); ?>">Beranda</a></li>
					<li class="breadcrumb-item active">Member</li>
				</ol>
			</div>
		</div>
	</div>
</section>

<section class="content">
	<div class="container-fluid">
		<div class="row">

			<div class="col-12">
				<div class="card">
					<div class="card-header">
						List Member
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-bordered table-striped" id="table_data" style="width: 100%;">
								<thead>
									<tr>
										<th class="text-center" style="min-width: 120px;">Tanggal Registrasi</th>
										<th class="text-center" style="min-width: 50px;">KYC</th>
										<th style="min-width: 80px;">User ID</th>
										<th style="min-width: 150px;">Nama Lengkap</th>
										<th style="min-width: 150px;">Email</th>
										<th style="min-width: 80px;">No Telepon</th>
										<th style="min-width: 50px;">Upline</th>
										<th class="text-right" style="min-width: 70px;">Total Asset</th>
										<th class="text-right" style="min-width: 70px;">Jumlah TM</th>
										<th class="text-right" style="min-width: 60px;">Total TM</th>
										<th class="text-right" style="min-width: 70px;">Jumlah CA</th>
										<th class="text-right" style="min-width: 60px;">Total CA</th>
										<th class="text-right" style="min-width: 70px;">Profit Paid</th>
										<th class="text-right" style="min-width: 80px;">Profit Unaid</th>
										<th class="text-right" style="min-width: 50px;">Bonus</th>
										<th class="text-right" style="min-width: 60px;">Ratu</th>
										<th class="text-right" style="min-width: 60px;">WD Profit</th>
										<th class="text-right" style="min-width: 70px;">WD Bonus</th>
										<th class="text-center" style="min-width: 60px;">Downline</th>
										<th class="text-center">Status</th>
									</tr>
								</thead>
								<tbody>
									<?php
									foreach ($arr_member as $key) :
										if ($key['is_active'] == "yes") {
											$badge_color = 'badge-success';
											$badge_text  = 'Active';
										} else {
											$badge_color = 'badge-dark';
											$badge_text  = 'Inactive';
										}
									?>
										<tr>
											<td class="text-center">
												<?= $key['created_at']; ?>
											</td>
											<td class="text-center">
												<?php
												if ($key['is_kyc'] == "check") {
													echo '<button type="button" class="btn btn-sm btn-warning" onclick="modalKYC(\'' . $key['id'] . '\')">' . ucwords($key['is_kyc']) . '</button>';
												} elseif ($key['is_kyc'] == "no") {
													echo '<span class="badge badge-danger">' . ucwords($key['is_kyc']) . '</span>';
												} elseif ($key['is_kyc'] == "yes") {
													echo '<span class="badge badge-success">' . ucwords($key['is_kyc']) . '</span>';
												}
												?>
											</td>
											<td>
												<?= $key['user_id']; ?>
											</td>
											<td>
												<?= $key['fullname']; ?>
											</td>
											<td>
												<?= $key['email']; ?>
											</td>
											<td>
												<?= $key['phone_number']; ?>
											</td>
											<td>
												<?= $key['upline_user_id']; ?>
											</td>
											<td class="text-right">
												<?= $key['total_omset']; ?>
											</td>
											<td class="text-right">
												<?= $key['count_trade_manager']; ?>
											</td>
											<td class="text-right">
												<?= $key['total_invest_trade_manager']; ?>
											</td>
											<td class="text-right">
												<?= $key['count_crypto_asset']; ?>
											</td>
											<td class="text-right">
												<?= $key['total_invest_crypto_asset']; ?>
											</td>
											<td class="text-right">
												<?= $key['profit_paid']; ?>
											</td>
											<td class="text-right">
												<?= $key['profit_unpaid']; ?>
											</td>
											<td class="text-right">
												<?= $key['bonus']; ?>
											</td>
											<td class="text-right">
												<?= $key['ratu']; ?>
											</td>
											<td class="text-right">
												<?= $key['wd_profit']; ?>
											</td>
											<td class="text-right">
												<?= $key['wd_bonus']; ?>
											</td>
											<td class="text-center">
												<span class="badge badge-warning">
													<i class="fas fa-users"></i> <?= $key['count_downline']; ?> Member
												</span>
											</td>
											<td class="text-center">
												<span class="badge <?= $badge_color; ?>" style="cursor: pointer;" onclick="changeStatus('<?= $key['id']; ?>', '<?= $key['email']; ?>', '<?= $key['is_active']; ?>')"><?= $badge_text; ?></span>
											</td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</section>

<div class="modal fade" id="modal_kyc" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel">Data KYC</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<table class="table">
					<div class="thead">
						<tr>
							<th>Nama Lengkap</th>
							<th id="fullname"></th>
						</tr>
						<tr>
							<th>No KTP</th>
							<th id="id_card_number"></th>
						</tr>
						<tr>
						<tr>
							<th>Negara</th>
							<th id="country_code"></th>
						</tr>
						<tr>
							<th>Alamat</th>
							<th id="address"></th>
						</tr>
						<tr>
							<th>Kode POS</th>
							<th id="postal_code"></th>
						</tr>
						<tr>
							<th>Bank</th>
							<th id="nama_bank"></th>
						</tr>
						<tr>
							<th>No Rekening</th>
							<th id="no_rekening"></th>
						</tr>
						<tr>
							<th>Foto KTP</th>
							<th id="foto_ktp"></th>
						</tr>
						<tr>
							<th>Foto Pegang KTP</th>
							<th id="foto_pegang_ktp"></th>
						</tr>
					</div>
				</table>
			</div>
			<div class="modal-footer">
				<input type="hidden" id="id_member" name="id_member" />
				<button type="button" id="btn_terima_kyc" class="btn btn-primary" onclick="terimaKYC()">Terima KYC</button>
				<button type="button" class="btn btn-danger" onclick="modalTolakKYC()">Tolak KYC</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
			</div>
		</div>
	</div>
</div>

<form id="form_tolak_kyc">
	<div class="modal fade" id="modal_tolak_kyc" data-backdrop="static" data-keyboard="false" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="staticBackdropLabel">Alasan Tolak KYC</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="alasan">Alasan</label>
						<textarea class="form-control" name="alasan" id="alasan" cols="30" rows="3" placeholder="Masukan Alasan Penolakan KYC" required></textarea>
					</div>
				</div>
				<div class="modal-footer">
					<input type="hidden" id="id_member_tolak" name="id_member" />
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button id="btn_tolak_kyc" type="submit" class="btn btn-danger">Proses Tolak KYC</button>
				</div>
			</div>
		</div>
	</div>
</form>
