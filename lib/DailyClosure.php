<?php
namespace SatispayGBusiness;

class DailyClosure
{
    private static $apiPath = "/g_business/v1/daily_closure";

  /**
   * Get daily clousure
   * @param string $date
   * @param array $options
   */
    public static function get($date = null, $options = [])
    {
        $queryString = "";
        if (!$date) {
            $date = date("Ymd");
        }
        if (!empty($options)) {
            $queryString .= "?";
            $queryString .= http_build_query($options);
        }
        return Request::get(self::$apiPath."/".$date.$queryString, [
        "sign" => true
        ]);
    }
}
