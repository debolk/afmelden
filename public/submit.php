<?php

use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

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
$donatie=$_POST['donatie'] ?? 'nee';
$donatiebedrag=intval($_POST["bedrag"]) ?? 'niet ingevuld';
$donatiebestemming=$_POST["donatiebestemming"] ?? 'niet ingevuld';
$donatieverdelingBolk=$_POST["donatieverdeling"] ?? 'niet ingevuld';
$donatieverdelingVOL=intval($_POST["bedrag"]) - intval($_POST["donatieverdeling"]);
$donatieVerdelingTekst = $donatiebestemming == 'Verdeeld' ? "Bolk " . $donatieverdelingBolk . " VOL " . $donatieverdelingVOL : "n.v.t.";
$courant=$_POST['courant'] ?? 'nee';
$datum=$_POST["datum"] ?? 'niet ingevuld';
$plaats=$_POST["plaats"] ?? 'niet ingevuld';
$bedrag="€$donatiebedrag" ?? 'niet ingevuld';

$email=<<<EOD
Beste Secretaris, Thesaurier, en VOL-bestuur,

$naam heeft zich afgemeld als lid van De Bolk. De gegevens zijn als volgt:

Adres:
$adres
$postcodeplaats

Telefoon: $telefoon
E-mailadres: $mail

Gewenst lidmaatschap: $lidmaatschap
Lid van de VOL: $vol

Donatie: $donatie
Donatiebedrag: $bedrag
Donatiebestemming: $donatiebestemming
Donatieverdeling: $donatieVerdelingTekst

Bolksche Courant ontvangen: $courant

Datum: $datum
Plaats: $plaats

Dit is een geautomatiseerd bericht van afmelden.debolk.nl. Controleer de gegevens en neem contact op met de betrokkene als er iets niet klopt.
EOD;

// Send email
$transport = Transport::fromDsn($_ENV['MAILER_DSN']);
$mailer = new Mailer($transport);
$email = (new Email())
    ->from(new Address('no-reply@debolk.nl'))
    ->replyTo(new Address('secretaris@nieuwedelft.nl', 'Secretaris De Bolk'))
    ->to(
        new Address('secretaris@nieuwedelft.nl', 'Secretaris De Bolk'),
        new Address('thesaurier@nieuwedelft.nl', 'Thesaurier De Bolk'),
        new Address('vol@nieuwedelft.nl', 'VOL'),
    )
    ->subject('Lid-af formulier ' . $naam)
    ->text($email);
$mailer->send($email);

// Send response
echo 'Bedankt voor het invullen van dit formulier. Als de gegevens verwerkt zijn, krijg je een lid-afbevestiging per e-mail.';
