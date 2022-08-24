<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1>Accounting Rekap</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Home</a></li>
					<li class="breadcrumb-item active">Accounting Rekap</li>
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
					<div class="card-header bg-success">
						<h5 class="card-title">Data Rekap</h5>
						<div class="card-tools">
							<button type="button" class="btn btn-tool" onclick="comingSoon()" title="Print">
								<i class="fas fa-print text-white"></i>
							</button>
							<button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse / Expand">
								<i class="fas fa-minus text-white"></i>
							</button>
						</div>
					</div>
					<div class="card-body">

						<h4>Rekap Penjualan</h4>
						<div class="table-responsive">
							<table class="table table-bordered table-striped" style="width: 100% !important; min-width: 100%;">
								<caption>Rekap Penjualan</caption>
								<thead>
									<tr>
										<th class="text-right" style="min-width: 100px;">Omzet Penjualan</th>
										<th class="text-right" style="min-width: 100px;">Nilai akun habis masa kontrak</th>
										<th class="text-right" style="min-width: 100px;">Nilai Sisa akun aktif</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td class="text-right"><?= $data['total_omzet_penjualan']; ?></td>
										<td class="text-right"><?= $data['total_expired_penjualan']; ?></td>
										<td class="text-right"><?= $data['sisa_piutang_penjualan']; ?></td>
									</tr>
								</tbody>
							</table>
						</div>

						<hr />

						<h4>Rekap Profit</h4>
						<div class="table-responsive">
							<table class="table table-bordered table-striped" style="width: 100% !important; min-width: 100%;">
								<caption>Rekap Profit</caption>
								<thead>
									<tr>
										<th class="text-right" style="min-width: 100px;">Total Profit Sharing</th>
										<th class="text-right" style="min-width: 100px;">Total WD Profit Sharing</th>
										<th class="text-right" style="min-width: 100px;">Sisa profit sharing terhutang</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td class="text-right"><?= $data['sum_profit']; ?></td>
										<td class="text-right"><?= $data['sum_wd_profit']; ?></td>
										<td class="text-right"><?= $data['sisa_piutang_profit']; ?></td>
									</tr>
								</tbody>
							</table>
						</div>

						<hr />

						<h4>Rekap Bonus</h4>
						<div class="table-responsive">
							<table class="table table-bordered table-striped" style="width: 100% !important; min-width: 100%;">
								<caption>Rekap Bonus</caption>
								<thead>
									<tr>
										<th class="text-right" style="min-width: 100px;">Total Bonus Aktif</th>
										<th class="text-right" style="min-width: 100px;">Total WD bonus aktif</th>
										<th class="text-right" style="min-width: 100px;">Sisa bonus aktif terhutang</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td class="text-right"><?= $data['sum_bonus']; ?></td>
										<td class="text-right"><?= $data['sum_wd_bonus']; ?></td>
										<td class="text-right"><?= $data['sisa_piutang_bonus']; ?></td>
									</tr>
								</tbody>
							</table>
						</div>

						<hr />

						<h4>Rekap Reward</h4>
						<div class="table-responsive">
							<table class="table table-bordered table-striped" style="width: 100% !important; min-width: 100%;">
								<caption>Rekap Reward</caption>
								<thead>
									<tr>
										<th class="text-right" style="min-width: 100px;">Total Nilai Reward</th>
										<th class="text-right" style="min-width: 100px;">Total Nilai reward terbayar</th>
										<th class="text-right" style="min-width: 100px;">Sisa Nilai reward terhutang</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td class="text-right"><?= $data['sum_reward']; ?></td>
										<td class="text-right"><?= $data['sum_terbayarkan_reward']; ?></td>
										<td class="text-right"><?= $data['sisa_piutang_reward']; ?></td>
									</tr>
								</tbody>
							</table>
						</div>

					</div>
				</div>
			</div>

		</div>
	</div>
</section>
