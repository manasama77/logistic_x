<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1>Withdraw</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Home</a></li>
					<li class="breadcrumb-item active">Withdraw</li>
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
						List Withdraw
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-bordered table-striped" id="table_data">
								<thead>
									<tr>
										<th style="min-width: 100px;">Tanggal</th>
										<th style="min-width: 100px;">Member</th>
										<th style="min-width: 100px;">Invoice</th>
										<th style="min-width: 100px;">Source</th>
										<th class="text-right" style="min-width: 100px;">From</th>
										<th class="text-right" style="min-width: 100px;">To</th>
										<th style="min-width: 130px;">Wallet Address</th>
										<th style="min-width: 130px;">TX ID</th>
										<th class="text-center" style="min-width: 100px;">Status</th>
									</tr>
								</thead>
								<tbody>
									<?php
									if (count($arr) > 0) :
										foreach ($arr as $key) :
									?>
											<tr>
												<td class="text-center"><?= $key['created_at']; ?></td>
												<td><?= $key['fullname']; ?><br /><small>(<?= $key['email']; ?>)</small></td>
												<td><?= $key['invoice']; ?></td>
												<td><?= ucwords($key['source']); ?></td>
												<td class="text-right"><?= $key['amount_1']; ?> <small>USDT</small></td>
												<td class="text-right"><?= $key['amount_2']; ?> <small><?= $key['currency_2']; ?></small></td>
												<td><small><?= $key['wallet_address']; ?></small></td>
												<td><small><?= $key['tx_id']; ?></small></td>
												<td class="text-center"><?= ucwords($key['state']); ?></td>
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
