<!DOCTYPE html>
<html lang="en">

<?php $this->load->view('layouts/admin/_head'); ?>

<?php
if (isset($vitamin_css)) {
	$this->load->view('pages/admin/' . $vitamin_css);
}
?>

<style>
	.dataTables_scrollHeadInner,
	.table {
		width: 100% !important;
	}
</style>

<body class="control-sidebar-slide-open layout-fixed sidebar-mini-sm text-sm" style="height: auto;">
	<div class="wrapper">

		<!-- Preloader -->
		<?php //$this->load->view('layouts/admin/_preloader'); 
		?>
		<!-- /.Preloader -->

		<!-- Navbar -->
		<?php $this->load->view('layouts/admin/_navbar'); ?>
		<!-- /.navbar -->

		<!-- Main Sidebar Container -->
		<?php $this->load->view('layouts/admin/_aside'); ?>
		<!-- /.Main Sidebar Container -->

		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<?php $this->load->view('pages/admin/' . $content); ?>
		</div>
		<!-- /.content-wrapper -->

		<!-- Main Footer -->
		<?php $this->load->view('layouts/admin/_footer'); ?>
	</div>
	<!-- ./wrapper -->

	<!-- REQUIRED SCRIPTS -->
	<!-- jQuery 3.5 -->
	<script src="<?= base_url(); ?>vendor/components/jquery/jquery.min.js"></script>
	<!-- Bootstrap 4.6 -->
	<script src="<?= base_url(); ?>vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
	<!-- AdminLTE App -->
	<script src="<?= base_url(); ?>public/plugin/adminlte/dist/js/adminlte.js"></script>

	<!-- overlayScrollbars -->
	<script src="<?= base_url(); ?>public/plugin/adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>

	<!-- PAGE PLUGINS -->
	<script src="<?= base_url(); ?>public/plugin/adminlte/plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
	<script src="<?= base_url(); ?>public/plugin/adminlte/plugins/raphael/raphael.min.js"></script>
	<script src="<?= base_url(); ?>public/js/jquery.blockUI.js"></script>
	<script src="<?= base_url(); ?>public/js/sweetalert2.min.js"></script>


	<!-- DataTables  & Plugins -->
	<script src="<?= base_url(); ?>public/plugin/adminlte/plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="<?= base_url(); ?>public/plugin/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
	<script src="<?= base_url(); ?>public/plugin/adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
	<script src="<?= base_url(); ?>public/plugin/adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
	<script src="<?= base_url(); ?>public/plugin/adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
	<script src="<?= base_url(); ?>public/plugin/adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
	<script src="<?= base_url(); ?>public/plugin/adminlte/plugins/jszip/jszip.min.js"></script>
	<script src="<?= base_url(); ?>public/plugin/adminlte/plugins/pdfmake/pdfmake.min.js"></script>
	<script src="<?= base_url(); ?>public/plugin/adminlte/plugins/pdfmake/vfs_fonts.js"></script>
	<script src="<?= base_url(); ?>public/plugin/adminlte/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
	<script src="<?= base_url(); ?>public/plugin/adminlte/plugins/datatables-buttons/js/buttons.print.min.js"></script>
	<script src="<?= base_url(); ?>public/plugin/adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
</body>

</html>


<?php
if (isset($vitamin_js)) {
	$this->load->view('pages/admin/' . $vitamin_js);
}
?>