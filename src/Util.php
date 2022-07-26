<?php
namespace Akimimi\Encrypt;

class Util {
  /**
   * Padding zeros(\0) in tail of $data.
   * @param string $data
   * @param int $blockSize
   * @return string
   */
  static public function PaddingZero(string $data, int $blockSize = 16) :string {
    $pad = $blockSize - (strlen($data) % $blockSize);
    return $data . str_repeat("\0", $pad);
  }

  /**
   * Remove zeros(\0) in tail of $data.
   * @param string $data
   * @return string
   */
  static public function RtrimZero(string $data) :string {
    return rtrim($data, "\0");
  }
}
