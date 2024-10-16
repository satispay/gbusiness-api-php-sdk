<?php

require_once('../vendor/autoload.php');

\SatispayGBusiness\Api::setSandbox(true);

$authentication = \SatispayGBusiness\Api::authenticateWithToken('WG5MUC');

$publicKey = $authentication->publicKey;
$privateKey = $authentication->privateKey;
$keyId = $authentication->keyId;

file_put_contents('authentication.json', json_encode([
  'public_key' => $publicKey,
  'private_key' => $privateKey,
  'key_id' => $keyId
], JSON_PRETTY_PRINT));
