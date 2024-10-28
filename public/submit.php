<?php

require_once __DIR__ . '/../bootstrap.php';

/*
 * Validate hCaptcha challenge
 */
$hCaptcha = new \HCaptcha\hCaptcha($_ENV['HCAPTCHA_SECRET']);
$hCaptchaResponse = $hCaptcha->verify($_POST['h-captcha-response']);
if (!$hCaptchaResponse->isSuccess()) {
    http_response_code(400);
    echo "Failed hCaptcha challenge";
    exit;
}

/*
 * Send emails with the form data
 */
print("Bedankt voor het invullen van dit formulier. Als de gegevens verwerkt zijn, krijg je een lid-afbevestiging per e-mail.");
$naam=$_POST["voornaam"];
$adres1=$_POST["adres"];
$adres2=$_POST["postcodeplaats"];
$telefoon=$_POST["telefoon"];
$mail=$_POST["email"];
$lidmaatschap=$_POST["lidmaatschap"];
$vol=$_POST["vol"];
$donatie=$_POST['donatie'];
$donatiebedrag=intval($_POST["bedrag"]);
$donatiebestemming=$_POST["donatiebestemming"];
$donatieverdelingBolk=$_POST["donatieverdeling"];
$donatieverdelingVOL=intval($_POST["bedrag"]) - intval($_POST["donatieverdeling"]);
$donatieVerdelingTekst = $donatiebestemming == 'Verdeeld' ? "Bolk " . $donatieverdelingBolk . " VOL " . $donatieverdelingVOL : "n.v.t.";
$courant=$_POST['courant'];
$datum=$_POST["datum"];
$plaats=$_POST["plaats"];
$bedrag="€$donatiebedrag";

$templatesec="Beste Secretaris,
$naam heeft zich afgemeld.
Gegevens:
$adres1
$adres2
$telefoon
$mail
Lidmaatschap: $lidmaatschap
VOL: $vol
Donatie: $donatie
Donatiebedrag: $bedrag
Donatiebestemming: $donatiebestemming
Donatieverdeling: $donatieVerdelingTekst
$courant
$datum $plaats
";

$templatevol="Beste VOL,
$naam heeft zich afgemeld.
Gegevens:
$adres1
$adres2
$telefoon
$mail
Lidmaatschap: $lidmaatschap
VOL: $vol
Donatie: $donatie
Donatiebedrag: $bedrag
Donatiebestemming: $donatiebestemming
Donatieverdeling: $donatieVerdelingTekst
$datum $plaats
";

$templatethe="Beste Thesaurier,
$naam heeft zich afgemeld.
Gegevens:
$adres1
$adres2
$telefoon
$mail
Lidmaatschap: $lidmaatschap
Donatie: $donatie
Donatiebedrag: $bedrag
Donatiebestemming: $donatiebestemming
Donatieverdeling: $donatieVerdelingTekst
$datum $plaats
";

mail ('Secretaris <secretaris@nieuwedelft.nl>', 'Lid-af formulier', "$templatesec",'Lid-af formulier', "-f " . 'secretaris@nieuwedelft.nl');

mail ('VOL <vol@nieuwedelft.nl>', 'Lid-af formulier', "$templatevol",'Lid-af formulier', "-f " . ' secretaris@nieuwedelft.nl');

mail ('Thesaurier <thesaurier@nieuwedelft.nl>', 'Lid-af formulier', "$templatethe",'Lid-af formulier', "-f " . 'secretaris@nieuwedelft.nl');
