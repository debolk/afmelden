<?php require_once __DIR__ . '/../bootstrap.php'; ?>

<!DOCTYPE html>
<html>

<head>
	<link rel="stylesheet" href="style.css" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="icon" href="favicon.ico" />
	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
	<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.12.0/jquery.validate.js"></script>
	<script type='text/javascript' src='script.js'></script>
	<title>Lid-af formulier</title>
</head>

<body>
	<form name="lid-af-form" id="lid-af-form" method="post" action="submit.php">

		<section id="pag1">
			<h1> Lid-af formulier </h1>
			Beste Bolker, <br>
			Je hebt aangegeven dat je je lidmaatschap van De Bolk wil beëindigen. Vul dit formulier om de
			be&euml;indiging te bevestigen, je bent dan per eerste van de volgende maand lid-af. De openstaande
			rekeningen moet je nog wel betalen. <br>


			<h2> Gegevens </h2>
			<p><label> Naam* <br>
					<input type="text" name="voornaam" /></label></p>
			<p><label>Adres*<br>
					<input type="text" name="adres" /></label></p>
			<p><label>Postcode en plaats* <br>
					<input type="text" name="postcodeplaats" /></label></p>
			<p><label>Telefoon <br>
					<input type="text" name="telefoon" /><br></label></p>
			<p><label>E-mail adres <br>
					<input type="text" name="email" /></label></p>
			<!-- Lid keuze -->
			<h2> Lidmaatschap keuze* </h2>
			<div id="lid">
				<p>
					<label>
						<input type='radio' name='lidmaatschap' value='exlid' />Ex-lid</label><br>
					<label>
						<input type='radio' name='lidmaatschap' value='oudlid' />Oud-lid</label>
				</p>
			</div>
			<input type="button" id="topage2" value="Doorgaan" /> *Beantwoord in ieder geval deze vragen.
		</section>


		<!-- Oud-lid -->
		<section id="pag2">
			<h1> Oud-lid </h1>
			<p>
				Je hebt aangegeven dat je oud-lid wilt worden.
			</p>
			<h3>Wil je op de hoogte blijven van de nieuws en gebeurtenissen op de Bolk?</b></h3>
			<p>
				<label>
					<input type="checkbox" name="courant" value="courant">Ja ik wil de Bolksche Courant blijven
					ontvangen</label>
			</p>

			<!--Vol lid worden -->
			<h2> Wil je lid worden van de Vereniging Oud Leden?</h2>
			<p>
				De VOL is opgericht voor oud-leden en streeft ernaar om het contact tussen oud-leden onderling en met
				D.S.V. "Nieuwe Delft" te bevorderen. Daarnaast heeft zij als doelen het in stand houden van de historie
				van D.S.V. "Nieuwe Delft" en waar mogelijk te ondersteunen. De VOL organiseert een aantal borrels voor
				oud-leden en heeft daaarnaast een fonds opgericht waaruit schenkingen aan D.S.V. "Nieuwe Delft" kunnen
				worden gedaan. De contributie voor de VOL bedraagt €15,- per jaar.
			</p>

			<p>
				Wil je lid worden van de VOL? <br>
				<label>
					<input type="radio" name="vol" value="ja">Ja</label><br>
				<label>
					<input type="radio" name="vol" value="nee">Nee</label>
			</p>

			<h2> Wil je doneren aan de Bolk? </h2>
			<p> Het is mogelijk om de vereniging financieel te blijven steunen. De donatie wordt ieder kwartaal afgeschreven.
				Je kunt je donatie op ieder moment stoppen, het bedrag aanpassen of de bestemming veranderen. </p>
			<p>
				<label>
					<input type="hidden" name="donatie" value="nee">
					<input type="checkbox" name="donatie" value="ja"> Ja, ik wil graag doneren.
				</label><br>
			</p>

			<p>
				<label for="bedrag">
					Namelijk
					<input type="text" name="bedrag" value="45" style="width: 2em;" /> euro per kwartaal
				</label>
			</p>

			<p>
				Je kunt direct aan De Bolk doneren. Jouw donatie zal worden aangewend om activiteiten te organiseren en de soci&euml;teit te onderhouden.
				Of je kunt doneren aan het fonds van de VOL. De donatie wordt dan gebruikt om de verening op lange termijn te ondersteunen en te beschermen.
				In beide gevallen komt je donatie 100% ten goede aan De Bolk.
			</p>
			<p>
				<label for="donatiebestemming">
					<input type="radio" name="donatiebestemming" value="Bolk" checked> Ik wil doneren aan De Bolk. <br>
					<input type="radio" name="donatiebestemming" value="VOL"> Ik wil doneren aan het VOL-fonds.
				</label>
			</p>

			<input type="button" id="2topage1" value="Terug" />
			<input type="button" id="2topage3" value="Doorgaan" />
		</section>

		<!--Verklaring-->
		<section id="pag3">
			<div id="verkl">
				<p>
				<h2> Verklaring </h2> <br>

				<p><label>Datum <br>
						<input type="date" id="datum" name="datum" value="<?= date('Y-m-d') ?>"> </label></p>
				<p><label>Plaats* <br>
						<input type="text" name="plaats" value="Delft" /></label></p><br>
				<p>
					<!-- hCaptcha spam protection -->
					<script src="https://js.hcaptcha.com/1/api.js" async defer></script>
					<div class="h-captcha" data-sitekey="<?= $_ENV['HCAPTCHA_SITEKEY']; ?>"></div>
				</p>
				<input type="button" id="3topage2" value="Terug" />
				<input type="submit" name="verstuur" id="stuur" value="Verstuur formulier" />

			</div>
		</section>


		<!--Einde-->
		<section id="pag4">
			<div id="eind">
				<h2>Formulier verstuurd</h2>
				<p>
					Bedankt voor het invullen van dit formulier. Als de gegevens verwerkt zijn, krijg je een lid-afbevestiging per e-mail.
				</p>

				<div id="donatie-vol" style="display: none;">
					<h2>Donatie VOL</h2>
					<p>
						Tof dat je wil doneren aan het VOL-fonds. Meer info over het Fonds vind je op <a href="https://vol.debolk.nl/fonds/">de fondspagina op de website van de VOL</a>. Voor je donatie en VOL-contributie kun je <a href="https://vol.debolk.nl/fonds/">een automatisch incasso instellen</a>.
					</p>
				</div>
			</div>
		</section>

	</form>
</body>

</html>
