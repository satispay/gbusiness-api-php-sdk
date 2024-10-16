<?php

require_once __DIR__ . '/../vendor/autoload.php';

\SatispayGBusiness\Api::setSandbox(true);

$authentication = \SatispayGBusiness\Api::authenticateWithToken('9KABLJ');

$publicKey = $authentication->publicKey;
$privateKey = $authentication->privateKey;
$keyId = $authentication->keyId;

file_put_contents(__DIR__ . '/authentication.json', json_encode([
  'public_key' => $publicKey,
  'private_key' => $privateKey,
  'key_id' => $keyId
], JSON_PRETTY_PRINT));
