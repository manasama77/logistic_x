<aside class="main-sidebar sidebar-dark-blue elevation-1">
	<a href="<?= site_url('dashboard'); ?>" class="brand-link">
		<img src="<?= base_url('public/img/logo.png'); ?>" alt="LOGO" class="img-fluid brand-image" style="opacity: .9; max-width: 60px;">
		<span class="brand-text font-weight-bold text-white"><?= APP_NAME; ?></span>
	</a>

	<div class="sidebar">
		<div class="user-panel mt-3 pb-3 mb-3 d-flex">
			<div class="image">
				<img src="<?= base_url('public/plugin/adminlte/dist/img/avatar5.png'); ?>" class="img-circle elevation-2" alt="Admin Image">
			</div>
			<div class="info">
				<span class="d-block text-white"><?= $this->session->userdata(SESI . 'name'); ?><br /><small><?= $this->session->userdata(SESI . 'role'); ?> / <?= $this->session->userdata(SESI . 'division_name'); ?></small></span>
				<div class="btn-group">
					<a href="<?= site_url('profile'); ?>" class="btn btn-info btn-sm btn-flat text-white">
						<i class="fas fa-user"></i> Profile
					</a>
					<a href="<?= site_url('logout'); ?>" class="btn btn-danger btn-sm btn-flat text-white">
						<i class="fas fa-sign-out-alt"></i> Sign Out
					</a>
				</div>
			</div>
		</div>

		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column nav-flat nav-compact nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
				<li class="nav-item">
					<a href="<?= site_url('dashboard'); ?>" class="nav-link <?= ($this->uri->segment(1) == "dashboard") ? "active" : ""; ?>">
						<i class="nav-icon fas fa-tachometer-alt"></i>
						<p>
							Dashboard
						</p>
					</a>
				</li>
				<li class="nav-item <?= ($this->uri->segment(1) == "management_barang") ? "menu-is-opening menu-open" : ""; ?>">
					<a href="#" class="nav-link <?= ($this->uri->segment(1) == "management_barang") ? "active" : ""; ?>">
						<i class="nav-icon fas fa-dolly-flatbed"></i>
						<p>
							Management Barang
							<i class="fas fa-angle-left right"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?= site_url('master_barang'); ?>" class="nav-link <?= ($this->uri->segment(2) == "master_barang") ? "active" : ""; ?>">
								<i class="nav-icon fas fa-boxes"></i>
								<p>
									Master Barang
								</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= site_url('management_barang/satuan_barang'); ?>" class="nav-link <?= ($this->uri->segment(2) == "satuan_barang") ? "active" : ""; ?>">
								<i class="nav-icon fas fa-weight"></i>
								<p>
									Satuan Barang
								</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= site_url('management_barang/kategori_barang'); ?>" class="nav-link <?= ($this->uri->segment(2) == "kategori_barang") ? "active" : ""; ?>">
								<i class="nav-icon fas fa-tags"></i>
								<p>
									Kategori Barang
								</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= site_url('stock_keluar'); ?>" class="nav-link <?= ($this->uri->segment(2) == "stock_keluar") ? "active" : ""; ?>">
								<i class="nav-icon fas fa-cart-arrow-down"></i>
								<p>
									Stock Keluar
								</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= site_url('stock_masuk'); ?>" class="nav-link <?= ($this->uri->segment(2) == "stock_masuk") ? "active" : ""; ?>">
								<i class="nav-icon fas fa-cart-plus"></i>
								<p>
									Stock Masuk
								</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= site_url('stock_opname'); ?>" class="nav-link <?= ($this->uri->segment(2) == "stock_opname") ? "active" : ""; ?>">
								<i class="nav-icon fas fa-tasks"></i>
								<p>
									Stock Opname
								</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= site_url('management_barang/master_lokasi'); ?>" class="nav-link <?= ($this->uri->segment(2) == "master_lokasi") ? "active" : ""; ?>">
								<i class="nav-icon fas fa-warehouse"></i>
								<p>
									Master Lokasi
								</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= site_url('management_barang/master_supplier'); ?>" class="nav-link <?= ($this->uri->segment(2) == "master_supplier") ? "active" : ""; ?>">
								<i class="nav-icon fas fa-industry"></i>
								<p>
									Master Supplier
								</p>
							</a>
						</li>
					</ul>
				</li>
				<li class="nav-item <?= ($this->uri->segment(1) == "management_pengguna") ? "menu-is-opening menu-open" : ""; ?>">
					<a href="#" class="nav-link <?= ($this->uri->segment(1) == "management_pengguna") ? "active" : ""; ?>">
						<i class="nav-icon fas fa-users"></i>
						<p>
							Management Pengguna
							<i class="fas fa-angle-left right"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?= site_url('management_pengguna/master_user'); ?>" class="nav-link <?= ($this->uri->segment(2) == "master_user") ? "active" : ""; ?>">
								<i class="nav-icon fas fa-users"></i>
								<p>
									Master User
								</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= site_url('management_pengguna/master_divisi'); ?>" class="nav-link <?= ($this->uri->segment(2) == "master_divisi") ? "active" : ""; ?>">
								<i class="nav-icon fas fa-tags"></i>
								<p>
									Master Divisi
								</p>
							</a>
						</li>
					</ul>
				</li>
			</ul>
		</nav>
	</div>
</aside>