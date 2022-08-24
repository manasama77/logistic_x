<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1>Crypto Asset</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Home</a></li>
					<li class="breadcrumb-item active">Crypto Asset</li>
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
						List Crypto Asset
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-bordered table-striped" id="table_data">
								<thead>
									<tr>
										<th style="min-width: 100px;">Register Date</th>
										<th style="min-width: 170px;">Member</th>
										<th style="min-width: 100px;">Invoice</th>
										<th style="min-width: 50px;">Package</th>
										<th class="text-right" style="min-width: 70px;">Investment</th>
										<th style="min-width: 120px;" class="text-right">Profit Member/Day</th>
										<th style="min-width: 110px;" class="text-right">Profit Upline/Day</th>
										<th style="min-width: 130px;" class="text-right">Profit Company/Day</th>
										<th style="min-width: 80px;" class="text-right">Profit Asset</th>
										<th class="text-center" style="min-width: 80px;">Expired Date</th>
										<th class="text-center" style="min-width: 60px;">Status</th>
									</tr>
								</thead>
								<tbody>
									<?php
									if (count($arr) > 0) :
										foreach ($arr as $key) :
									?>
											<tr>
												<td class="text-center"><?= $key['created_at']; ?></td>
												<td><?= $key['buyer_name']; ?> <small>(<?= $key['buyer_email']; ?>)</small></td>
												<td><?= $key['invoice']; ?></td>
												<td><?= $key['package_name']; ?></td>
												<td class="text-right"><?= $key['amount']; ?></td>
												<td class="text-right"><?= $key['profit_self_per_day']; ?></td>
												<td class="text-right"><?= $key['profit_upline_per_day']; ?></td>
												<td class="text-right"><?= $key['profit_company_per_day']; ?></td>
												<td class="text-right"><?= $key['amount_profit']; ?></td>
												<td class="text-center"><?= $key['expired_at']; ?></td>
												<td class="text-center"><?= $key['state_badge']; ?></td>
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

<form id="form_reset">
	<div class="modal fade" id="modal_reset" data-backdrop="static" data-keyboard="false" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="staticBackdropLabel">Reset Password</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="email_reset">Email</label>
						<input type="text" class="form-control" id="email_reset" name="email_reset" required readonly>
					</div>
					<div class="form-group">
						<label for="password_reset">New Password</label>
						<input type="password" class="form-control" id="password_reset" name="password_reset" required>
					</div>
				</div>
				<div class="modal-footer">
					<input type="hidden" id="id_reset" name="id_reset">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Submit</button>
				</div>
			</div>
		</div>
	</div>
</form>
