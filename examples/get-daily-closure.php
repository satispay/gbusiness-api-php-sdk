<?php

require_once __DIR__ . '/../vendor/autoload.php';

\SatispayGBusiness\Api::setSandbox(true);

$authData = json_decode(file_get_contents(__DIR__ . '/authentication.json'));

\SatispayGBusiness\Api::setPublicKey($authData->public_key);
\SatispayGBusiness\Api::setPrivateKey($authData->private_key);
\SatispayGBusiness\Api::setKeyId($authData->key_id);

$dailyClosure = \SatispayGBusiness\DailyClosure::get(null, [
    'generate_pdf' => 'true'
]);

var_dump($dailyClosure);
