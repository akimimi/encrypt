<?php
namespace Akimimi\Encrypt;

/**
 * AesEcbEncrypt provides AES ECB encrypt and decrypt algorithms.
 * Password length must be 16/24/32 bytes. Zero padding is set by default.
 */
class AesEcbEncrypt extends BasicEncrypt {

  /**
   * @var int
   */
  private int $_pwdSize = 16;

  /**
   * @var string
   */
  protected string $_preprocessData = "";

  const DataBlockSize = 16;

  public function __construct(int $bytes = 16) {
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
    $this->_pwdSize = $bytes;
    $this->encryptOption = OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING;
  }

  public function setPassword(string $password) :void {
    $password = Util::PaddingZero($password, $this->_pwdSize);
    parent::setPassword($password);
  }

  /**
   * Encrypt data with AES-ECB algorithm.
   * @param string $data
   * @return string
   */
  public function encrypt(string $data): string {
    $data = Util::PaddingZero($data, self::DataBlockSize);
    $this->_preprocessData = $data;
    return parent::encrypt($data);
  }

  /**
   * Decrypt data with AES-ECB algorithm.
   * @param string $data
   * @return string
   */
  public function decrypt(string $data): string {
    $data = parent::decrypt($data);
    return Util::RtrimZero($data);
  }
}