<script>
	let defaultVTradeManager = `
	<tr>
		<td	td colspan="5" class="text-center align-middle">-Tidak Ada Paket Akitf-</td>
	</tr>`;

	let defaultVCryptoAsset = `
	<tr>
		<td	td colspan="5" class="text-center align-middle">-Tidak Ada Paket Akitf-</td>
	</tr>`;

	let defaultVDownline = `
	<tr>
		<td colspan="10" class="text-center align-middle">-Tidak ada data Downline-</td>
	</tr>`;

	$(document).ready(function() {
		//
	});

	function showModalDownline(id_member, fullname) {

		$.ajax({
			url: '<?= site_url('dashboard/downline_detail'); ?>',
			method: 'get',
			dataType: 'json',
			data: {
				id_member: id_member
			},
			beforeSend: function() {
				$.blockUI();
				$('#v_trade_manager').html(defaultVTradeManager);
				$('#v_crypto_asset').html(defaultVCryptoAsset);
			}
		}).always(function(e) {
			$.unblockUI();
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
			if (e.code == 200) {
				// TM START
				let newVTradeManager = defaultVTradeManager;
				if (e.data_package_tm.length > 0) {
					newVTradeManager = "";
					$.each(e.data_package_tm, function(i, k) {
						newVTradeManager += `
						<tr>
							<td>${k.package}</td>
							<td class="text-right">${k.amount}</td>
							<td class="text-right">${k.profit_per_day}</td>
							<td class="text-center">${k.duration}</td>
							<td class="text-center">${k.status}</td>
						</tr>
						`;
					});
				}
				// TM END

				// CA START
				let newVCryptoAsset = defaultVCryptoAsset;
				if (e.data_package_ca.length > 0) {
					newVCryptoAsset = "";
					$.each(e.data_package_ca, function(i, k) {
						newVCryptoAsset += `
						<tr>
							<td>${k.package}</td>
							<td class="text-right">${k.amount}</td>
							<td class="text-right">${k.profit_per_day}</td>
							<td class="text-center">${k.duration}</td>
							<td class="text-center">${k.status}</td>
						</tr>
						`;
					});
				}
				// CA END

				let newVDownline = defaultVDownline;
				if (e.data_downline.length > 0) {
					newVDownline = "";
					$.each(e.data_downline, function(i, k) {
						newVDownline += `
						<tr>
							<td>${k.user_id}</td>
							<td>${k.fullname}</td>
							<td>${k.email}</td>
							<td>${k.phone_number}</td>
							<td>${k.user_id_upline}</td>
							<td>${k.fullname_upline}</td>
							<td>${k.email_upline}</td>
							<td class="text-center">
								<span class="badge badge-primary">
									<i class="fas fa-sun"></i> ${k.generation}
								</span>
							</td>
							<td class="text-right">${k.total_omset}</td>
							<td class="text-right">${k.total_downline}</td>
						</tr>
						`;
					});
				}

				console.log(newVTradeManager);
				$('#name_downline').text(fullname);
				$('#v_trade_manager').html(newVTradeManager);
				$('#v_crypto_asset').html(newVCryptoAsset);
				$('#v_downline').html(newVDownline);
				$('#modal_detail').modal('show');
			}
		});
	}
</script>
