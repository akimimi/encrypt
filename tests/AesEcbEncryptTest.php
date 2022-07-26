<?php
use PHPUnit\Framework\TestCase;
use Akimimi\Encrypt\Base64Encoder;
use Akimimi\Encrypt\AesEcbEncrypt;
use Akimimi\Encrypt\BasicEncrypt;

class AesEcbEncryptTest extends TestCase {

  public function setUp(): void {
    parent::setUp();
  }

  public function testEncrypt(): void {
    $encrypt = new AesEcbEncrypt(16);
    $encrypt->setBytesEncoder(new Base64Encoder());
    $encrypt->setPassword("123456");
    $data = $encrypt->encrypt("akimimi");
    $this->assertEquals("JYLsI2mNdJEsBE7z4prIaw==", $data);
  }

  public function testDecrypt(): void {
    $encrypt = new AesEcbEncrypt(16);
    $encrypt->setBytesEncoder(new Base64Encoder());
    $encrypt->setPassword("123456");
    $data = $encrypt->decrypt("JYLsI2mNdJEsBE7z4prIaw==");
    $this->assertEquals("akimimi", $data);
  }

  public function testEncryptLongText(): void {
    $encrypt = new AesEcbEncrypt(16);
    $encoder = new Base64Encoder();
    $encoder->setParams('strict', false);
    $encrypt->setBytesEncoder($encoder);
    $encrypt->setPassword("123456");
    $data = $encrypt->encrypt("akimimi is a bigdata leading company in auto aftermarket");
    $this->assertEquals("H8ZxVU0R4DUHotvf7sjvjVPrA3yVdt8COE56v0AzRisBtwIH/LgZdNsRiKhi/kq9kK9Lh4+cN3Qjt8O1sNLHCw==", $data);
  }

  public function testDecryptLongText(): void {
    $encrypt = new AesEcbEncrypt(16);
    $encrypt->setBytesEncoder(new Base64Encoder());
    $encrypt->setPassword("123456");
    $data = $encrypt->decrypt("H8ZxVU0R4DUHotvf7sjvjVPrA3yVdt8COE56v0AzRisBtwIH/LgZdNsRiKhi/kq9kK9Lh4+cN3Qjt8O1sNLHCw==");
    $this->assertEquals("akimimi is a bigdata leading company in auto aftermarket", $data);
  }

  public function testEncryptGb2312(): void {
    $encrypt = new AesEcbEncrypt(16);
    $encrypt->setBytesEncoder(new Base64Encoder());
    $encrypt->setPassword("123456");
    $data = mb_convert_encoding("京Q7BP06", "gb2312", "utf-8");
    $data = $encrypt->encrypt($data);
    $this->assertEquals("hTHqXyZZGKY22tBoyiSSlg==", $data);
  }

  public function testDecryptGb2312(): void {
    $encrypt = new AesEcbEncrypt(16);
    $encrypt->setBytesEncoder(new Base64Encoder());
    $encrypt->setPassword("123456");
    $data = $encrypt->decrypt("hTHqXyZZGKY22tBoyiSSlg==");
    $data = mb_convert_encoding($data, "utf-8", "gb2312");
    $this->assertEquals("京Q7BP06", $data);
  }

  public function testEncryptByte24(): void {
    $encrypt = new AesEcbEncrypt(24);
    $encrypt->setBytesEncoder(new Base64Encoder());
    $encrypt->setPassword("123456");
    $data = $encrypt->encrypt("akimimi");
    $this->assertEquals("1eAOZD+eiZjnumI5FvZnNg==", $data);
  }

  public function testDecryptByte24(): void {
    $encrypt = new AesEcbEncrypt(24);
    $encrypt->setBytesEncoder(new Base64Encoder());
    $encrypt->setPassword("123456");
    $data = $encrypt->decrypt("1eAOZD+eiZjnumI5FvZnNg==");
    $this->assertEquals("akimimi", $data);
  }

  public function testEncryptByte32(): void {
    $encrypt = new AesEcbEncrypt(32);
    $encrypt->setBytesEncoder(new Base64Encoder());
    $encrypt->setPassword("123456");
    $data = $encrypt->encrypt("akimimi");
    $this->assertEquals("7JuUXNbpnx0yFUl+6I7LeA==", $data);
  }

  public function testDecryptByte32(): void {
    $encrypt = new AesEcbEncrypt(32);
    $encrypt->setBytesEncoder(new Base64Encoder());
    $encrypt->setPassword("123456");
    $data = $encrypt->decrypt("7JuUXNbpnx0yFUl+6I7LeA==");
    $this->assertEquals("akimimi", $data);
  }

  public function testConstructWithError(): void {
    $this->expectError();
    new AesEcbEncrypt(18);
  }

  public function testEncryptException(): void {
    $this->expectException("\Akimimi\Encrypt\Exception\EncryptFailedException");
    $encrypt = new BasicEncrypt();
    $encrypt->setPassword("123456");
    $encrypt->encrypt("");
  }

  public function testDecryptException(): void {
    $this->expectException("\Akimimi\Encrypt\Exception\DecryptFailedException");
    $encrypt = new BasicEncrypt();
    $encrypt->setPassword("123456");
    $encrypt->decrypt("");
  }

  public function testDecryptExceptionString(): void {
    try {
      $encrypt = new BasicEncrypt();
      $encrypt->setPassword("123456");
      $encrypt->decrypt("");
    } catch (Exception $e) {
      $this->assertEquals("[EncryptException]code: 50002 Message: decrypt failed", strval($e));
    }
  }
}
