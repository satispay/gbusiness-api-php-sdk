<?php
namespace SatispayGBusiness;

class Payment {
  private static $apiPath = "/g_business/v1/payments";

  /**
   * Create payment
   * @param array $body
  */
  public static function create($body) {
    return Request::post(self::$apiPath, array(
      "body" => $body,
      "sign" => true
    ));
  }

  /**
   * Get payment
   * @param string $id
  */
  public static function get($id) {
    return Request::get(self::$apiPath."/$id", array(
      "sign" => true
    ));
  }

  /**
   * Get payments list
   * @param array $options
  */
  public static function all($options = array()) {
    $queryString = "";
    if (!empty($options)) {
      $queryString .= "?";
      $queryString .= http_build_query($options);
    }
    return Request::get(self::$apiPath.$queryString, array(
      "sign" => true
    ));
  }

  /**
   * Update payment
   * @param string $id
   * @param array $body
  */
  public static function update($id, $body) {
    return Request::put(self::$apiPath."/$id", array(
      "body" => $body,
      "sign" => true
    ));
  }
}
