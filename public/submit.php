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
 * Parse the form input
 */
$naam=$_POST["voornaam"] ?? 'niet ingevuld';
$adres=$_POST["adres"] ?? 'niet ingevuld';
$postcodeplaats=$_POST["postcodeplaats"] ?? 'niet ingevuld';
$telefoon=$_POST["telefoon"] ?? 'niet ingevuld';
$mail=$_POST["email"] ?? 'niet ingevuld';
$lidmaatschap=$_POST["lidmaatschap"] ?? 'niet ingevuld';
$vol=$_POST["vol"] ?? 'niet ingevuld';
$courant=$_POST['courant'] ?? 'nee';
$datum=$_POST["datum"] ?? 'niet ingevuld';
$plaats=$_POST["plaats"] ?? 'niet ingevuld';

// If ex-member is selected, override all settings on page 2 so we don't show default in the mail
if ($lidmaatschap === 'exlid') {
    $vol = 'nee';
    $courant = 'nee';
    $donatie = 'nee';
}

$donatie=$_POST['donatie'] ?? 'nee';
if ($donatie === 'ja') {
    $donatiebedrag=intval($_POST["donatiebedrag"]) ?? 'niet ingevuld';
    $donatiebestemming=$_POST["donatiebestemming"] ?? 'niet ingevuld';

    if ($donatiebestemming === 'Verdeeld') {
        $donatieverdelingBolk = intval($_POST['donatieverdeling']);
        $donatieverdelingVOL = $donatiebedrag - $donatieverdelingBolk;
    }
} else {
    $donatie = 'nee';
}

/*
 * Construct the email
 */

$sendEmailToVOL = ($vol === 'ja' || $donatiebestemming === 'VOL' || $donatiebestemming === 'Verdeeld');
$addressee = $sendEmailToVOL ? 'Secretaris, Thesaurier, en VOL-bestuur' : 'Secretaris en Thesaurier';

$email=<<<EOD
Beste $addressee,

$naam heeft zich afgemeld als lid van De Bolk. De gegevens zijn als volgt:

Adres:
$adres
$postcodeplaats

Telefoon: $telefoon
E-mailadres: $mail

Gewenst lidmaatschap: $lidmaatschap
Lid van de VOL: $vol

Bolksche Courant ontvangen: $courant \n\n
EOD;

// Add donation information
if ($donatie === 'ja') {
    $email.=<<<EOD
    Donatie: ja
    Donatiebedrag: €$donatiebedrag per kwartaal\n
    EOD;

    if ($donatiebestemming === 'Verdeeld') {
        $email.=<<<EOD
        Donatiebestemming: Verdeeld
        Donatieverdeling:
        - De Bolk: €$donatieverdelingBolk
        - VOL: €$donatieverdelingVOL \n\n
        EOD;
    }
    else {
        $email.=<<<EOD
        Donatiebestemming: $donatiebestemming \n\n
        EOD;
    }
}
else {
    $email.=<<<EOD
    Donatie: nee \n\n
    EOD;
}

// Add finalization information
$email.=<<<EOD
Datum: $datum
Plaats: $plaats

Dit is een geautomatiseerd bericht van afmelden.debolk.nl. Controleer de gegevens en neem contact op met de betrokkene als er iets niet klopt. \n
EOD;

/*
 * Send the email
 */
$transport = Transport::fromDsn($_ENV['MAILER_DSN']);
$mailer = new Mailer($transport);
$receipients = [
    new Address('secretaris@nieuwedelft.nl', 'Secretaris De Bolk'),
    new Address('thesaurier@nieuwedelft.nl', 'Thesaurier De Bolk'),
];
if ($sendEmailToVOL) {
    $receipients[] = new Address('vol@nieuwedelft.nl', 'VOL');
}
$email = (new Email())
    ->from(new Address('no-reply@debolk.nl'))
    ->replyTo(new Address('secretaris@nieuwedelft.nl', 'Secretaris De Bolk'))
    ->to(...$receipients)
    ->subject('Lid-af formulier ' . $naam)
    ->text($email);
$mailer->send($email);

/*
 * Confirmation response
 */
echo 'Bedankt voor het invullen van dit formulier. Als de gegevens verwerkt zijn, krijg je een lid-afbevestiging per e-mail.';
