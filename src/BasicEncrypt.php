<?php
namespace Akimimi\Encrypt;

use Akimimi\Encrypt\Exception\DecryptFailedException;
use Akimimi\Encrypt\Exception\EncryptFailedException;

class BasicEncrypt {
  /**
   * @var string
   */
  public string $algorithm = "";

  /**
   * @var int
   */
  public int $encryptOption = 0;

  /**
   * @var string
   */
  protected string $_key = "";

  /**
   * @var Encoder|null
   */
  protected ?Encoder $_bytesEncoder = null;

  /**
   * @var string
   */
  protected string $_rawData = "";

  /**
   * @var string
   */
  protected string $_encodedData = "";

  /**
   * @var string
   */
  protected string $_encryptData = "";

  /**
   * @var string
   */
  protected string $_decryptData = "";

  /**
   * @var string
   */
  protected string $_decodedData = "";

  /**
   * Set an encoder for encrypt utility.
   * In encrypt function, encrypted data is encoded by encoder and then returned to user.
   * In decrypt function, decrypted data is decoded by encoder firstly, and decrypt the decoded data.
   * @param Encoder $encoder
   * @return void
   */
  public function setBytesEncoder(Encoder $encoder) :void {
    $this->_bytesEncoder = $encoder;
  }

  /**
   * Set password for encrypt utility.
   * @param string $password
   * @return void
   */
  public function setPassword(string $password) :void {
    $this->_key = $password;
  }

  /**
   * Execute encrypt with openssl_encrypt function.
   * Encrypted data will be returned if encrypt succeeds.
   * If some error happens in encrypt stage, EncryptFailedException is thrown.
   * @param string $data Plain data
   * @return string Encrypted data
   * @throws EncryptFailedException
   */
  public function encrypt(string $data) :string {
    $this->_rawData = $data;
    if (!empty($this->algorithm)) {
      $data = openssl_encrypt(
        $data, $this->algorithm, $this->_key, $this->encryptOption);
    } else {
      $data = false;
    }
    $this->_encryptData = $data;

    if ($data === false) {
      throw new EncryptFailedException();
    }

    if ($this->_bytesEncoder != null) {
      $data = $this->_bytesEncoder->encode($data);
    }
    $this->_encodedData = $data;
    return $data;
  }

  /**
   * Execute decrypt with openssl_decrypt function.
   * Plain data will be returned if decrypt succeeds.
   * If some error happens in decrypt stage, DecryptFailedException is thrown.
   * @param string $data Encrypted data
   * @return string Plain data
   * @throws DecryptFailedException
   */
  public function decrypt(string $data) :string {
    $this->_rawData = $data;
    if ($this->_bytesEncoder != null) {
      $data = $this->_bytesEncoder->decode($data);
    }
    $this->_decodedData = $data;
    if (!empty($this->algorithm)) {
      $data = openssl_decrypt(
        $data, $this->algorithm, $this->_key, $this->encryptOption);
    } else {
      $data = false;
    }
    $this->_decryptData = $data;
    if ($data === false) {
      throw new DecryptFailedException();
    }
    return $data;
  }

}
