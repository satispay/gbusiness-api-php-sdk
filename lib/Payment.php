<?php
namespace SatispayGBusiness;

class Payment
{
    private static $apiPath = "/g_business/v1/payments";

  /**
   * Create payment
   * @param array $body
   * @param array $createOptions = [idempotency_key]
   * @see https://developers.satispay.com/reference/idempotency
   */
    public static function create($body, $createOptions = [])
    {
      $options = [
        "body" => $body,
        "sign" => true
      ];
      if (!empty($createOptions["idempotency_key"]) && is_string($createOptions["idempotency_key"])) {
        $options["idempotency_key"] = $createOptions["idempotency_key"];
      }
      return Request::post(self::$apiPath, $options);
    }

  /**
   * Get payment
   * @param string $id
   */
    public static function get($id)
    {
        return Request::get(self::$apiPath."/$id", [
        "sign" => true
        ]);
    }

  /**
   * Get payments list
   * @param array $options
   */
    public static function all($options = [])
    {
        $queryString = "";
        if (!empty($options)) {
            $queryString .= "?";
            $queryString .= http_build_query($options);
        }
        return Request::get(self::$apiPath.$queryString, [
        "sign" => true
        ]);
    }

  /**
   * Update payment
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
