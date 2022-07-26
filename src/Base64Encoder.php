<?php
namespace Akimimi\Encrypt;

class Base64Encoder extends BasicEncoder implements Encoder {

  /**
   * Encode data with base64_encode function.
   * @param string $data
   * @return string
   */
  function encode(string $data): string {
    return base64_encode($data);
  }

  /**
   * Decode data with base64_decode function.
   * 'strict' parameter can be set by setParams function.
   * @param string $data
   * @return string
   */
  function decode(string $data): string {
    $strict = $this->params['strict'] ?? false;
    return base64_decode($data, (bool)$strict);
  }
}
