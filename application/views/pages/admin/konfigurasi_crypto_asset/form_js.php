<script>
	let id_package_crypto_asset = $('#id_package_crypto_asset');

	let code = $('#code');
	let name = $('#name');
	let contract_duration = $('#contract_duration');
	let amount = $('#amount');

	let profit_per_month_percent = $('#profit_per_month_percent');
	let profit_per_month_value = $('#profit_per_month_value');

	let profit_per_day_percentage = $('#profit_per_day_percentage');
	let profit_per_day_value = $('#profit_per_day_value');

	let share_self_percentage = $('#share_self_percentage');
	let share_self_value = $('#share_self_value');

	let share_upline_percentage = $('#share_upline_percentage');
	let share_upline_value = $('#share_upline_value');

	let share_company_percentage = $('#share_company_percentage');
	let share_company_value = $('#share_company_value');

	let new_profit_per_month_value = 0;
	let new_profit_per_day_percentage = 0;
	let new_profit_per_day_value = 0;
	let new_share_self_value = 0;
	let new_share_upline_value = 0;
	let new_share_company_value = 0;
	let alert_status = "pass";

	let alert_persentase = $('#alert_persentase');
	let form = $('#form');
	let btn_submit = $('#btn_submit');

	$(document).ready(function() {
		id_package_crypto_asset.on('change', function() {
			if (id_package_crypto_asset.val() != "") {
				$.ajax({
					url: '<?= site_url('crypto_asset/konfigurasi/detail_package'); ?>',
					method: 'get',
					dataType: 'json',
					data: {
						id_package_crypto_asset: id_package_crypto_asset.val()
					},
					beforeSend: function() {
						$.blockUI();
					}
				}).always(function(e) {
					$.unblockUI();
				}).fail(function(e) {
					Swal.fire({
						position: 'top-end',
						title: `Terjadi Kesalahan`,
						html: e.responseText,
						icon: 'error',
						showCancelButton: false,
						showConfirmButton: false,
					});
				}).done(function(e) {
					console.log(e);
					if (e.code == 500) {
						Swal.fire({
							position: 'top-end',
							title: `Terjadi Kesalahan`,
							html: e.message,
							icon: 'error',
							showCancelButton: false,
							showConfirmButton: false,
						}).then(() => {
							window.location.reload();
						});
					} else if (e.code == 200) {
						code.val(e.data[0].code);
						name.val(e.data[0].name);
						contract_duration.val(e.data[0].contract_duration);
						amount.val(e.data[0].amount);
					}
				});
			}
		});

		profit_per_month_percent.keyup(function() {
			if (profit_per_month_percent.val() < 0) {
				profit_per_month_percent.val(0);
			} else if (profit_per_month_percent.val() > 99) {
				profit_per_month_percent.val(99);
			} else {
				updateValue();
			}
		});

		share_self_percentage.on('keyup change', function() {
			if (share_self_percentage.val() < 0) {
				share_self_percentage.val(0);
			} else if (share_self_percentage.val() > 99) {
				share_self_percentage.val(99);
			} else {
				updateValue();
			}
		});

		share_upline_percentage.keyup(function() {
			if (share_upline_percentage.val() < 0) {
				share_upline_percentage.val(0);
			} else if (share_upline_percentage.val() > 99) {
				share_upline_percentage.val(99);
			} else {
				updateValue();
			}
		});

		share_company_percentage.keyup(function() {
			if (share_company_percentage.val() < 0) {
				share_company_percentage.val(0);
			} else if (share_company_percentage.val() > 99) {
				share_company_percentage.val(99);
			} else {
				updateValue();
			}
		});

		form.on('submit', function(e) {
			e.preventDefault();

			if (alert_status == "pass") {
				storeNewRules();
			} else {
				Swal.fire({
					position: 'top-end',
					title: `Persentase Share Profit Melebihi 100%`,
					icon: 'warning',
					showCancelButton: false,
					showConfirmButton: false,
				});
			}

		});

	});

	function updateValue() {
		new_profit_per_month_value = (amount.val() * profit_per_month_percent.val()) / 100;
		profit_per_month_value.val(new_profit_per_month_value);

		new_profit_per_day_percentage = profit_per_month_percent.val() / 30;
		profit_per_day_percentage.val(new_profit_per_day_percentage);

		new_profit_per_day_value = amount.val() * profit_per_day_percentage.val() / 100;
		profit_per_day_value.val(new_profit_per_day_value);

		new_share_self_value = profit_per_day_value.val() * share_self_percentage.val() / 100;
		share_self_value.val(new_share_self_value);

		new_share_upline_value = profit_per_day_value.val() * share_upline_percentage.val() / 100;
		share_upline_value.val(new_share_upline_value);

		new_share_company_value = profit_per_day_value.val() * share_company_percentage.val() / 100;
		share_company_value.val(new_share_company_value);

		if (parseFloat(share_self_percentage.val()) + parseFloat(share_upline_percentage.val()) + parseFloat(share_company_percentage.val()) > 100) {
			alert_persentase.fadeIn();
			alert_status = "over";
		} else {
			alert_persentase.fadeOut();
			alert_status = "pass";
		}
	}

	function storeNewRules() {
		$.ajax({
			url: '<?= site_url('crypto_asset/konfigurasi/store'); ?>',
			method: 'post',
			dataType: 'json',
			data: form.serialize(),
			beforeSend: function() {
				btn_submit.attr('disabled', true);
				$.blockUI();
			}
		}).always(function(e) {
			$.unblockUI();
		}).fail(function(e) {
			Swal.fire({
				position: 'top-end',
				title: `Terjadi Kesalahan`,
				html: e.responseText,
				icon: 'error',
				showCancelButton: false,
				showConfirmButton: false,
			});
		}).done(function(e) {
			console.log(e);
			if (e.code == 500) {
				Swal.fire({
					position: 'top-end',
					title: `Terjadi Kesalahan`,
					html: e.message,
					icon: 'error',
					showCancelButton: false,
					showConfirmButton: false,
				}).then(() => {
					window.location.reload();
				});
			} else if (e.code == 200) {
				Swal.fire({
					position: 'top-end',
					title: `Sukses`,
					html: e.message,
					icon: 'success',
					showCancelButton: false,
					showConfirmButton: false,
				}).then(() => {
					window.location.replace('<?= site_url('crypto_asset/konfigurasi'); ?>');
				});
			}
		});
	}
</script>
