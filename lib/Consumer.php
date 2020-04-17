<?php
namespace SatispayGBusiness;

class Consumer
{
    private static $apiPath = "/g_business/v1/consumers";

  /**
   * Get consumer
   * @param string $phoneNumber
   */
    public static function get($phoneNumber)
    {
        return Request::get(self::$apiPath."/$phoneNumber", [
        "sign" => true
        ]);
    }
}
