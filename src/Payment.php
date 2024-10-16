<?php

namespace SatispayGBusiness;

class Payment {
    private static $apiPath = '/g_business/v1/payments';

    /**
     * Create a payment.
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
   * Get payment by id.
   * 
   * @param string $id
   * @param array $headers The format is: [header => value]
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

    /**
     * Get the payments list.
     * 
     * @param array $options
     * @param array $headers The format is: [header => value]
     */
    public static function all($query = [], $headers = [])
    {
        $path = self::$apiPath;

        if (!empty($query)) {
            $path .= '?' . http_build_query($query);
        }

        return
            Request::get(
                $path,
                [
                    'headers' => $headers,
                    'sign' => true
                ]
            );
    }

    /**
     * Update a payment.
     * 
     * @param string $id
     * @param array $body
     * @param array $headers The format is: [header => value]
     */
    public static function update($id, $body, $headers = [])
    {
        return
            Request::put(
                self::$apiPath. '/' . $id,
                [
                    'headers' => $headers,
                    'body' => $body,
                    'sign' => true
                ]
            );
    }
}
