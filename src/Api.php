<?php

namespace SatispayGBusiness;

class Api {
    private static $env = 'production';
    private static $privateKey;
    private static $publicKey;
    private static $keyId;
    private static $version = '1.4.1';
    private static $authservicesUrl = 'https://authservices.satispay.com';
    private static $platformVersionHeader;
    private static $platformHeader;
    private static $pluginVersionHeader;
    private static $pluginNameHeader;
    private static $typeHeader;
    private static $trackingHeader;

    /**
     * Generate new keys and authenticate with token.
     * 
     * @param string $token
     */
    public static function authenticateWithToken($token)
    {
        $RSAService = RSAServiceFactory::get();
        $RSAKeys = $RSAService::generateKeys();

        $generatedPrivateKey = $RSAKeys['private_key'];
        $generatedPublicKey = $RSAKeys['public_key'];

        $requestResult = Request::post(
            '/g_business/v1/authentication_keys',
            [
                'body' => [
                    'public_key' => $generatedPublicKey,
                    'token' => $token
                ]
            ]
        );

        self::$privateKey = $generatedPrivateKey;
        self::$publicKey = $generatedPublicKey;
        self::$keyId = $requestResult->key_id;

        $returnClass = new ApiAuthentication();
        $returnClass->privateKey = $generatedPrivateKey;
        $returnClass->publicKey = $generatedPublicKey;
        $returnClass->keyId = $requestResult->key_id;

        return $returnClass;
    }

    /**
     * Get the current environment.
     * 
     * @return string
     */
    public static function getEnv()
    {
        return self::$env;
    }

    /**
     * Set the current environment.
     * 
     * @param string $value
     */
    public static function setEnv($value)
    {
        self::$env = $value;

        if ($value == 'production') {
            self::$authservicesUrl = 'https://authservices.satispay.com';
        } else {
            self::$authservicesUrl = 'https://' . $value . '.authservices.satispay.com';
        }
    }

    /**
     * Get platform version header.
     * 
     * @return string
     */
    public static function getPlatformVersionHeader()
    {
        return self::$platformVersionHeader;
    }

    /**
     * Set platform version header.
     * 
     * @param string $value
     */
    public static function setPlatformVersionHeader($value)
    {
        self::$platformVersionHeader = $value;
    }

    /**
     * Get platform header.
     * 
     * @return string
     */
    public static function getPlatformHeader()
    {
        return self::$platformHeader;
    }

    /**
     * Set platform header.
     * 
     * @param string $value
     */
    public static function setPlatformHeader($value)
    {
        self::$platformHeader = $value;
    }

    /**
     * Get plugin version header.
     * 
     * @return string
     */
    public static function getPluginVersionHeader()
    {
        return self::$pluginVersionHeader;
    }

    /**
     * Set plugin version header.
     * 
     * @param string $value
     */
    public static function setPluginVersionHeader($value)
    {
        self::$pluginVersionHeader = $value;
    }

  /**
   * Get plugin name header
   * @return string
   */
    public static function getPluginNameHeader()
    {
        return self::$pluginNameHeader;
    }

    /**
     * Set plugin name header.
     * 
     * @param string $value
     */
    public static function setPluginNameHeader($value)
    {
        self::$pluginNameHeader = $value;
    }

    /**
     * Get type header.
     * 
     * @return string
     */
    public static function getTypeHeader()
    {
        return self::$typeHeader;
    }

    /**
     * Set type header.
     * 
     * @param string $value
     */
    public static function setTypeHeader($value)
    {
        self::$typeHeader = $value;
    }

    /**
     * Get tracking header.
     * 
     * @return string
     */
    public static function getTrackingHeader()
    {
        return self::$trackingHeader;
    }

    /**
     * Set tracking header.
     * 
     * @param string $value
     */
    public static function setTrackingHeader($value)
    {
        self::$trackingHeader = $value;
    }

    /**
     * Get private key.
     * 
     * @return string
     */
    public static function getPrivateKey()
    {
        return self::$privateKey;
    }

    /**
     * Set the private key.
     * 
     * @param string $value
     */
    public static function setPrivateKey($value)
    {
        self::$privateKey = $value;
    }

    /**
     * Get public key.
     * 
     * @return string
     */
    public static function getPublicKey()
    {
        return self::$publicKey;
    }

    /**
     * Set the public key.
     * 
     * @param string $value
     */
    public static function setPublicKey($value)
    {
        self::$publicKey = $value;
    }

    /**
     * Get the current KeyId.
     * 
     * @return string
     */
    public static function getKeyId()
    {
        return self::$keyId;
    }

    /**
     * Set the KeyId.
     * 
     * @param string $value
     */
    public static function setKeyId($value)
    {
        self::$keyId = $value;
    }

    /**
     * Get version.
     * 
     * @return string
     */
    public static function getVersion()
    {
        return self::$version;
    }

    /**
     * Get authservices url.
     * 
     * @return string
     */
    public static function getAuthservicesUrl()
    {
        return self::$authservicesUrl;
    }

    /**
     * Is sandbox enabled?
     * 
     * @return boolean
     */
    public static function getSandbox()
    {
        return self::$env === 'staging';
    }

    /**
     * Enable or disable sandbox.
     * 
     * @param boolean $value
     */
    public static function setSandbox($value = true)
    {
        self::setEnv((bool) $value === true ? 'staging' : 'production');
    }
}
