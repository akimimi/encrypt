<?php
namespace Akimimi\Encrypt;

/**
 * Zero padding utility class.
 */
class ZeroPadder implements Padder {

  /**
   * Padding zeros(\0) in tail of $data.
   * @param string $data
   * @param int $blockSize
   * @return string
   */
  function pad(string $data, int $blockSize): string {
    $pad = ($blockSize - (strlen($data) % $blockSize)) % $blockSize;
    return $data . str_repeat("\0", $pad);
  }

  /**
   * Remove zeros(\0) in tail of $data.
   * @param string $data
   * @param int $blockSize
   * @return string
   */
  function trim(string $data, int $blockSize = 0): string {
    return rtrim($data, "\0");
  }
}
