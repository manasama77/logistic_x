<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1>Accounting Profit</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Home</a></li>
					<li class="breadcrumb-item active">Accounting Profit</li>
				</ol>
			</div>
		</div>
	</div>
</section>

<section class="content">
	<div class="container-fluid">
		<div class="row">

			<div class="col-sm-12 col-md-4">
				<div class="info-box">
					<span class="info-box-icon bg-success elevation-1">
						<i class="fas fa-coins"></i>
					</span>
					<div class="info-box-content">
						<span class="info-box-text">Total Profit Sharing</span>
						<span class="info-box-number">
							<?= $arr['sum_profit']; ?> <small>USDT</small>
						</span>
					</div>
				</div>
			</div>

			<div class="col-sm-12 col-md-4">
				<div class="info-box">
					<span class="info-box-icon bg-warning elevation-1">
						<i class="fas fa-coins"></i>
					</span>
					<div class="info-box-content">
						<span class="info-box-text">Total WD Profit Sharing</span>
						<span class="info-box-number">
							<?= $arr['sum_wd']; ?> <small>USDT</small>
						</span>
					</div>
				</div>
			</div>

			<div class="col-sm-12 col-md-4">
				<div class="info-box">
					<span class="info-box-icon bg-dark elevation-1">
						<i class="fas fa-coins"></i>
					</span>
					<div class="info-box-content">
						<span class="info-box-text">Sisa profit sharing
							terhutang</span>
						<span class="info-box-number">
							<?= $arr['sisa_piutang']; ?> <small>USDT</small>
						</span>
					</div>
				</div>
			</div>

			<div class="col-12">
				<div class="card">
					<div class="card-header bg-success">
						<h5 class="card-title">List Member</h5>
						<div class="card-tools">
							<button type="button" class="btn btn-tool" data-card-widget="collapse">
								<i class="fas fa-minus text-white"></i>
							</button>
						</div>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-bordered table-striped" id="table_data_1" style="width: 100% !important; min-width: 100%;">
								<thead>
									<tr>
										<th style="min-width: 100px;">Member</th>
										<th class="text-right" style="min-width: 100px;">Investasi</th>
										<th class="text-right" style="min-width: 100px;">Total Profit Sharing</th>
										<th class="text-right" style="min-width: 100px;">Total WD Profit Sharing</th>
										<th class="text-right" style="min-width: 100px;">Sisa profit sharing terhutang</th>
									</tr>
								</thead>
								<tbody>
									<?php
									if (count($arr['data_paket']) > 0) :
										foreach ($arr['data_paket'] as $key) :
									?>
											<tr>
												<td><?= $key['fullname']; ?> <small>(<?= $key['user_id']; ?>)</small></td>
												<td class="text-right"><?= $key['investasi']; ?></td>
												<td class="text-right"><?= $key['total_profit']; ?></td>
												<td class="text-right"><?= $key['total_wd']; ?></td>
												<td class="text-right"><?= $key['sisa_piutang']; ?></td>
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
