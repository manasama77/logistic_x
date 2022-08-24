<script>
	$(document).ready(function() {
		$("#table_data").DataTable({
			"scrollX": "100%",
			"scrollY": "700px",
			order: [
				[0, 'desc']
			],
			"responsive": false,
			"lengthChange": false,
			"autoWidth": false,
			"buttons": ["copy", "csv", "excel", "pdf", "print"],
			"columnDefs": [{
				targets: [2],
				orderable: false
			}]
		}).buttons().container().appendTo('#table_data_wrapper .col-md-6:eq(0)');

		$('#form_add').on('submit', function(e) {
			e.preventDefault();

			$.ajax({
				url: '<?= site_url('management_pengguna/master_divisi/store'); ?>',
				method: 'post',
				dataType: 'json',
				data: $('#form_add').serialize(),
				beforeSend: function() {
					$.blockUI();
					$('#btn_add').prop('disabled', true)
				}
			}).always(function(e) {
				$.unblockUI();
			}).fail(function(e) {
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					html: e.responseText,
				});
				$('#btn_add').prop('disabled', false)
				console.log(e);
			}).done(function(e) {
				console.log(e);
				if (e.code == 200) {
					Swal.fire({
						position: 'top-end',
						icon: 'success',
						title: 'Success...',
						text: e.message,
						showConfirmButton: false,
						timer: 2000,
						timerProgressBar: true,
						toast: true,
					}).then((res) => {
						window.location.reload();
					});
				} else if (e.code == 400 || e.code == 500) {
					Swal.fire({
						icon: 'warning',
						title: 'Oops...',
						text: e.message,
					});
					$('#btn_add').prop('disabled', false)
				} else {
					Swal.fire({
						position: 'top-end',
						icon: 'error',
						title: 'Oops',
						text: 'Unknown Response, please Contact Admin',
						showConfirmButton: true,
						timer: 2000,
						timerProgressBar: true,
					}).then((res) => {
						window.location.reload();
					});
				}
			});
		});
	});

	function deleteData(id, name) {
		Swal.fire({
			title: `Data ${name} akan dihapus?`,
			text: "Data yang dihapus tidak dapat dikembalikan",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, delete it!'
		}).then((result) => {
			if (result.isConfirmed) {
				processDelete(id)
			}
		});
	}

	function processDelete(id) {
		$.ajax({
			url: '<?= site_url('management_pengguna/master_divisi/destroy'); ?>',
			method: 'post',
			dataType: 'json',
			data: {
				id: id
			},
			beforeSend: function() {
				$.blockUI();
				$(`button[name="btn_delete_${id}"]`).prop('disabled', true)
			}
		}).always(function(e) {
			$.unblockUI();
		}).fail(function(e) {
			Swal.fire({
				icon: 'error',
				title: 'Oops...',
				text: e.responseText,
			});
			$(`button[name="btn_delete_${id}"]`).prop('disabled', false)
			console.log(e);
		}).done(function(e) {
			console.log(e);
			if (e.code == 500) {
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: e.message,
				});
				$(`button[name="btn_delete_${id}"]`).prop('disabled', false)
			} else if (e.code == 200) {
				Swal.fire({
					position: 'top-end',
					icon: 'success',
					title: 'Success...',
					text: e.message,
					showConfirmButton: false,
					timer: 2000,
					timerProgressBar: true,
					toast: true,
				}).then((res) => {
					window.location.reload();
				});
			} else {
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: 'Unknown Response!',
				});
				$(`button[name="btn_delete_${id}"]`).prop('disabled', false)
			}
		});
	}
</script>