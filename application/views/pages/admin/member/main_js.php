<script>
	let s_id_member = $('#id_member');
	let s_fullname = $('#fullname');
	let s_id_card_number = $('#id_card_number');
	let s_country_code = $('#country_code');
	let s_address = $('#address');
	let s_postal_code = $('#postal_code');
	let s_nama_bank = $('#nama_bank');
	let s_no_rekening = $('#no_rekening');
	let s_foto_ktp = $('#foto_ktp');
	let s_foto_pegang_ktp = $('#foto_pegang_ktp');

	$(document).ready(function() {
		$("#table_data").DataTable({
			"scrollX": "300px",
			"scrollY": "500px",
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
					title: "Member",
					filename: "Member",
					exportOptions: {
						columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19],
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
					title: "Member",
					filename: "Member",
					exportOptions: {
						columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19],
						modifier: {
							page: 'all'
						},
					}
				}
			],
		}).buttons().container().appendTo('#table_data_wrapper .col-md-6:eq(0)');

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

	function modalKYC(id_member) {
		$.ajax({
			url: '<?= site_url('member/data_kyc'); ?>',
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
			url: '<?= site_url('member_management/change_status'); ?>',
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
					text: 'Failed connect to Database, please contact web developer',
				});
			} else if (e.code == 200) {
				Swal.fire({
					position: 'top-end',
					icon: 'success',
					title: 'Success...',
					text: 'Update Success',
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
