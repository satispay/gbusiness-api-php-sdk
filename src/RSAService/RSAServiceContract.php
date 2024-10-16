<?php

namespace SatispayGBusiness\RSAService;

abstract class RSAServiceContract
{
    /**
     * Verifies that this RSA implementation is available.
     *
     * @return bool
     */
    abstract public static function isAvailable();

    /**
     * Generate a pair of RSA keys if not already generated.
     *
     * @return array
     */
    abstract public static function generateKeys();

    /**
     * Sign a string with the given private key.
     *
     * @param string $message The private key used for signing.
     * @param string $message The message that will be signed.
     *
     * @return string
     */
    abstract public static function sign($privateKey, $message);
}