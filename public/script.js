$(document).ready(function () {

	// Prevent early form submission using enter key
	$(document).keypress(function (e) {
		var charCode = e.charCode || e.keyCode || e.which;
		if (charCode == 13) {
			e.preventDefault()
			console.log('pressed enter')
		}
	});

	// Required fields highlight on blur
	$('input[required]').blur(function () {
		var missing = $(this).val() === '';
		$(this).toggleClass('required-missing', missing);
		$(this).parents('label').toggleClass('required-missing', missing);
	});

	// Page navigation
	goToPage(1);

	$('#topage2').click(function () {
		if (!validateFields('#pag1')) {
			return;
		}

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
		if (!validateFields('#pag2')) {
			return;
		}
		goToPage(3);
	});

	// Donation distrubution sub-form
	$('#donatiebedrag').change(function () {
		var donation = parseInt($(this).val());
		$('#donatieverdeling').attr('max', donation);
		$('#donatieverdeling').val(Math.round(donation / 2));
		$('#donatieverdeling').trigger('input');
	});

	$('[name="donatiebestemming"]').change(function () {
		var bestemming = $('[name="donatiebestemming"]:checked').val();
		$('#donatieverdeling').attr('disabled', bestemming !== 'Verdeeld');
	})

	$('#donatieverdeling').on('input', function () {
		var distribution = parseInt($(this).val());
		var max = parseInt($(this).attr('max'));

		$('#donatieverdeling-bolkdeel').html(distribution);
		$('#donatieverdeling-voldeel').html(max - distribution);
	});

	// In some cases, the form is prefilled with unexpected values, e.g. after refreshing in Firefox
	// so we update just in case
	$('#donatiebedrag').trigger('change');

	// Form submission using AJAX
	$('#lid-af-form').submit(function (e) {
		e.preventDefault();
		var form = $(this);
		if (!validateFields('#pag3')) {
			return;
		}

		$.ajax({
			type: form.attr('method'),
			url: form.attr('action'),
			data: form.serialize(),
			success: function (data) {
				goToPage(4);
				// Show donation message if donation is for the VOL
				if ($('input[name="donatiebestemming"]:checked').val() !== 'Bolk') {
					$('#donatie-vol').show();
				}
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

function validateFields(pageSelector) {
	// Blur every field on the page to show the visual highlights
	$(pageSelector + ' input[required]').each(function () {
		console.log(this);
		$(this).blur();
	});

	var missing = $(pageSelector + ' input[required]').filter(function () {
		return $(this).val() === '';
	});
	return missing.length === 0;
}
