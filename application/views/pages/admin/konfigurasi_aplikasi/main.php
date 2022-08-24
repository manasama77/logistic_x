<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1>Konfigurasi Aplikasi</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?= site_url('dashboard'); ?>">Beranda</a></li>
					<li class="breadcrumb-item active">Konfigurasi Aplikasi</li>
				</ol>
			</div>
		</div>
	</div>
</section>

<section class="content">
	<div class="container-fluid">
		<?php if ($this->session->flashdata('success')) : ?>
			<div class="alert alert-success">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<strong><?= $this->session->flashdata('success'); ?></strong>
			</div>
		<?php endif; ?>

		<form id="form" action="<?= site_url('konfigurasi/aplikasi/update'); ?>" method="post">
			<div class="row">
				<div class="col-sm-12 col-md-3 offset-md-1 mb-3">
					<div class="form-group">
						<label for="email_admin_1">Admin 1 - Email</label>
						<input type="email" class="form-control" id="email_admin_1" name="email_admin_1" value="<?= $arr->row()->email_admin_1; ?>" required />
					</div>
					<div class="form-group">
						<label for="email_alias_1">Admin 1 - Alias</label>
						<input type="text" class="form-control" id="email_alias_1" name="email_alias_1" value="<?= $arr->row()->email_alias_1; ?>" required />
					</div>
					<div class="form-group">
						<label for="wa_admin_1">Admin 1 - Whatsapp</label>
						<input type="tel" class="form-control" id="wa_admin_1" name="wa_admin_1" value="<?= $arr->row()->wa_admin_1; ?>" required />
					</div>
					<div class="form-group">
						<label for="email_admin_2">Admin 2 - Email</label>
						<input type="email" class="form-control" id="email_admin_2" name="email_admin_2" value="<?= $arr->row()->email_admin_2; ?>" required />
					</div>
					<div class="form-group">
						<label for="email_alias_2">Admin 2 - Alias</label>
						<input type="text" class="form-control" id="email_alias_2" name="email_alias_2" value="<?= $arr->row()->email_alias_2; ?>" required />
					</div>
					<div class="form-group">
						<label for="wa_admin_2">Admin 2 - Whatsapp</label>
						<input type="tel" class="form-control" id="wa_admin_2" name="wa_admin_2" value="<?= $arr->row()->wa_admin_2; ?>" required />
					</div>
				</div>
				<div class="col-sm-12 col-md-3 mb-3">
					<div class="form-group">
						<label for="limit_withdraw">Limit Withdraw</label>
						<input type="number" class="form-control" id="limit_withdraw" name="limit_withdraw" min="1" max="9999999" value="<?= $arr->row()->limit_withdraw; ?>" required />
					</div>
					<div class="form-group">
						<label for="bonus_sponsor">Bonus Sponsor</label>
						<div class="input-group">
							<input type="number" class="form-control" id="bonus_sponsor" name="bonus_sponsor" min="0.01" max="100" step="0.01" value="<?= $arr->row()->bonus_sponsor; ?>" required />
							<div class="input-group-append">
								<div class="input-group-text bg-dark">%</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="bonus_ql">Bonus Kualifikasi Leader</label>
						<div class="input-group">
							<input type="number" class="form-control" id="bonus_ql" name="bonus_ql" min="0.01" max="100" step="0.01" value="<?= $arr->row()->bonus_ql; ?>" required />
							<div class="input-group-append">
								<div class="input-group-text bg-dark">%</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="bonus_g2">Bonus Royalty G2</label>
						<div class="input-group">
							<input type="number" class="form-control" id="bonus_g2" name="bonus_g2" min="0.01" max="100" step="0.01" value="<?= $arr->row()->bonus_g2; ?>" required />
							<div class="input-group-append">
								<div class="input-group-text bg-dark">%</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="bonus_g3_g7">Bonus Royalty G3 - G7</label>
						<div class="input-group">
							<input type="number" class="form-control" id="bonus_g3_g7" name="bonus_g3_g7" min="0.01" max="100" step="0.01" value="<?= $arr->row()->bonus_g3_g7; ?>" required />
							<div class="input-group-append">
								<div class="input-group-text bg-dark">%</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="bonus_g8_g11">Bonus Royalty G8 - G11</label>
						<div class="input-group">
							<input type="number" class="form-control" id="bonus_g8_g11" name="bonus_g8_g11" min="0.01" max="100" step="0.01" value="<?= $arr->row()->bonus_g8_g11; ?>" required />
							<div class="input-group-append">
								<div class="input-group-text bg-dark">%</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-12 col-md-3 mb-3">
					<div class="form-group">
						<label for="potongan_wd_external">Potongan Withdraw External</label>
						<div class="input-group">
							<input type="number" class="form-control" id="potongan_wd_external" name="potongan_wd_external" min="0.01" max="100" step="0.01" value="<?= $arr->row()->potongan_wd_external; ?>" required />
							<div class="input-group-append">
								<div class="input-group-text bg-dark">%</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="potongan_swap">Potongan Swap USDT/RATU</label>
						<div class="input-group">
							<input type="number" class="form-control" id="potongan_swap" name="potongan_swap" min="0.01" max="100" step="0.01" value="<?= $arr->row()->potongan_swap; ?>" required />
							<div class="input-group-append">
								<div class="input-group-text bg-dark">%</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="potongan_wd_internal">Potongan Withdraw RATU Coin</label>
						<div class="input-group">
							<input type="number" class="form-control" id="potongan_wd_internal" name="potongan_wd_internal" min="0.01" max="100" step="0.01" value="<?= $arr->row()->potongan_wd_internal; ?>" required />
							<div class="input-group-append">
								<div class="input-group-text bg-dark">%</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="potongan_transfer">Potongan Transfer</label>
						<div class="input-group">
							<input type="number" class="form-control" id="potongan_transfer" name="potongan_transfer" min="0.01" max="100" step="0.01" value="<?= $arr->row()->potongan_transfer; ?>" required />
							<div class="input-group-append">
								<div class="input-group-text bg-dark">%</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="rate_usdt_ratu">Rate USDT/Ratu</label>
						<div class="input-group">
							<input type="number" class="form-control" id="rate_usdt_ratu" name="rate_usdt_ratu" min="0.01" max="99999999999" step="0.01" value="<?= $arr->row()->rate_usdt_ratu; ?>" required />
							<div class="input-group-append">
								<div class="input-group-text bg-indigo">RATU</div>
							</div>
						</div>
						<span class="help-block small">(1 USDT Setara dengan Berapa Ratu Coin)</span>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12 col-md-12">
					<button type="submit" class="btn btn-primary btn-block">Update</button>
				</div>
			</div>
		</form>
	</div>
</section>
