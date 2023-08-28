<?php
namespace Akimimi\Encrypt;

use Akimimi\Encrypt\Exception\DecryptFailedException;
use Akimimi\Encrypt\Exception\EncryptFailedException;

class BasicEncrypt {
  /**
   * @var string
   */
  public $algorithm = "";

  /**
   * @var int
   */
  public $encryptOption = 0;

  /**
   * @var string
   */
  protected $_key = "";

  /**
   * @var int
   */
  protected $_pwdSize = 0;

  /**
   * @var string
   */
  protected $_iv = "";

  /**
   * @var Encoder|null
   */
  protected $_bytesEncoder = null;

  /**
   * @var Padder|null
   */
  protected $_passwordPadder = null;

  /**
   * @var Padder|null
   */
  protected $_dataPadder = null;

  /**
   * @var Padder|null
   */
  protected $_ivPadder = null;

  /**
   * @var string
   */
  protected $_rawData = "";

  /**
   * @var int
   */
  protected $_dataBlockSize = 0;

  /**
   * @var string
   */
  protected $_encodedData = "";

  /**
   * @var string
   */
  protected $_encryptData = "";

  /**
   * @var string
   */
  protected $_decryptData = "";

  /**
   * @var string
   */
  protected $_decodedData = "";

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
   * Set padder for encrypt utility.
   * @param Padder $padder
   * @param string $target "password" is configured for encode password,
   *                       "data" is configured for data and initialization vector,
   *                       "all" is configured for both password and data.
   * @return void
   */
  public function setPadder(Padder $padder, string $target) :void {
    if ($target == "password") {
      $this->_passwordPadder = $padder;
    } elseif ($target == "data") {
      $this->_dataPadder = $padder;
    } elseif ($target == "iv") {
      $this->_ivPadder = $padder;
    } elseif ($target == "all") {
      $this->_dataPadder = $padder;
      $this->_ivPadder = $padder;
      $this->_passwordPadder = $padder;
    }
}

/**
   * Set password for encrypt utility.
   * @param string $password
   * @return void
   */
  public function setPassword(string $password) :void {
    if (!empty($this->_passwordPadder)) {
      $password = $this->_passwordPadder->pad($password, $this->_pwdSize);
    }
    $this->_key = $password;
  }

  /**
   * Set initialization vector for encrypt utility.
   * @param string $iv
   * @return void
   */
  public function setIv(string $iv) :void {
    if (!empty($this->_ivPadder)) {
      $iv = $this->_ivPadder->pad($iv, $this->_dataBlockSize);
    }
    $this->_iv = $iv;
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
    if (!empty($this->_dataPadder)) {
      $data = $this->_dataPadder->pad($data, $this->_dataBlockSize);
    }
    $this->_rawData = $data;
    if (!empty($this->algorithm)) {
      $data = openssl_encrypt(
        $data, $this->algorithm, $this->_key, $this->encryptOption, $this->_iv);
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
        $data, $this->algorithm, $this->_key, $this->encryptOption, $this->_iv);
    } else {
      $data = false;
    }
    $this->_decryptData = $data;
    if ($data === false) {
      throw new DecryptFailedException();
    }

    if (!empty($this->_dataPadder)) {
      $data = $this->_dataPadder->trim($data, $this->_dataBlockSize);
    }
    return $data;
  }

}
