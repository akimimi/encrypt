<?php
namespace Akimimi\Encrypt;

/**
 * PKCS5 Padding utility class.
 */
class Pkcs5Padder implements Padder {

  /**
   * Padding chr(\0 + n) for n times to fill block with blockSize length.
   * @param string $data
   * @param int $blockSize
   * @return string
   */
  function pad(string $data, int $blockSize): string {
    $pad = ($blockSize - (strlen($data) % $blockSize));
    return $data . str_repeat(chr(ord("\0") + $pad), $pad);
  }

  /**
   * Remove the last n length chr(\0 + n) characters.
   * @param string $data
   * @param int $blockSize
   * @return string
   */
  function trim(string $data, int $blockSize = 0): string {
    if ($blockSize == 0) {
      return $data;
    }

    $last = $data[strlen($data) - 1];
    $lastPad = ord($last) - ord("\0");
    if ($lastPad > 0 && $lastPad <= $blockSize) {
      return rtrim($data, chr(ord("\0") + $lastPad));
    } else {
      return $data;
    }
  }
}