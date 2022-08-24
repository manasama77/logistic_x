<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1>Accounting Bonus</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Home</a></li>
					<li class="breadcrumb-item active">Accounting Bonus</li>
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
						<span class="info-box-text">Total Bonus Aktif</span>
						<span class="info-box-number">
							<?= $arr['sum_bonus']; ?> <small>USDT</small>
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
						<span class="info-box-text">Total WD bonus aktif</span>
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
						<span class="info-box-text">Sisa bonus aktif terhutang</span>
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
							<table class="table table-bordered table-striped" id="table_data_1" style="width: 100% !important;">
								<thead>
									<tr>
										<th style="min-width: 150px;">Member</th>
										<th class="text-right" style="min-width: 50px;">Investasi</th>
										<th class="text-right" style="min-width: 120px;">Total Bonus Sposor</th>
										<th class="text-right" style="min-width: 140px;">Total Bonus Q.Leader</th>
										<th class="text-right" style="min-width: 130px;">Total Bonus Royalty</th>
										<th class="text-right" style="min-width: 130px;">Total WD bonus aktif</th>
										<th class="text-right" style="min-width: 170px;">Sisa bonus aktif terhutang</th>
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
												<td class="text-right"><?= $key['bonus_recruitment']; ?></td>
												<td class="text-right"><?= $key['bonus_ql']; ?></td>
												<td class="text-right"><?= $key['bonus_royalty']; ?></td>
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
