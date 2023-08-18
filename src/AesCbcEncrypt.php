<?php
namespace Akimimi\Encrypt;

use Akimimi\Encrypt\Exception\DecryptFailedException;
use Akimimi\Encrypt\Exception\EncryptFailedException;

/**
 * AesCbcEncrypt provides AES CBC encrypt and decrypt algorithms.
 * Password length must be 16/24/32 bytes. Zero padding is set by default.
 */
class AesCbcEncrypt extends BasicEncrypt {

  const DataBlockSize = 16;

  public function __construct(int $bytes = 16) {
    $this->_pwdSize = $bytes;
    $this->_dataBlockSize = self::DataBlockSize;
    $this->setPadder(new ZeroPadder(), "all");
    $this->encryptOption = OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING;
    switch ($bytes) {
      case 16:
        $this->algorithm = "AES-128-CBC";
        break;
      case 24:
        $this->algorithm = "AES-192-CBC";
        break;
      case 32:
        $this->algorithm = "AES-256-CBC";
        break;
      default:
        trigger_error(
          "AES algorithm password length must be 16/24/32 bytes.",
          E_USER_ERROR);
    }
  }

  /**
   * Encrypt data with AES-CBC algorithm.
   * @param string $data
   * @return string
   */
  public function encrypt(string $data): string {
    if (empty($this->_iv)) {
      throw new EncryptFailedException(
        "Initialization vector should not be empty for CBC algorithm.");
    }
    return parent::encrypt($data);
  }

  /**
   * Decrypt data with AES-CBC algorithm.
   * @param string $data
   * @return string
   */
  public function decrypt(string $data): string {
    if (empty($this->_iv)) {
      throw new DecryptFailedException(
        "Initialization vector should not be empty for CBC algorithm.");
    }
    return parent::decrypt($data);
  }
}