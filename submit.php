<?php
/*print_r($_POST);*/
print("Bedankt voor het invullen van dit formulier. Als de gegevens verwerkt zijn krijg je een lid-afbevestiging via de post.");
$naam=$_POST["voornaam"];
$adres1=$_POST["adres"];
$adres2=$_POST["postcodeplaats"];
$telefoon=$_POST["telefoon"];
$mail=$_POST["email"];
$lidmaatschap=$_POST["lidmaatschap"];
$vol=$_POST["vol"];
$donatie=$_POST['donatiebolk'];
$donatiebedrag=$_POST["bedrag"];
$grimgram=$_POST['grimgram'];
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
Donatie: $donatie $bedrag
$grimgram
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
Donatie: $donatie $bedrag
$datum $plaats
";

mail ('Secretaris <secretaris@nieuwedelft.nl>', 'Lid-af formulier', "$templatesec",'Lid-af formulier', "-f " . 'secretaris@nieuwedelft.nl');

mail ('VOL <vol@nieuwedelft.nl>', 'Lid-af formulier', "$templatevol",'Lid-af formulier', "-f " . ' secretaris@nieuwedelft.nl');

mail ('Thesaurier <thesaurier@nieuwedelft.nl>', 'Lid-af formulier', "$templatethe",'Lid-af formulier', "-f " . 'secretaris@nieuwedelft.nl');



?>


