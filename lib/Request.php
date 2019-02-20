<?php
namespace SatispayGBusiness;

class Request {
  private static $userAgentName = "SatispayGBusinessApiPhpSdk";

  /**
   * GET request
   * @param string $path
   * @param array $options
  */
  public static function get($path, $options = array()) {
    $requestOptions = array(
      "path" => $path,
      "method" => "GET"
    );

    if (!empty($options["sign"])) {
      $requestOptions["sign"] = $options["sign"];
    }

    return self::request($requestOptions);
  }

  /**
   * POST request
   * @param string $path
   * @param array $options
  */
  public static function post($path, $options = array()) {
    $requestOptions = array(
      "path" => $path,
      "method" => "POST",
      "body" => $options["body"]
    );

    if (!empty($options["sign"])) {
      $requestOptions["sign"] = $options["sign"];
    }

    return self::request($requestOptions);
  }

  /**
   * PUT request
   * @param string $path
   * @param array $options
  */
  public static function put($path, $options = array()) {
    $requestOptions = array(
      "path" => $path,
      "method" => "PUT",
      "body" => $options["body"]
    );

    if (!empty($options["sign"])) {
      $requestOptions["sign"] = $options["sign"];
    }

    return self::request($requestOptions);
  }

  /**
   * PATCH request
   * @param string $path
   * @param array $options
  */
  public static function patch($path, $options = array()) {
    $requestOptions = array(
      "path" => $path,
      "method" => "PATCH",
      "body" => $options["body"]
    );

    if (!empty($options["sign"])) {
      $requestOptions["sign"] = $options["sign"];
    }

    return self::request($requestOptions);
  }

  /**
   * Sign request
   * @param array $options
  */
  private static function signRequest($options = array()) {
    $headers = array();
    $authorizationHeader = "";

    $privateKey = Api::getPrivateKey();
    $keyId = Api::getKeyId();
    $securityBearer = Api::getSecurityBearer();

    if (!empty($privateKey) && !empty($keyId)) {
      $date = date("r");
      array_push($headers, "Date: ".$date);

      $signature = "(request-target): ".strtolower($options["method"])." ".$options["path"]."\n";
      $signature .= "host: ".str_replace("https://", "", Api::getAuthservicesUrl())."\n";

      $digest = base64_encode(hash("sha256", $options["body"], true));
      array_push($headers, "Digest: SHA-256=".$digest);
      if (!empty($options["body"])) {
        $signature .= "content-type: application/json\n";
        $signature .= "content-length: ".strlen($options["body"])."\n";
      }
      $signature .= "digest: SHA-256=$digest\n";

      $signature .= "date: $date";

      openssl_sign($signature, $signedSignature, $privateKey, OPENSSL_ALGO_SHA256);
      $base64SignedSignature = base64_encode($signedSignature);

      $signatureHeaders = "(request-target) host digest date";
      if (!empty($options["body"])) {
        $signatureHeaders = "(request-target) host content-type content-length digest date";
      }

      $authorizationHeader = "Signature keyId=\"$keyId\", algorithm=\"rsa-sha256\", headers=\"$signatureHeaders\", signature=\"$base64SignedSignature\"";
    } else if (!empty($securityBearer)) {
      $authorizationHeader = "Bearer $securityBearer";
    }

    if (!empty($authorizationHeader)) {
      array_push($headers, "Authorization: $authorizationHeader");
    }

    return array(
      "headers" => $headers
    );
  }

  /**
   * Execute request
   * @param array $options
  */
  private static function request($options = array()) {
    $body = "";
    $headers = array(
      "Accept: application/json",
      "User-Agent: ".self::$userAgentName."/".Api::getVersion()
    );
    $method = "GET";

    if (!empty($options["method"])) {
      $method = $options["method"];
    }

    if (!empty($options["body"])) {
      array_push($headers, "Content-Type: application/json");
      $body = json_encode($options["body"]);
      array_push($headers, "Content-Length: ".strlen($body));
    }

    $sign = false;
    if (!empty($options["sign"])) {
      $sign = $options["sign"];
    }

    if ($sign) {
      $signResult = self::signRequest(array(
        "body" => $body,
        "method" => $method,
        "path" => $options["path"]
      ));
      $headers = array_merge($headers, $signResult["headers"]);
    }

    $curlResult = self::curl(array(
      "url" => Api::getAuthservicesUrl().$options["path"],
      "method" => $method,
      "body" => $body,
      "headers" => $headers
    ));

    if (!empty($curlResult["errorCode"]) && !empty($curlResult["errorMessage"])) {
      throw new \Exception($curlResult["errorMessage"], $curlResult["errorCode"]);
    }

    $isResponseOk = true;
    if ($curlResult["status"] < 200 || $curlResult["status"] > 299) {
      $isResponseOk = false;
    }

    $responseData = json_decode($curlResult["body"]);

    if (!$isResponseOk) {
      if (!empty($responseData->message) && !empty($responseData->code) && !empty($responseData->wlt)) {
        throw new \Exception($responseData->message.", request id: ".$responseData->wlt, $responseData->code);
      } else {
        throw new \Exception("HTTP status is not 2xx");
      }
    }

    return $responseData;
  }

  /**
   * Curl request
   * @param array $options
  */
  private static function curl($options = array()) {
    $curlOptions = array();
    $curl = curl_init();

    $curlOptions[CURLOPT_URL] = $options["url"];
    $curlOptions[CURLOPT_RETURNTRANSFER] = true;

    if ($options["method"] != "GET") {
      if ($options["method"] != "POST") {
        $curlOptions[CURLOPT_CUSTOMREQUEST] = $options["method"];
      }
      $curlOptions[CURLOPT_POSTFIELDS] = $options["body"];
      $curlOptions[CURLOPT_POST] = true;
    } else {
      $curlOptions[CURLOPT_HTTPGET] = true;
    }

    if (Api::getEnv() == "test") {
      $curlOptions[CURLOPT_VERBOSE] = true;
      $curlOptions[CURLOPT_SSL_VERIFYHOST] = false;
      $curlOptions[CURLOPT_SSL_VERIFYPEER] = false;
    }

    $curlOptions[CURLOPT_HTTPHEADER] = $options["headers"];
    curl_setopt_array($curl, $curlOptions);

    $responseJson = curl_exec($curl);
    $responseStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $curlErrorCode = curl_errno($curl);
    $curlErrorMessage = curl_error($curl);
    curl_close($curl);

    return array(
      "body" => $responseJson,
      "status" => $responseStatus,
      "errorCode" => $curlErrorCode,
      "errorMessage" => $curlErrorMessage
    );
  }
}
