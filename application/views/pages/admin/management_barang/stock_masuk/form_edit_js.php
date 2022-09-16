<script>
	const idEdit = $('#id_edit').val()
	const mainPageUrl = `<?= base_url('management_barang/stock_masuk'); ?>`
	let listItem = []

	$(document).ready(function() {
		$('#item_id').select2({
			allowClear: true
		})

		getListItem()


		$('#btn_add').on('click', e => {
			let itemId = parseInt($('#item_id').val())
			let itemName = $('#item_id :selected').text()
			let qty = parseInt($('#qty').val())
			let itemSatuan = $('#item_id :selected').data('satuan')

			if (!itemId) {
				return Swal.fire({
					position: 'top-end',
					icon: 'warning',
					title: 'Barang belum terpilih',
					showConfirmButton: false,
					timer: 1500,
					timerProgressBar: true,
					toast: true,
				}).then((res) => {
					$('#item_id').focus()
				});
			} else if (!qty) {
				return Swal.fire({
					position: 'top-end',
					icon: 'warning',
					title: 'Qty Belum diisi',
					showConfirmButton: false,
					timer: 1500,
					timerProgressBar: true,
					toast: true,
				}).then((res) => {
					$('#qty').focus()
				});
			}

			addItem(itemId, itemName, qty, itemSatuan)

		})

		$('#form').on('submit', function(e) {
			e.preventDefault();

			if (listItem.length == 0) {
				return Swal.fire({
					position: 'top-end',
					icon: 'warning',
					title: 'List Stock Masuk Kosong',
					showConfirmButton: false,
					timer: 2000,
					timerProgressBar: true,
					toast: true,
				}).then((res) => {
					$('#item_id').focus()
				});
			}

			$.ajax({
				url: `<?= site_url(''); ?>management_barang/stock_masuk/update/${idEdit}`,
				method: 'post',
				dataType: 'json',
				data: {
					request_date: $('#request_date').val(),
					request_time: $('#request_time').val(),
					code: $('#code').val(),
					description: $('#description').val(),
					list_item: listItem,
				},
				beforeSend: function() {
					$.blockUI();
					$('#btn_save').prop('disabled', true)
				}
			}).always(function(e) {
				$.unblockUI();
			}).fail(function(e) {
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					html: e.responseText,
				});
				$('#btn_save').prop('disabled', false)
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
						window.location.replace(mainPageUrl);
					});
				} else if (e.code == 400 || e.code == 500) {
					Swal.fire({
						icon: 'warning',
						title: 'Oops...',
						text: e.message,
					});
					$('#btn_save').prop('disabled', false)
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

	function addItem(itemId, itemName, qty, itemSatuan) {
		let itemIndex = listItem.findIndex(x => x.itemId === itemId)

		if (itemIndex >= 0) {
			// Update Qty
			listItem[itemIndex]['qty'] = listItem[itemIndex]['qty'] + qty
		} else {
			// Create New Data
			listItem.push({
				itemId,
				itemName,
				qty,
				itemSatuan,
			})
		}

		$('#item_id').val('').change()
		$('#qty').val('')
		renderListItem()
	}

	function renderListItem() {
		let htmlnya = ``

		if (listItem.length > 0) {
			listItem.forEach((e, i) => {
				if ($('#state').val() == 'Menunggu') {
					htmlnya += `
					<tr>
						<td class="text-center">
							<button type="button" class="btn btn-danger btn-sm" onclick="deleteItem(${i})" title="Delete">
								<i class="fas fa-trash"></i>
							</button>
						</td>
						<td>${e.itemName}</td>
						<td>${e.qty} ${e.itemSatuan}</td>
					</tr>
					`
				} else {
					htmlnya += `
					<tr>
						<td>${e.itemName}</td>
						<td>${e.qty_request} ${e.itemSatuan}</td>
						<td>
							<div class="input-group input-group-sm">
								<input type="number" class="form-control form-control-sm" id="qty_received_${i}" value="${e.qty_receive}" style="width: 50px;" />
								<div class="input-group-append">
									<label class="input-group-text" for="qty_received_${i}">${e.itemSatuan}</label>
								</div>
							</div>
						</td>
						<td>
							<div class="input-group input-group-sm">
								<input type="date" class="form-control form-control-sm" id="date_received_${i}" value="${e.dateReceive}" style="width: 90px;" />
								<input type="time" class="form-control form-control-sm" id="time_received_${i}" value="${e.timeReceive}" style="width: 80px;" />
							</div>
						</td>
						<td>
							<textarea class="form-control form-control-sm" id="description_${i}" value="e.description" placeholder="Keterangan">${e.description}</textarea>
						</td>
					</tr>
					`
				}
			})
		} else {
			htmlnya = `
				<tr>
					<td colspan="3" class="text-center">Data Kosong</td>
				</tr>
			`
		}

		$('#v_list').html(htmlnya)
	}

	function deleteItem(index) {
		listItem.splice(index, 1)
		renderListItem()
	}

	function getListItem() {
		$.ajax({
			url: `<?= site_url(); ?>management_barang/stock_masuk/get_list_item/${idEdit}`,
			method: 'get',
			dataType: 'json',
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
				e.data.forEach(i => {
					let itemId = parseInt(i.item_id)
					let itemName = `(${i.item_code}) ${i.item_name}`
					let qty = parseInt(i.qty_request)
					let itemSatuan = i.unit_name
					let description = (i.description) ?? ""

					listItem.push({
						itemId,
						itemName,
						qty,
						itemSatuan,
						description,
					})
				})
				renderListItem()
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
	}
</script>