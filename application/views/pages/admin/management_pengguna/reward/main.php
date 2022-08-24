<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1>Accounting Reward</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Home</a></li>
					<li class="breadcrumb-item active">Accounting Reward</li>
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
						<span class="info-box-text">Total Nilai Reward</span>
						<span class="info-box-number">
							<?= $arr['sum_reward']; ?> <small>USDT</small>
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
						<span class="info-box-text">Total Nilai reward terbayar</span>
						<span class="info-box-number">
							<?= $arr['sum_terbayarkan']; ?> <small>USDT</small>
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
						<span class="info-box-text">Sisa Nilai reward
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
						<h5 class="card-title">List Reward</h5>
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
										<th style="min-width: 100px;">Reward</th>
										<th class="text-right" style="min-width: 100px;">Nilai Reward</th>
										<th class="text-right" style="min-width: 100px;">Nilai reward terbayar</th>
										<th class="text-right" style="min-width: 100px;">Sisa Nilai reward
											terhutang</th>
									</tr>
								</thead>
								<tbody>
									<?php
									if (count($arr['data_reward']) > 0) :
										foreach ($arr['data_reward'] as $key) :
									?>
											<tr>
												<td><?= $key['reward']; ?></td>
												<td class="text-right"><?= $key['price']; ?></td>
												<td class="text-right"><?= $key['terbayarkan']; ?></td>
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
