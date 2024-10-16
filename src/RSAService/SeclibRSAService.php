<?php

namespace SatispayGBusiness\RSAService;

use \Exception;

/**
 * Class SeclibRSAService
 *
 * RSA Service implemented via phpseclib.
 */
class SeclibRSAService extends RSAServiceContract
{
    /**
     * @inheritdoc
     */
    public static function isAvailable()
    {
        return class_exists('phpseclib\Crypt\RSA');
    }

    /**
     * @inheritdoc
     */
    public static function generateKeys()
    {
        try {
            // Generate the private key
            $rsa = new \phpseclib\Crypt\RSA();
            $rsa->setPublicKeyFormat(\phpseclib\Crypt\RSA::PUBLIC_FORMAT_PKCS1);
            $rsa->setPrivateKeyFormat(\phpseclib\Crypt\RSA::PRIVATE_FORMAT_PKCS1);
            $rsa->setEncryptionMode(\phpseclib\Crypt\RSA::ENCRYPTION_PKCS1);

            $privateKey = $rsa->createKey(2048);

            return ['private_key' => $privateKey['privatekey'], 'public_key' => $privateKey['publickey']];
        } catch (Exception $e) {
            throw new Exception('An unexpected error occurred: ' . $e->getMessage());
        }
    }

    /**
     * @inheritdoc
     */
    public static function sign($privateKey, $message)
    {
        try {
            $rsa = new \phpseclib\Crypt\RSA();
            $rsa->loadKey($privateKey, \phpseclib\Crypt\RSA::PRIVATE_FORMAT_PKCS8);
            $rsa->setHash('sha256');
            $rsa->setSignatureMode(\phpseclib\Crypt\RSA::SIGNATURE_PKCS1);

            return $rsa->sign($message);
        } catch (Exception $e) {
            throw new Exception('Signing failed: ' . $e->getMessage());
        }
    }
}
