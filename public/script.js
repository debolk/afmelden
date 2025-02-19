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
	$('input[type=text][required]').on('blur', function () {
		var missing = $(this).val() === '';
		$(this).toggleClass('required-missing', missing);
		$(this).parents('label').first().toggleClass('required-missing', missing);
	});

	$('input[type=radio][required]').on('blur', function () {
		var selector = 'input[name="' + this.name + '"]';
		var missing = !$(selector + ':checked').val();
		if (missing) {
			$(selector).addClass('required-missing');
			$(selector).parents('.radio-group').addClass('required-missing');
		} else {
			$(selector).removeClass('required-missing');
			$(selector).parents('.radio-group').removeClass('required-missing');
		}
	});
	$('input[type=radio][required]').on('click', function () {
		$(this).removeClass('required-missing');
		$(this).parents('.radio-group').removeClass('required-missing');
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
		$(this).blur();
	});

	// Check for missing required text fields
	var missing = $(pageSelector + ' input[type=text][required]').filter(function () {
		return $(this).val() === '';
	});
	if (missing.length > 0) {
		return false;
	}

	// Check for missing required radio fields
	var names = [];
	var radios = $(pageSelector + ' input[type=radio][required]').each(function () {
		if (names.indexOf(this.name) === -1) {
			names.push(this.name);
		}
	});
	var missing = names.filter(function (name) {
		return !$('input[name="' + name + '"]:checked').val();
	});
	return missing.length === 0;
}
