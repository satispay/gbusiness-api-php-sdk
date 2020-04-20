# Satispay GBusiness API PHP SDK

[![Packagist Version](https://img.shields.io/packagist/v/satispay/gbusiness-api-php-sdk.svg?style=flat-square)](https://packagist.org/packages/satispay/gbusiness-api-php-sdk)
[![Packagist Downloads](https://img.shields.io/packagist/dt/satispay/gbusiness-api-php-sdk.svg?style=flat-square)](https://packagist.org/packages/satispay/gbusiness-api-php-sdk)

## Installation

Run the following command:

```bash
composer require satispay/gbusiness-api-php-sdk
```

If you do not wish to use Composer, import the `init.php` file.

```php
require_once("/path/init.php");
```

## Documentation

https://developers.satispay.com

## Authenticate with RSA Signature

Sign in to your [Dashboard](https://business.satispay.com) at [business.satispay.com](https://business.satispay.com), click "Negozi Online" or "Negozi Fisici", and then click on "Genera un token di attivazione" to generate an activation token.

Use the activation token with the `authenticateWithToken` function to generate and exchange a pair of RSA keys.

Save the keys in your database or in a **safe place** not accesibile from your website.

```php
// Authenticate and generate the keys
$authentication = \SatispayGBusiness\Api::authenticateWithToken("XXXXXX");

// Export keys
$publicKey = $authentication->publicKey;
$privateKey = $authentication->privateKey;
$keyId = $authentication->keyId;
```

Reuse the keys after authentication.

```php
// Keys variables
$publicKey = "-----BEGIN PUBLIC KEY-----\nMIIBIjANBgkqhk...";
$privateKey = "-----BEGIN PRIVATE KEY-----\nMIIEvQIBADANBg...";
$keyId = "ldg9sbq283og7ua1abpj989kbbm2g60us6f18c1sciq...";

// Set keys
\SatispayGBusiness\Api::setPublicKey($publicKey);
\SatispayGBusiness\Api::setPrivateKey($privateKey);
\SatispayGBusiness\Api::setKeyId($keyId);
```

## Enable Sandbox

To enable sandbox use `setSandbox` function.
```php
\SatispayGBusiness\Api::setSandbox(true);
```

## Changelog

### 1.2.1

- Added `\SatispayGBusiness\ApiAuthentication` class.
- Performed code refactoring to adhere to PSR2 Coding Standards 

### 1.2.0

- Added `\SatispayGBusiness\PreAuthorizedPaymentToken` class.

### 1.1.1

- Fixed composer file version

### 1.1.0

- Removed `\SatispayGBusiness\Api::testAuthentication()` method.
- Removed `\SatispayGBusiness\Api::getSecurityBearer()` method.
- Removed `\SatispayGBusiness\Api::setSecurityBearer()` method.

- Added `\SatispayGBusiness\Api::getPlatformVersionHeader()` method.
- Added `\SatispayGBusiness\Api::setPlatformVersionHeader()` method.

- Added `\SatispayGBusiness\Api::getPluginVersionHeader()` method.
- Added `\SatispayGBusiness\Api::setPluginVersionHeader()` method.

- Added `\SatispayGBusiness\Api::getPluginNameHeader()` method.
- Added `\SatispayGBusiness\Api::setPluginNameHeader()` method.

- Added `\SatispayGBusiness\Api::getTypeHeader()` method.
- Added `\SatispayGBusiness\Api::setTypeHeader()` method.
