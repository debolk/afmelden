$(document).ready(function(){
	$(document).keypress(function (e) {     
		var charCode = e.charCode || e.keyCode || e.which;
		if (charCode  == 13) {
			e.preventDefault()
			console.log('pressed enter')
		}
	});
	/*$('#Lid-af formulier').validate({
		rules: {
			voornaam: 'required',
			adres: 'required',
			postcodeplaats: 'required',
			telefoon: 'required',
			email: 'required',
			lid: 'required',
			datum: 'required',
			plaats: 'required',
			ver:'required',
		},
		messages: {
			voornaam: 'Je moet dit veld invullen',
			adres: 'Je moet dit veld invullen',
			postcodeplaats: 'Je moet dit veld invullen',
			telefoon: 'Je moet dit veld invullen',
			email: 'Je moet dit veld invullen',
			lid: 'Je moet dit veld invullen',
			datum: 'Je moet dit veld invullen',
			plaats: 'Je moet dit veld invullen',
			ver:'Je moet dit veld invullen',
		}
	});	*/
	$('#pag2, #pag3, #pag4').hide()
	$('input[name="lidmaatschap"]').change(function() {
		if	($(this).val() == "oudlid") {
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
	var today = new Date();
	var dd = today.getDate();
	var mm = today.getMonth()+1; //January is 0!
	var yyyy = today.getFullYear();
		if(dd<10){dd='0'+dd} if(mm<10){mm='0'+mm} today = dd+'/'+mm+'/'+yyyy;

	$('#datum').attr('value', today);


	
	
})
		


	