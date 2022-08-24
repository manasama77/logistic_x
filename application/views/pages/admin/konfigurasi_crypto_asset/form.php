<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1>Tambah Konfigurasi Crypto Asset</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?= site_url('crypto_asset/konfigurasi'); ?>">Konfigurasi Crypto Asset</a></li>
					<li class="breadcrumb-item active">Tambah Konfigurasi Crypto Asset</li>
				</ol>
			</div>
		</div>
	</div>
</section>

<section class="content">
	<div class="container-fluid">
		<form id="form">
			<div class="row">
				<div class="col-sm-12 col-md-4">
					<div class="form-group">
						<label for="id_package_crypto_asset">Paket Crypto Asset</label>
						<select class="form-control" id="id_package_crypto_asset" name="id_package_crypto_asset" required>
							<option value="" selected disabled>-Pilih Paket Crypto Asset-</option>
							<?php foreach ($arr_package as $item) : ?>
								<option value="<?= $item['id']; ?>"><?= $item['name']; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12 col-md-4">
					<div class="card">
						<div class="card-header">
							Informasi Dasar Paket
						</div>
						<div class="card-body">
							<div class="form-group">
								<label for="code">Kode Paket</label>
								<input type="text" class="form-control-plaintext elevation-1 pl-2" id="code" name="code" required />
							</div>
							<div class="form-group">
								<label for="name">Nama Paket</label>
								<input type="text" class="form-control-plaintext elevation-1 pl-2" id="name" name="name" required />
							</div>
							<div class="form-group">
								<label for="contract_duration">Durasi Paket</label>
								<div class="input-group">
									<input type="text" class="form-control-plaintext elevation-1 pl-2" id="contract_duration" name="contract_duration" required />
									<div class="input-group-append">
										<span class="input-group-text bg-dark">Hari</span>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="amount">Nilai Investasi</label>
								<input type="text" class="form-control-plaintext elevation-1 pl-2" id="amount" name="amount" required />
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-12 col-md-8">
					<div class="card">
						<div class="card-header">
							Set Paket
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-sm-12 col-md-6">
									<div class="form-group">
										<label for="tanggal_aktif">Tanggal Aktif</label>
										<div class="input-group">
											<input type="date" class="form-control" id="tanggal_aktif" name="tanggal_aktif" min="<?= $tgl_obj->modify('+1 day')->format('Y-m-d'); ?>" required />
											<div class="input-group-append">
												<span class="input-group-text bg-dark">
													<i class="fas fa-calendar"></i>
												</span>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label for="profit_per_month_percent">Persentase Profit Per Bulan</label>
										<div class="input-group">
											<input type="number" class="form-control" id="profit_per_month_percent" name="profit_per_month_percent" step="1" min="1" max="99" required />
											<div class="input-group-append">
												<span class="input-group-text bg-dark">%</span>
											</div>
										</div>
									</div>
								</div>
								<div class="col-sm-12 col-md-6">
									<div class="form-group">
										<label for="share_self_percentage">Persentase Share Profit Member</label>
										<div class="input-group">
											<input type="number" class="form-control" id="share_self_percentage" name="share_self_percentage" step="0.1" min="1" max="99" required />
											<div class="input-group-append">
												<span class="input-group-text bg-dark">%</span>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label for="share_upline_percentage">Persentase Share Profit Upline</label>
										<div class="input-group">
											<input type="number" class="form-control" id="share_upline_percentage" name="share_upline_percentage" step="0.1" min="1" max="99" required />
											<div class="input-group-append">
												<span class="input-group-text bg-dark">%</span>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label for="share_company_percentage">Persentase Share Profit Perusahaan</label>
										<div class="input-group">
											<input type="number" class="form-control" id="share_company_percentage" name="share_company_percentage" step="0.1" min="1" max="99" required />
											<div class="input-group-append">
												<span class="input-group-text bg-dark">%</span>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="card-footer">
							<div class="row">
								<div class="col-12">
									<div class="blob-container">
										<div id="alert_persentase" class="alert alert-danger blob red" style="display: none;">
											<strong>Total Persentase Share Profit Melebihi 100%</strong>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							Nilai Crypto Asset
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-sm-12 col-md-4">
									<div class="form-group">
										<label for="profit_per_month_value">Profit Per Bulan</label>
										<div class="input-group">
											<input type="text" class="form-control-plaintext elevation-1 p-1" id="profit_per_month_value" name="profit_per_month_value" required readonly />
											<div class="input-group-append">
												<span class="input-group-text bg-dark">USDT / bulan</span>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label for="profit_per_day_percentage">Profit Per Hari</label>
										<div class="input-group">
											<input type="text" class="form-control-plaintext elevation-1 p-1" id="profit_per_day_percentage" name="profit_per_day_percentage" required readonly />
											<div class="input-group-append">
												<span class="input-group-text bg-dark">%</span>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label for="profit_per_day_value">Profit Per Hari</label>
										<div class="input-group">
											<input type="text" class="form-control-plaintext elevation-1 p-1" id="profit_per_day_value" name="profit_per_day_value" required readonly />
											<div class="input-group-append">
												<span class="input-group-text bg-dark">USDT / hari</span>
											</div>
										</div>
									</div>
								</div>
								<div class="col-sm-12 col-md-4 offset-md-2">
									<div class="form-group">
										<label for="share_self_value">Share Profit Member</label>
										<div class="input-group">
											<input type="text" class="form-control-plaintext elevation-1 p-1" id="share_self_value" name="share_self_value" required readonly />
											<div class="input-group-append">
												<span class="input-group-text bg-dark">USDT / hari</span>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label for="share_upline_value">Share Profit Upline</label>
										<div class="input-group">
											<input type="text" class="form-control-plaintext elevation-1 p-1" id="share_upline_value" name="share_upline_value" required readonly />
											<div class="input-group-append">
												<span class="input-group-text bg-dark">USDT / hari</span>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label for="share_company_value">Share Profit Perusahaan</label>
										<div class="input-group">
											<input type="text" class="form-control-plaintext elevation-1 p-1" id="share_company_value" name="share_company_value" required readonly />
											<div class="input-group-append">
												<span class="input-group-text bg-dark">USDT / hari</span>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="col-12">
					<button type="submit" class="btn btn-primary btn-block">Submit</button>
					<a href="<?= site_url('crypto_asset/konfigurasi'); ?>" class="btn btn-secondary btn-block">Back to List</a>
				</div>

			</div>
		</form>
	</div>
</section>
