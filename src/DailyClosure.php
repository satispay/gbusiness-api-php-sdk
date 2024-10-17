<?php

namespace SatispayGBusiness;

class DailyClosure
{
    private static $apiPath = "/g_business/v1/daily_closure";

    /**
     * Get daily clousure.
     * @see https://developers.satispay.com/reference/retrieve-daily-closure
     * 
     * @param string $date
     * @param array $options
     */
    public static function get($date = null, $query = [], $headers = [])
    {
        if (!$date) {
            $date = date('Ymd');
        }

        $path = self::$apiPath . '/' . $date;

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
}