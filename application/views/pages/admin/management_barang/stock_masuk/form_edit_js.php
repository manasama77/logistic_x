<script>
	const defaultImage = `<?= base_url('public/img/barang/default.jpg'); ?>`
	const mainPageUrl = `<?= base_url('management_barang/master_barang'); ?>`
	let imagePath = document.getElementById('image_path')
	let previewImage = document.getElementById('preview_image')
	let btnResetImage = document.getElementById('btn_reset_image')

	$(document).ready(function() {
		imagePath.onchange = evt => {
			const [file] = imagePath.files
			if (file) {
				previewImage.src = URL.createObjectURL(file)
				btnResetImage.disabled = false
			}
		}

		btnResetImage.onclick = evt => {
			imagePath.value = null
			btnResetImage.disabled = true
			previewImage.src = defaultImage
		}

		$('#form').on('submit', function(e) {
			e.preventDefault();

			let formData = new FormData($(this)[0])

			$.ajax({
				url: '<?= site_url('management_barang/master_barang/update/' . $arr->row()->id); ?>',
				method: 'post',
				dataType: 'json',
				data: formData,
				async: false,
				cache: false,
				contentType: false,
				enctype: 'multipart/form-data',
				processData: false,
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
</script>