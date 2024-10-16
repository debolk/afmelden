$(document).ready(function () {
	$(document).keypress(function (e) {
		var charCode = e.charCode || e.keyCode || e.which;
		if (charCode == 13) {
			e.preventDefault()
			console.log('pressed enter')
		}
	});
	$('#pag2, #pag3, #pag4').hide()
	$('input[name="lidmaatschap"]').change(function () {
		if ($(this).val() == "oudlid") {
			$('#topage2').click(function () {
				$("#pag1, #pag3").hide();
				$("#pag2").show();
			});
			$('#3topage2').click(function () {
				$("#pag2").show();
				$("#pag3").hide();
			});
		}
		else {
			$('#topage2').click(function () {
				$("#pag1, #pag2").hide();
				$("#pag3").show();
			});
			$('#3topage2').click(function () {
				$("#pag1").show();
				$("#pag3, #pag2").hide();
			});
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
});
