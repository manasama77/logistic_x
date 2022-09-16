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
				[1, 'asc']
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

		$('#v_no_po').on('change', e => {
			if ($('#v_no_po').val().length == 0) {
				$('#v_no_do').prop('disabled', true)
				$('#v_state').val('Menunggu')
			} else {
				$('#v_no_do').prop('disabled', false)
				$('#v_state').val('Proses')
			}
		})

		$('#v_no_do').on('change', e => {
			if ($('#v_no_do').val().length == 0) {
				$('input[name^=qty_receive]').prop('disabled', true).val(0)
				$('input[name^=datetime_receive]').prop('disabled', true).val('')
				$('select[name^=state_item]').prop('disabled', true).val('Menunggu')
			} else {
				$('input[name^=qty_receive]').prop('disabled', false)
				$('input[name^=datetime_receive]').prop('disabled', false)
				$('select[name^=state_item]').prop('disabled', false)
			}
		})

		$('#form_detail').on('submit', e => {
			e.preventDefault()
			updatedDetail()
		})
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
			url: '<?= site_url('management_barang/stock_masuk/destroy'); ?>',
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

	function viewDetail(id) {
		$.ajax({
			url: '<?= base_url('management_barang/stock_masuk/show'); ?>',
			method: 'get',
			dataType: 'json',
			data: {
				id: id
			},
			beforeSend: () => {
				$.blockUI()
			}
		}).fail(e => {
			console.log(e)
		}).done(e => {
			console.log(e)
			$('#v_id').val(id)
			$('#v_request_datetime').text(e.data.request_datetime_indo)
			$('#v_code').text(e.data.code)
			$('#v_description').text(e.data.description)

			let htmlnya = `
				<tr>
					<td colspan="5" class="text-center">Data Kosong</td>
				</tr>
			`

			if (e.data.items.length > 0) {
				htmlnya = ``
				e.data.items.forEach((v, i) => {
					let stock_in_request_item_id = v.stock_in_request_item_id
					let item_id = v.item_id
					let item_code = v.item_code
					let item_name = v.item_name
					let qty_request = v.qty_request
					let qty_receive = v.qty_receive
					let datetime_receive = (v.datetime_receive) ?? ""
					let description = v.description
					let unit_name = v.unit_name
					let state_item = v.state_item

					htmlnya += `
						<tr>
							<td>
								<input type="hidden" name="stock_in_request_item_id[]" value="${stock_in_request_item_id}" />
								<small class="font-weight-bold">${item_code}</small><br/>${item_name}
							</td>
							<td>
								<input type="hidden" name="qty_request[]" value="${qty_request}" />
								${qty_request} ${unit_name}
							</td>
							<td>
								<div class="form-row justify-content-center p-0">
									<div class="col-md-8">
										<div class="input-group">
											<input type="number" class="form-control" name="qty_receive[]" value="${qty_receive}" min="0" max="${qty_request}" disabled />
											<div class="input-group-append">
												<span class="input-group-text">${unit_name}</span>
											</div>
										</div>
									</div>
								</div>
							</td>
							<td class="text-center">
								<input type="text" class="form-control" name="datetime_receive[]" value="${moment(e.data.request_datetime, 'YYYY-MM-DD hh:mm:ss').format('DD-MM-YYYY HH:mm')}" disabled />
							</td>
							<td class="text-center">
								<select class="form-control" name="state_item[]" disabled>
									<option ${(state_item == "Menunggu") ? "selected" : null}  value="Menunggu">Menunggu</option>
									<option ${(state_item == "Terima") ? "selected" : null} value="Terima">Terima</option>
									<option ${(state_item == "Tolak") ? "selected" : null} value="Tolak">Tolak</option>
								</select>
							</td>
						</tr>
					`
				})
			}

			$('#v_items').html(htmlnya)
			$('input[name^=datetime_receive]').datetimepicker({
				autoSize: true,
				format: 'd-m-Y H:i',
				showTodayButton: false,
				autoclose: true,
				minDate: moment(e.data.request_datetime, 'YYYY-MM-DD hh:mm:ss').format('YYYY-MM-DD'),
			})
			$('#v_no_po').val(e.data.no_po).change()
			$('#v_no_do').val(e.data.no_do).change()
			$('#v_state').val(e.data.state)

			if (e.data.state == "Selesai" || e.data.state == "Tolak") {
				$('#v_no_po').prop('disabled', true)
				$('#v_no_do').prop('disabled', true)
				$('#v_state').prop('disabled', true)
				$('input[name^=qty_receive]').prop('disabled', true)
				$('input[name^=datetime_receive]').prop('disabled', true)
				$('select[name^=state_item]').prop('disabled', true)
				$('#btn_save').prop('disabled', true)
			}

			$('#modal_detail').modal('show')

			$.unblockUI()
		})
	}

	function updatedDetail() {
		$.ajax({
			url: `<?= base_url('management_barang/stock_masuk/update_detail'); ?>`,
			method: 'post',
			dataType: 'json',
			data: $('#form_detail').serialize(),
			beforeSend: () => {
				$('#btn_save').prop('disabled', true)
			}
		}).fail(e => {
			console.log(e)
			$('#btn_save').prop('disabled', false)
		}).done(e => {
			console.log(e)

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
			}
		})
	}
</script>