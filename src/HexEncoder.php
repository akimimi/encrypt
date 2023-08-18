<?php
namespace Akimimi\Encrypt;

class HexEncoder extends BasicEncoder implements Encoder
{

  /**
   * Encode data with bin2hex function.
   * @param string $data
   * @return string
   */
  function encode(string $data): string {
    return bin2hex($data);
  }

  /**
   * Decode data with hex2bin function.
   * 'strict' parameter can be set by setParams function.
   * @param string $data
   * @return string
   */
  function decode(string $data): string {
    return hex2bin($data);
  }
}
