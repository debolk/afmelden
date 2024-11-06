<?php

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
$dotenv->required('HCAPTCHA_SITEKEY')->notEmpty();
$dotenv->required('HCAPTCHA_SECRET')->notEmpty();
