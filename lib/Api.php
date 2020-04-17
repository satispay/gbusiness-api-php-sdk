<?php
namespace SatispayGBusiness;

class Api
{
    private static $env = "production";
    private static $privateKey;
    private static $publicKey;
    private static $keyId;
    private static $version = "1.2.0";
    private static $authservicesUrl = "https://authservices.satispay.com";
    private static $platformVersionHeader;
    private static $pluginVersionHeader;
    private static $pluginNameHeader;
    private static $typeHeader;

  /**
   * Generate new keys and authenticate with token
   * @param string $token
   */
    public static function authenticateWithToken($token)
    {
        $pkeyResource = openssl_pkey_new([
        "digest_alg" => "sha256",
        "private_key_bits" => 2048
        ]);

        openssl_pkey_export($pkeyResource, $generatedPrivateKey);

        $pkeyResourceDetails = openssl_pkey_get_details($pkeyResource);
        $generatedPublicKey = $pkeyResourceDetails["key"];

        $requestResult = Request::post("/g_business/v1/authentication_keys", [
        "body" => [
        "public_key" => $generatedPublicKey,
        "token" => $token
        ]
        ]);

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
   * Get env
   * @return string
   */
    public static function getEnv()
    {
        return self::$env;
    }
  /**
   * Set env
   * @param string $value
   */
    public static function setEnv($value)
    {
        self::$env = $value;
        if ($value == "production") {
            self::$authservicesUrl = "https://authservices.satispay.com";
        } else {
            self::$authservicesUrl = "https://".$value.".authservices.satispay.com";
        }
    }

  /**
   * Get platform version header
   * @return string
   */
    public static function getPlatformVersionHeader()
    {
        return self::$platformVersionHeader;
    }
  /**
   * Set platform version header
   * @param string $value
   */
    public static function setPlatformVersionHeader($value)
    {
        self::$platformVersionHeader = $value;
    }

  /**
   * Get plugin version header
   * @return string
   */
    public static function getPluginVersionHeader()
    {
        return self::$pluginVersionHeader;
    }
  /**
   * Set plugin version header
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
   * Set plugin name header
   * @param string $value
   */
    public static function setPluginNameHeader($value)
    {
        self::$pluginNameHeader = $value;
    }

  /**
   * Get type header
   * @return string
   */
    public static function getTypeHeader()
    {
        return self::$typeHeader;
    }
  /**
   * Set type header
   * @param string $value
   */
    public static function setTypeHeader($value)
    {
        self::$typeHeader = $value;
    }

  /**
   * Get private key
   * @return string
   */
    public static function getPrivateKey()
    {
        return self::$privateKey;
    }
  /**
   * Set private key
   * @param string $value
   */
    public static function setPrivateKey($value)
    {
        self::$privateKey = $value;
    }

  /**
   * Get public key
   * @return string
   */
    public static function getPublicKey()
    {
        return self::$publicKey;
    }
  /**
   * Set public key
   * @param string $value
   */
    public static function setPublicKey($value)
    {
        self::$publicKey = $value;
    }

  /**
   * Get key id
   * @return string
   */
    public static function getKeyId()
    {
        return self::$keyId;
    }
  /**
   * Set key id
   * @param string $value
   */
    public static function setKeyId($value)
    {
        self::$keyId = $value;
    }

  /**
   * Get version
   * @return string
   */
    public static function getVersion()
    {
        return self::$version;
    }

  /**
   * Get authservices url
   * @return string
   */
    public static function getAuthservicesUrl()
    {
        return self::$authservicesUrl;
    }

  /**
   * Is sandbox enabled?
   * @return boolean
   */
    public static function getSandbox()
    {
        if (self::$env == "staging") {
            return true;
        } else {
            return false;
        }
    }
  /**
   * Enable or disable sandbox
   * @param boolean $value
   */
    public static function setSandbox($value)
    {
        if ($value == true) {
            self::setEnv("staging");
        } else {
            self::setEnv("production");
        }
    }
}
