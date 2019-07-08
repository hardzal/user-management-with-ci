$(function () {
	$('.tambahDataMenu').on('click', function () {
		$('#judulModalMenu').html("Add New Menu");
		$('.submitButton').html("Add Menu");
	});

	$('.editDataMenu').on('click', function () {
		$('#judulModalMenu').html("Update Menu");
		$('.submitButton').html("Update Menu");

		$('.modal-content form').attr('action', 'http://localhost/latihan/ci/loginsis/menu/edit');

		const id = $(this).data('id');

		$.ajax({
			url: 'http://localhost/latihan/ci/loginsis/menu/edit',
			data: {
				id: id
			},
			method: 'POST',
			dataType: 'json',
			success: function (data) {
				$('#menu').val(data.menu);
				$('#id').val(data.id);
				console.log(data);
			}
		});
	});

	$('.form-check-input').on('click', function () {
		const menu_id = $(this).data('menu');
		const role_id = $(this).data('role');

		$.ajax({
			url: 'http://localhost/latihan/ci/loginsis/admin/changeaccess',
			type: 'POST',
			data: {
				menu_id: menu_id,
				role_id: role_id
			},
			success: function () {
				document.location.href = "http://localhost/latihan/ci/loginsis/admin/roleaccess/" + role_id;
			}
		});
	});

	$('.custom-file-input').on('change', function () {
		let fileName = $(this).val().split('\\').pop();
		$(this).next('.custom-file-label').addClass('selected').html(fileName);
	});

	$('.editDataSubMenu').on('click', function () {
		$('#judulModalMenu').html("Update SubMenu");
		$('.submitButton').html("Update SubMenu");

		$('.modal-content form').attr('action', 'http://localhost/latihan/ci/loginsis/menu/submenu/edit');

		const id = $(this).data('id');

		$.ajax({
			url: 'http://localhost/latihan/ci/loginsis/menu/submenu/edit',
			data: {
				id: id
			},
			method: 'POST',
			dataType: 'json',
			success: function (data) {
				$('#menu_id').val(data.menu_id);
				$("#menu_title").val(data.title);
				$("#menu_icon").val(data.icon);
				$("#menu_url").val(data.url);
				$("#is_active").val(data.is_active);
				$("#id").val(data.id);
				console.log(data);
			}
		});
	});
});
