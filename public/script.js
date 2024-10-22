$(document).ready(function () {

	// Prevent early form submission using enter key
	$(document).keypress(function (e) {
		var charCode = e.charCode || e.keyCode || e.which;
		if (charCode == 13) {
			e.preventDefault()
			console.log('pressed enter')
		}
	});

	// Virtual page navigation
	$('#pag2, #pag3, #pag4').hide();

	$('#topage2').click(function () {
		// Skip page 2 if user becomes ex-lid
		if ($('input[name="lidmaatschap"]:checked').val() === 'oudlid') {
			$("#pag1, #pag3").hide();
			$("#pag2").show();
		} else {
			$("#pag1, #pag2").hide();
			$("#pag3").show();
		}
	});

	$('#3topage2').click(function () {
		// Skip page 2 if user becomes ex-lid
		if ($('input[name="lidmaatschap"]:checked').val() === 'oudlid') {
			$("#pag2").show();
			$("#pag3").hide();
		} else {
			$("#pag1").show();
			$("#pag3, #pag2").hide();
		}
	});

	$('#2topage1').click(function () {
		$("#pag1").show();
		$("#pag2").hide();
	});

	$('#2topage3').click(function () {
		$("#pag3").show();
		$("#pag2").hide();
	});

	// Form submission using AJAX
	$('#lid-af-form').submit(function (e) {
		e.preventDefault();
		var form = $(this);

		$.ajax({
			type: form.attr('method'),
			url: form.attr('action'),
			data: form.serialize(), // serializes the form's elements.
			success: function (data) {
				$('#pag3').hide();
				$('#pag4').show();
			}
		});
	});
});
