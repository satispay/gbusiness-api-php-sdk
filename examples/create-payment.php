<?php

require_once('../vendor/autoload.php');

\SatispayGBusiness\Api::setSandbox(true);

$authData = json_decode(file_get_contents('authentication.json'));

\SatispayGBusiness\Api::setPublicKey($authData->public_key);
\SatispayGBusiness\Api::setPrivateKey($authData->private_key);
\SatispayGBusiness\Api::setKeyId($authData->key_id);

$payment = \SatispayGBusiness\Payment::create([
  'flow' => 'MATCH_CODE',
  'amount_unit' => 199,
  'currency' => 'EUR'
]);

var_dump($payment);
