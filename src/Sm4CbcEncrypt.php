<?php
namespace Akimimi\Encrypt;

use Akimimi\Encrypt\Exception\DecryptFailedException;
use Akimimi\Encrypt\Exception\EncryptFailedException;

/**
 * Sm4CbcEncrypt provides SM4 CBC encrypt and decrypt algorithms.
 * Password and initialization vector(IV) length must be 16 bytes.
 * PKCS5 padding is set by default for data, zero padding is default for password.
 */
class Sm4CbcEncrypt extends BasicEncrypt {

  const DataBlockSize = 16;

  public function __construct() {
    $this->_pwdSize = self::DataBlockSize;
    $this->_dataBlockSize = self::DataBlockSize;
    $this->encryptOption = OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING;
    $this->setPadder(new ZeroPadder(), "password");
    $this->setPadder(new ZeroPadder(), "iv");
    $this->setPadder(new Pkcs5Padder(), "data");
    $this->algorithm = "SM4-CBC";
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
