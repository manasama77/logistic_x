<script>
	let id_edit = null;
	$('#from_request_datetime').datetimepicker({
		format: 'd-m-Y H:i'
	})
	$('#to_request_datetime').datetimepicker({
		format: 'd-m-Y H:i'
	})

	$(document).ready(function() {
		$("#table_data").DataTable({
			"scrollX": true,
			order: [
				[1, 'desc']
			],
			"responsive": false,
			"lengthChange": true,
			"lengthMenu": [
				[10, 25, 50, -1],
				[10, 25, 50, "All"]
			],
			"autoWidth": false,
			"buttons": [{
					extend: 'copy',
					text: 'Copy',
					exportOptions: {
						columns: [1, 2, 3, 4, 5, 6, 7, 8],
						stripNewlines: false
					}
				},
				{
					extend: 'csv',
					text: 'CSV',
					exportOptions: {
						columns: [1, 2, 3, 4, 5, 6, 7, 8],
						stripNewlines: false
					}
				},
				{
					extend: 'excel',
					text: 'Excel',
					exportOptions: {
						columns: [1, 2, 3, 4, 5, 6, 7, 8],
						stripNewlines: false
					}
				},
				{
					extend: 'pdf',
					text: 'PDF',
					exportOptions: {
						columns: [1, 2, 3, 4, 5, 6, 7, 8],
						stripNewlines: false
					}
				},
				{
					extend: 'print',
					text: 'Print',
					customize: function(win) {

						var last = null;
						var current = null;
						var bod = [];

						var css = '@page { size: landscape; }',
							head = win.document.head || win.document.getElementsByTagName('head')[0],
							style = win.document.createElement('style');

						style.type = 'text/css';
						style.media = 'print';

						if (style.styleSheet) {
							style.styleSheet.cssText = css;
						} else {
							style.appendChild(win.document.createTextNode(css));
						}

						head.appendChild(style);
					},
					exportOptions: {
						columns: [1, 2, 3, 4, 5, 6, 7, 8],
						stripHtml: false,
					}
				},
			],
			"columnDefs": [{
				targets: [0],
				orderable: false
			}]
		}).buttons().container().appendTo('#table_data_wrapper .col-md-6:eq(0)');
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
			url: '<?= site_url('management_barang/master_barang/destroy'); ?>',
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