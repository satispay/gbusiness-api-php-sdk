<?php

require_once("../init.php");

\SatispayGBusiness\Api::setSandbox(true);

$authData = json_decode(file_get_contents("authentication.json"));

\SatispayGBusiness\Api::setSecurityBearer($authData->security_bearer);

$result = \SatispayGBusiness\Api::testAuthentication();

var_dump($result);
