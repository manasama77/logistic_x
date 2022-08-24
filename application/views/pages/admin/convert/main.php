<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1>Konversi</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Home</a></li>
					<li class="breadcrumb-item active">Konversi</li>
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
						List Konversi
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-bordered table-striped" id="table_data">
								<thead>
									<tr>
										<th style="min-width: 100px;">Datetime</th>
										<th style="min-width: 100px;">Member</th>
										<th style="min-width: 100px;">Source</th>
										<th class="text-right" style="min-width: 100px;">USDT</th>
										<th class="text-right" style="min-width: 100px;">RATU</th>
										<th class="text-right" style="min-width: 100px;">RATE</th>
									</tr>
								</thead>
								<tbody>
									<?php
									if (count($arr) > 0) :
										foreach ($arr as $key) :
									?>
											<tr>
												<td class="text-center"><?= $key['created_at']; ?></td>
												<td><?= $key['user_id']; ?></td>
												<td><?= $key['source']; ?></td>
												<td class="text-right"><?= $key['amount_usdt']; ?></td>
												<td class="text-right"><?= $key['amount_ratu']; ?></td>
												<td class="text-right"><?= $key['rate']; ?></td>
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
