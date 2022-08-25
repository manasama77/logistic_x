<script>
	$(document).ready(function() {
		$("#table_admin").DataTable({
			scrollX: true,
			order: [
				[1, 'asc']
			],
			columnDefs: [{
				targets: [0],
				orderable: false,
			}],
			"buttons": ["copy", "csv", "excel", "pdf", "print"]
		}).buttons().container().appendTo('#table_admin_wrapper .col-md-6:eq(0)');

		$('#form_add').on('submit', function(e) {
			e.preventDefault();

			$.ajax({
				url: '<?= site_url('management_pengguna/master_user/store'); ?>',
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
					text: e.responseText,
				});
				$('#btn_add').prop('disabled', false)
				console.log(e);
			}).done(function(e) {
				console.log(e);
				if (e.code == 500) {
					Swal.fire({
						icon: 'error',
						title: 'Oops...',
						text: 'Failed connect to Database, please contact web developer',
					});
					$('#btn_add').prop('disabled', false)
				} else if (e.code == 404) {
					Swal.fire({
						icon: 'warning',
						title: 'Oops...',
						text: 'Username telah terdaftar',
					});
					$('#btn_add').prop('disabled', false)
				} else if (e.code == 200) {
					Swal.fire({
						position: 'top-end',
						icon: 'success',
						title: 'Success...',
						text: 'Tambah Data Berhasil',
						showConfirmButton: false,
						timer: 2000,
						timerProgressBar: true,
						toast: true,
					}).then((res) => {
						window.location.reload();
					});
				}
			});
		});

		$('#form_reset').on('submit', function(e) {
			e.preventDefault();

			$.ajax({
				url: '<?= site_url('management_pengguna/master_user/reset_password'); ?>',
				method: 'post',
				dataType: 'json',
				data: {
					id: $('#id_reset').val(),
					new_password: $('#password_reset').val(),
				},
				beforeSend: function() {
					$.blockUI();
				}
			}).always(function(e) {
				$.unblockUI();
			}).fail(function(e) {
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: e.responseText,
				});
				console.log(e);
			}).done(function(e) {
				console.log(e);
				if (e.code == 500) {
					Swal.fire({
						icon: 'error',
						title: 'Oops...',
						text: 'Failed connect to Database, please contact web developer',
					});
				} else if (e.code == 200) {
					Swal.fire({
						position: 'top-end',
						icon: 'success',
						title: 'Berhasil...',
						text: 'Reset Password Berhasil',
						showConfirmButton: false,
						timer: 2000,
						timerProgressBar: true,
						toast: true,
					}).then((res) => {
						window.location.reload();
					});
				}
			});
		});
	});

	function resetPassword(id, username) {
		$('#id_reset').val(id);
		$('#username_reset').val(username);
		$('#modal_reset').modal('show');
	}

	function deleteData(id, username) {
		Swal.fire({
			title: `Data ${username} akan dihapus?`,
			text: "Data yang telah dihapus tidak dapat dikembalikan!",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Ya, Delete Data!'
		}).then((result) => {
			if (result.isConfirmed) {
				processDelete(id)
			}
		});
	}

	function processDelete(id) {
		$.ajax({
			url: '<?= site_url('management_pengguna/master_user/destroy'); ?>',
			method: 'post',
			dataType: 'json',
			data: {
				id: id
			},
			beforeSend: function() {
				$.blockUI();
				$(`#btn_delete_${id}`).prop('disabled', true)
			}
		}).always(function(e) {
			$.unblockUI();
		}).fail(function(e) {
			Swal.fire({
				icon: 'error',
				title: 'Oops...',
				text: e.responseText,
			});
			$(`#btn_delete_${id}`).prop('disabled', false)
			console.log(e);
		}).done(function(e) {
			console.log(e);
			if (e.code == 500) {
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: 'Failed connect to Database, please contact web developer',
				});
			} else if (e.code == 200) {
				Swal.fire({
					position: 'top-end',
					icon: 'success',
					title: 'Success...',
					text: 'Delete Success',
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
				$(`#btn_delete_${id}`).prop('disabled', false)
			}
		});
	}

	function changeStatus(id, username, is_active) {
		let statusnya = (is_active == "yes") ? "Tidak Aktif" : "Aktif"

		Swal.fire({
			title: `Apakah kamu yakin?`,
			text: `Ganti Status ${username} menjadi ${statusnya}`,
			icon: 'question',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Ya, ganti status!'
		}).then((result) => {
			if (result.isConfirmed) {
				processChangeStatus(id, is_active)
			}
		});
	}

	function processChangeStatus(id, is_active) {
		$.ajax({
			url: '<?= site_url('management_pengguna/master_user/change_status'); ?>',
			method: 'post',
			dataType: 'json',
			data: {
				id: id,
				is_active: (is_active == "yes") ? "no" : "yes"
			},
			beforeSend: function() {
				$.blockUI();
			}
		}).always(function(e) {
			$.unblockUI();
		}).fail(function(e) {
			Swal.fire({
				icon: 'error',
				title: 'Oops...',
				text: e.responseText,
			});
			console.log(e);
		}).done(function(e) {
			console.log(e);
			if (e.code == 500) {
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: 'Failed connect to Database, please contact web developer',
				});
			} else if (e.code == 200) {
				Swal.fire({
					position: 'top-end',
					icon: 'success',
					title: 'Berhasil...',
					text: 'Ganti Status Berhasil',
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
			}
		});
	}
</script>