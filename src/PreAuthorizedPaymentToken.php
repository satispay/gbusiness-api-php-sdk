<?php

namespace SatispayGBusiness;

class PreAuthorizedPaymentToken {
    private static $apiPath = '/g_business/v1/pre_authorized_payment_tokens';

    /**
     * Create pre authorized payment token.
     * 
     * @param array $body
     * @param array $headers The format is: [header => value]
     */
    public static function create($body, $headers = [])
    {
        return
            Request::post(
                self::$apiPath,
                [
                    'headers' => $headers,
                    'body' => $body,
                    'sign' => true
                ]
            );
    }

    /**
     * Get pre authorized payment token.
     * 
     * @param string $id
     */
    public static function get($id, $headers = [])
    {
        return
            Request::get(
                self::$apiPath . '/' . $id,
                [
                    'headers' => $headers,
                    'sign' => true
                ]
            );
    }
}
