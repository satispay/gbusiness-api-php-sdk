<?php

require_once __DIR__ . '/../vendor/autoload.php';

\SatispayGBusiness\Api::setSandbox(true);

$authData = json_decode(file_get_contents(__DIR__ . '/authentication.json'));

\SatispayGBusiness\Api::setPublicKey($authData->public_key);
\SatispayGBusiness\Api::setPrivateKey($authData->private_key);
\SatispayGBusiness\Api::setKeyId($authData->key_id);

$preAuthorizedPaymentToken = \SatispayGBusiness\PreAuthorizedPaymentToken::get('8de0732f-8626-407a-a05f-135fc441df6e');

var_dump($preAuthorizedPaymentToken);
