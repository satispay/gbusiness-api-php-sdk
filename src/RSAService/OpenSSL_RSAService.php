<?php

namespace SatispayGBusiness\RSAService;

use \Exception;

/**
 * Class OpenSSL_RSAService
 *
 * RSA Service implemented via OpenSSL.
 */
class OpenSSL_RSAService extends RSAServiceContract
{
    /**
     * @inheritdoc
     */
    public static function isAvailable()
    {
        return extension_loaded('openssl');
    }

    /**
     * @inheritdoc
     */
    public static function generateKeys()
    {
        $pkeyResource = openssl_pkey_new([
            'digest_alg' => 'sha256',
            'private_key_bits' => 2048,
        ]);

        if ($pkeyResource === false) {
            throw new Exception('Failed to generate private key: ' . openssl_error_string());
        }

        $privateKeyExported = openssl_pkey_export($pkeyResource, $newPrivateKey);

        if ($privateKeyExported === false) {
            throw new Exception('Failed to export private key: ' . openssl_error_string());
        }

        $pkeyResourceDetails = openssl_pkey_get_details($pkeyResource);

        if ($pkeyResourceDetails === false) {
            throw new Exception('Failed to get key details: ' . openssl_error_string());
        }

        $newPublicKey = $pkeyResourceDetails['key'];

        return ['private_key' => $newPrivateKey, 'public_key' => $newPublicKey];
    }

    /**
     * @inheritdoc
     */
    public static function sign($privateKey, $message)
    {
        $privateKeyResource = openssl_pkey_get_private($privateKey);

        if (!$privateKeyResource) {
            throw new Exception('Failed to get private key: ' . openssl_error_string());
        }

        $signed = '';

        if (!openssl_sign($message, $signed, $privateKeyResource, OPENSSL_ALGO_SHA256)) {
            throw new Exception('Signing failed: ' . openssl_error_string());
        }

        return $signed;
    }
}
