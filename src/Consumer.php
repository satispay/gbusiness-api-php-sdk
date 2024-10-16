<?php

namespace SatispayGBusiness;

class Consumer {
    private static $apiPath = '/g_business/v1/consumers';

    /**
     * Get consumer by phone number.
     * 
     * @param string $phoneNumber
     * @param array $headers The format is: [header => value]
     */
    public static function get($phoneNumber, $headers = [])
    {
        return
            Request::get(
                self::$apiPath . '/' . $phoneNumber,
                [
                    'headers' => $headers,
                    'sign' => true
                ]
            );
    }
}
