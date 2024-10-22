$(document).ready(function () {

	// Prevent early form submission using enter key
	$(document).keypress(function (e) {
		var charCode = e.charCode || e.keyCode || e.which;
		if (charCode == 13) {
			e.preventDefault()
			console.log('pressed enter')
		}
	});

	goToPage(1);

	$('#topage2').click(function () {
		// Skip page 2 if user becomes ex-lid
		if ($('input[name="lidmaatschap"]:checked').val() === 'oudlid') {
			goToPage(2);
		} else {
			goToPage(3);
		}
	});

	$('#3topage2').click(function () {
		// Skip page 2 if user becomes ex-lid
		if ($('input[name="lidmaatschap"]:checked').val() === 'oudlid') {
			goToPage(2);
		} else {
			goToPage(1);
		}
	});

	$('#2topage1').click(function () {
		goToPage(1);
	});

	$('#2topage3').click(function () {
		goToPage(3);
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
				goToPage(4);
			},
			error: function (data) {
				alert('Er is iets misgegaan. Je afmelding is niet verwerkt. Mogelijk heb je de captcha niet ingevuld? Probeer het opnieuw. \n\nAls het probleem blijft bestaan, neem dan contact op met het bestuur via bestuur@nieuwedelft.nl of 015-212 60 r12.');
			}
		});
	});
});

function goToPage(number) {
	$('#pag1, #pag2, #pag3, #pag4').hide();
	$('#pag' + number).show();
}
