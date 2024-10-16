<?php

require_once __DIR__ . '/../vendor/autoload.php';

\SatispayGBusiness\Api::setSandbox(true);

$authData = json_decode(file_get_contents(__DIR__ . '/authentication.json'));

\SatispayGBusiness\Api::setPublicKey($authData->public_key);
\SatispayGBusiness\Api::setPrivateKey($authData->private_key);
\SatispayGBusiness\Api::setKeyId($authData->key_id);

$payment = \SatispayGBusiness\Payment::get('5f11eb3d-e442-441c-af7c-7c1d707e1f4e');

var_dump($payment);
