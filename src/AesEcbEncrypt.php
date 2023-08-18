<?php
namespace Akimimi\Encrypt;

/**
 * AesEcbEncrypt provides AES ECB encrypt and decrypt algorithms.
 * Password length must be 16/24/32 bytes. Zero padding is set by default.
 */
class AesEcbEncrypt extends BasicEncrypt {

  const DataBlockSize = 16;

  public function __construct(int $bytes = 16) {
    $this->_pwdSize = $bytes;
    $this->_dataBlockSize = self::DataBlockSize;
    $this->setPadder(new ZeroPadder(), "all");
    $this->encryptOption = OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING;
    switch ($bytes) {
      case 16:
        $this->algorithm = "AES-128-ECB";
        break;
      case 24:
        $this->algorithm = "AES-192-ECB";
        break;
      case 32:
        $this->algorithm = "AES-256-ECB";
        break;
      default:
        trigger_error(
          "AES algorithm password length must be 16/24/32 bytes.",
          E_USER_ERROR);
    }
  }
}