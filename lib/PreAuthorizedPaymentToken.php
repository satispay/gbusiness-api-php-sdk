<?php
namespace SatispayGBusiness;

class PreAuthorizedPaymentToken
{
    private static $apiPath = "/g_business/v1/pre_authorized_payment_tokens";

  /**
   * Create pre authorized payment token
   * @param array $body
   */
    public static function create($body)
    {
        return Request::post(self::$apiPath, [
        "body" => $body,
        "sign" => true
        ]);
    }

  /**
   * Get pre authorized payment token
   * @param string $id
   */
    public static function get($id)
    {
        return Request::get(self::$apiPath."/$id", [
        "sign" => true
        ]);
    }

  /**
   * Update pre authorized payment token
   * @param string $id
   * @param array $body
   */
    public static function update($id, $body)
    {
        return Request::put(self::$apiPath."/$id", [
        "body" => $body,
        "sign" => true
        ]);
    }    
}
