<script>
	let s_id_member = $('#s_id_member');
	let s_fullname = $('#s_fullname');
	let s_id_card_number = $('#s_id_card_number');
	let s_country_code = $('#s_country_code');
	let s_address = $('#s_address');
	let s_postal_code = $('#s_postal_code');
	let s_nama_bank = $('#s_nama_bank');
	let s_no_rekening = $('#s_no_rekening');
	let s_foto_ktp = $('#s_foto_ktp');
	let s_foto_pegang_ktp = $('#s_foto_pegang_ktp');

	$(document).ready(function() {
		$('#id_card_number').on('keypress', function(e) {
			if (!/[0-9]/.test(String.fromCharCode(e.which))) {
				return false;
			}
		});

		$('#phone_number').on('keypress', function(e) {
			if (!/[0-9]/.test(String.fromCharCode(e.which))) {
				return false;
			}
		});

		$('#user_id').on('keypress', function(e) {
			if (!/[0-9a-z]/.test(String.fromCharCode(e.which))) {
				return false;
			}
		});

		$("#table_data").DataTable({
			"scrollX": "300px",
			"scrollY": "300px",
			order: [
				[0, 'desc']
			],
			"responsive": false,
			"lengthChange": false,
			"autoWidth": false,
			buttons: [
				"copy",
				"csv",
				{
					extend: 'excelHtml5',
					text: 'Excel',
					orientation: 'landscape',
					pageSize: 'A3',
					title: "Founder",
					filename: "Founder",
					exportOptions: {
						columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16],
						modifier: {
							page: 'all'
						},
					}
				},
				{
					extend: 'pdfHtml5',
					text: 'PDF',
					orientation: 'landscape',
					pageSize: 'A3',
					title: "Founder",
					filename: "Founder",
					exportOptions: {
						columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16],
						modifier: {
							page: 'all'
						},
					}
				}
			],
		}).buttons().container().appendTo('#table_data_wrapper .col-md-6:eq(0)');

		$('#form_add').on('submit', function(e) {
			e.preventDefault();

			$.ajax({
				url: '<?= site_url('founder/store'); ?>',
				method: 'post',
				dataType: 'json',
				data: $('#form_add').serialize(),
				beforeSend: function() {
					$.blockUI();
				}
			}).always(function(e) {
				$.unblockUI();
			}).fail(function(e) {
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					html: e.responseText,
				});
				console.log(e);
			}).done(function(e) {
				console.log(e);
				if (e.code == 200) {
					Swal.fire({
						position: 'top-end',
						icon: 'success',
						title: 'Success...',
						text: e.msg,
						showConfirmButton: true,
						timer: 2000,
						timerProgressBar: true,
					}).then((res) => {
						window.location.reload();
					});
				} else if (e.code == 400 || e.code == 500) {
					Swal.fire({
						icon: 'warning',
						title: 'Oops...',
						text: e.msg,
					});
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

		$('#form_tolak_kyc').on('submit', function(e) {
			e.preventDefault();
			$.ajax({
				url: '<?= site_url('member/tolak_kyc'); ?>',
				method: 'post',
				dataType: 'json',
				data: $('#form_tolak_kyc').serialize(),
				beforeSend: function() {
					$('#alasan').attr('readonly', true);
					$('#btn_tolak_kyc').attr('disabled', true).block({
						message: `<i class="fas fa-spinner fa-spin"></i>`
					});
				}
			}).always(function() {
				$('#alasan').attr('readonly', false);
				$('#btn_tolak_kyc').attr('disabled', false).unblock();
			}).fail(function(e) {
				console.log(e);
				if (e.responseText != '') {
					Swal.fire({
						icon: 'error',
						title: 'Oops...',
						html: e.responseText,
					});
				}
			}).done(function(e) {
				console.log(e);
				if (e.code == 500) {
					Swal.fire({
						icon: 'warning',
						title: 'Oops...',
						toast: true,
						html: e.msg,
						showConfirmButton: false,
					});
				} else if (e.code == 200) {
					Swal.fire({
						icon: 'success',
						title: 'Berhasil...',
						toast: true,
						html: e.msg,
						showConfirmButton: false,
					}).then(() => {
						window.location.reload();
					});
				}
			});
		});
	});

	function changeStatus(id, email, is_active) {
		Swal.fire({
			title: `Are you sure?`,
			text: `Change Status ${email}`,
			icon: 'question',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, change it!'
		}).then((result) => {
			if (result.isConfirmed) {
				processChangeStatus(id, is_active)
			}
		});
	}

	function processChangeStatus(id, is_active) {
		$.ajax({
			url: '<?= site_url('founder/change_status'); ?>',
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
				html: e.responseText,
			});
			console.log(e);
		}).done(function(e) {
			console.log(e);
			if (e.code == 500) {
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					html: 'Failed connect to Database, please contact web developer',
				});
			} else if (e.code == 200) {
				Swal.fire({
					position: 'top-end',
					icon: 'success',
					title: 'Success...',
					html: 'Update Success',
					showConfirmButton: true,
					timer: 2000,
					timerProgressBar: true,
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

	function modalRole(id, email, role) {
		$('#id_role').val(id);
		$('#email_role').val(email);
		$('#change_role').val(role);
		$('#modal_role').modal('show');
	}

	function deleteData(id, email) {
		Swal.fire({
			title: `Are you sure Delete ${email}?`,
			text: "You won't be able to revert this!",
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
			url: '<?= site_url('delete_admin'); ?>',
			method: 'post',
			dataType: 'json',
			data: {
				id: id
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
					title: 'Success...',
					text: 'Delete Success',
					showConfirmButton: true,
					timer: 2000,
					timerProgressBar: true,
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

	function modalKYC(id_member) {
		$.ajax({
			url: '<?= site_url('founder/data_kyc'); ?>',
			method: 'get',
			dataType: 'json',
			data: {
				id_member: id_member
			},
			beforeSend: function() {
				$.blockUI();
			}
		}).always(function() {
			$.unblockUI();
		}).fail(function(e) {
			console.log(e);
		}).done(function(e) {
			console.log(e);
			$.each(e.arr_member, function(i, k) {
				let db_id = k.id;
				let db_email = k.email;
				let db_fullname = k.fullname;
				let db_id_card_number = k.id_card_number;
				let db_country_code = k.country_code;
				let db_address = k.address;
				let db_postal_code = k.postal_code;
				let db_nama_bank = k.nama_bank;
				let db_no_rekening = k.no_rekening;
				let db_foto_ktp = k.foto_ktp;
				let db_foto_pegang_ktp = k.foto_pegang_ktp;

				let foto_a = `<a href="<?= MEMBER_PATH; ?>/protected/ktp/${db_foto_ktp}" target="_blank"><img src="<?= MEMBER_PATH; ?>/protected/ktp/${db_foto_ktp}" class="img-thumbnail" /></a>`;
				let foto_b = `<a href="<?= MEMBER_PATH; ?>/protected/member/${db_foto_pegang_ktp}" target="_blank"><img src="<?= MEMBER_PATH; ?>/protected/member/${db_foto_pegang_ktp}" class="img-thumbnail" /></a>`;

				s_id_member.val(db_id);
				s_fullname.html(db_fullname);
				s_id_card_number.html(db_id_card_number);
				s_country_code.html(db_country_code);
				s_address.html(db_address);
				s_postal_code.html(db_postal_code);
				s_nama_bank.html(db_nama_bank);
				s_no_rekening.html(db_no_rekening);
				s_foto_ktp.html(foto_a);
				s_foto_pegang_ktp.html(foto_b);
			});
			$('#modal_kyc').modal('show');
		});
	}

	function terimaKYC() {
		$.ajax({
			url: '<?= site_url('member/terima_kyc'); ?>',
			method: 'post',
			dataType: 'json',
			data: {
				id_member: s_id_member.val(),
			},
			beforeSend: function() {
				$('#btn_terima_kyc').attr('disabled', true).block({
					message: `<i class="fas fa-spinner fa-spin"></i>`
				});
			}
		}).always(function(e) {
			$('#btn_terima_kyc').attr('disabled', false).unblock();
		}).fail(function(e) {
			Swal.fire({
				icon: 'error',
				title: 'Oops...',
				html: e.responseText,
			});
			console.log(e);
		}).done(function(e) {
			console.log(e);
			if (e.code == 500) {
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					html: e.msg,
				});
			} else if (e.code == 200) {
				Swal.fire({
					position: 'top-end',
					icon: 'success',
					title: 'Berhasil...',
					html: e.msg,
					showConfirmButton: true,
					timer: 2000,
					timerProgressBar: true,
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

	function modalTolakKYC() {
		$('#id_member_tolak').val(s_id_member.val());
		$('#modal_tolak_kyc').modal('show');
	}
</script>
