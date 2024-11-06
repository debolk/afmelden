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
$naam=$_POST["voornaam"] ?? 'niet ingevuld';
$adres=$_POST["adres"] ?? 'niet ingevuld';
$postcodeplaats=$_POST["postcodeplaats"] ?? 'niet ingevuld';
$telefoon=$_POST["telefoon"] ?? 'niet ingevuld';
$mail=$_POST["email"] ?? 'niet ingevuld';
$lidmaatschap=$_POST["lidmaatschap"] ?? 'niet ingevuld';
$vol=$_POST["vol"] ?? 'niet ingevuld';
$donatie=$_POST['donatie'] ?? 'niet ingevuld';
$donatiebedrag=intval($_POST["bedrag"]) ?? 'niet ingevuld';
$donatiebestemming=$_POST["donatiebestemming"] ?? 'niet ingevuld';
$donatieverdelingBolk=$_POST["donatieverdeling"] ?? 'niet ingevuld';
$donatieverdelingVOL=intval($_POST["bedrag"]) - intval($_POST["donatieverdeling"]);
$donatieVerdelingTekst = $donatiebestemming == 'Verdeeld' ? "Bolk " . $donatieverdelingBolk . " VOL " . $donatieverdelingVOL : "n.v.t.";
$courant=$_POST['courant'] ?? 'niet ingevuld';
$datum=$_POST["datum"] ?? 'niet ingevuld';
$plaats=$_POST["plaats"] ?? 'niet ingevuld';
$bedrag="€$donatiebedrag" ?? 'niet ingevuld';

$templatesec="Beste Secretaris,
$naam heeft zich afgemeld.
Gegevens:
$adres
$postcodeplaats
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
$adres
$postcodeplaats
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
$adres
$postcodeplaats
$telefoon
$mail
Lidmaatschap: $lidmaatschap
Donatie: $donatie
Donatiebedrag: $bedrag
Donatiebestemming: $donatiebestemming
Donatieverdeling: $donatieVerdelingTekst
$datum $plaats
";

// Send emails
$resultS = mail ('Secretaris <secretaris@nieuwedelft.nl>', 'Lid-af formulier', "$templatesec",'Lid-af formulier', "-f " . 'secretaris@nieuwedelft.nl');
$resultV = mail ('VOL <vol@nieuwedelft.nl>', 'Lid-af formulier', "$templatevol",'Lid-af formulier', "-f " . ' secretaris@nieuwedelft.nl');
$resultT = mail ('Thesaurier <thesaurier@nieuwedelft.nl>', 'Lid-af formulier', "$templatethe",'Lid-af formulier', "-f " . 'secretaris@nieuwedelft.nl');

// Verify that all emails were sent
if (!$resultS || !$resultV || !$resultT) {
    http_response_code(500);
    echo "Failed to send all three emails";
    exit;
}

// Send response
echo 'Bedankt voor het invullen van dit formulier. Als de gegevens verwerkt zijn, krijg je een lid-afbevestiging per e-mail.';
