<script>
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
			"buttons": ["copy", "csv", "excel", "pdf", "print"]
		}).buttons().container().appendTo('#table_data_wrapper .col-md-6:eq(0)');
	});

	function changeStatus(id, fullname, type) {
		Swal.fire({
			title: `Are you sure?`,
			text: `Change Status Member ${fullname}`,
			icon: 'question',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, change it!'
		}).then((result) => {
			if (result.isConfirmed) {
				processChangeStatus(id, type)
			}
		});
	}

	function processChangeStatus(id, type) {
		$.ajax({
			url: '<?= site_url('bonus/reward/change_status'); ?>',
			method: 'post',
			dataType: 'json',
			data: {
				id: id,
				type: type
			},
			beforeSend: function() {
				$.blockUI({
					message: `<i class="fas fa-spinner fa-spin"></i>`
				});
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
					showConfirmButton: false,
					toast: true,
					timer: 2000,
					timerProgressBar: true,
				}).then((res) => {
					window.location.reload();
				});
			} else {
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					html: 'Unknown Response!',
				});
			}
		});
	}
</script>
