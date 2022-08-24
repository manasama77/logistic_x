<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1>Bonus Royalty</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Home</a></li>
					<li class="breadcrumb-item active">Bonus Royalty</li>
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
						List Bonus Royalty
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-bordered table-striped" id="table_data">
								<thead>
									<tr>
										<th style="min-width: 100px;">Date</th>
										<th style="min-width: 150px;">Member</th>
										<th style="min-width: 150px;">Downline</th>
										<th style="min-width: 90px;">Type Package</th>
										<th style="min-width: 100px;">Package Name</th>
										<th style="min-width: 100px;">Invoice</th>
										<th class="text-right" style="min-width: 50px;">Bonus</th>
									</tr>
								</thead>
								<tbody>
									<?php
									if (count($arr) > 0) :
										foreach ($arr as $key) :
									?>
											<tr>
												<td class="text-center"><?= $key['created_at']; ?></td>
												<td><?= $key['fullname_member']; ?> <small>(<?= $key['user_id_member']; ?>)</small></td>
												<td><?= $key['fullname_downline']; ?> <small>(<?= $key['user_id_downline']; ?>)</small></td>
												<td><?= ucwords($key['type_package']); ?></td>
												<td><?= $key['package_name']; ?></td>
												<td><?= $key['invoice']; ?></td>
												<td class="text-right"><?= $key['bonus']; ?></td>
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
