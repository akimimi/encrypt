<?php
use PHPUnit\Framework\TestCase;
use Akimimi\Encrypt\Base64Encoder;
use Akimimi\Encrypt\AesCbcEncrypt;
use Akimimi\Encrypt\BasicEncrypt;

class AesCbcEncryptTest extends TestCase {

  public function setUp(): void {
    parent::setUp();
  }

  public function testEncrypt(): void {
    $encrypt = new AesCbcEncrypt(16);
    $encrypt->setBytesEncoder(new Base64Encoder());
    $encrypt->setPassword("123456");
    $encrypt->setIv("abcdefg");
    $data = $encrypt->encrypt("akimimi");
    $this->assertEquals("WRM0+xMBcd2zrqkjWZgZ3A==", $data);
  }

  public function testDecrypt(): void {
    $encrypt = new AesCbcEncrypt(16);
    $encrypt->setBytesEncoder(new Base64Encoder());
    $encrypt->setPassword("123456");
    $encrypt->setIv("abcdefg");
    $data = $encrypt->decrypt("WRM0+xMBcd2zrqkjWZgZ3A==");
    $this->assertEquals("akimimi", $data);
  }

  public function testEncryptLongText(): void {
    $encrypt = new AesCbcEncrypt(16);
    $encoder = new Base64Encoder();
    $encoder->setParams('strict', false);
    $encrypt->setBytesEncoder($encoder);
    $encrypt->setPassword("123456");
    $encrypt->setIv("abcdefg");
    $data = $encrypt->encrypt("akimimi is a bigdata leading company in auto aftermarket");
    $this->assertEquals("rF6I0zoSAHwiVBDxzcs6gjBQBN4Dc8agQ3u0JdlhOcjKm+ADbeot2fRcaCADTjlIMDVWphOarstcCaNqIXTNpg==", $data);
  }

  public function testDecryptLongText(): void {
    $encrypt = new AesCbcEncrypt(16);
    $encrypt->setBytesEncoder(new Base64Encoder());
    $encrypt->setPassword("123456");
    $encrypt->setIv("abcdefg");
    $data = $encrypt->decrypt("rF6I0zoSAHwiVBDxzcs6gjBQBN4Dc8agQ3u0JdlhOcjKm+ADbeot2fRcaCADTjlIMDVWphOarstcCaNqIXTNpg==");
    $this->assertEquals("akimimi is a bigdata leading company in auto aftermarket", $data);
  }

  public function testEncryptGb2312(): void {
    $encrypt = new AesCbcEncrypt(16);
    $encrypt->setBytesEncoder(new Base64Encoder());
    $encrypt->setPassword("123456");
    $encrypt->setIv("abcdefg");
    $data = mb_convert_encoding("京Q7BP06", "gb2312", "utf-8");
    $data = $encrypt->encrypt($data);
    $this->assertEquals("3aDMqhGmSrgIrKmgIwrD0A==", $data);
  }

  public function testDecryptGb2312(): void {
    $encrypt = new AesCbcEncrypt(16);
    $encrypt->setBytesEncoder(new Base64Encoder());
    $encrypt->setPassword("123456");
    $encrypt->setIv("abcdefg");
    $data = $encrypt->decrypt("3aDMqhGmSrgIrKmgIwrD0A==");
    $data = mb_convert_encoding($data, "utf-8", "gb2312");
    $this->assertEquals("京Q7BP06", $data);
  }

  public function testEncryptByte24(): void {
    $encrypt = new AesCbcEncrypt(24);
    $encrypt->setBytesEncoder(new Base64Encoder());
    $encrypt->setPassword("123456");
    $encrypt->setIv("abcdefg");
    $data = $encrypt->encrypt("akimimi");
    $this->assertEquals("2iTCeS4JzIEvUIsEfu2gFg==", $data);
  }

  public function testDecryptByte24(): void {
    $encrypt = new AesCbcEncrypt(24);
    $encrypt->setBytesEncoder(new Base64Encoder());
    $encrypt->setPassword("123456");
    $encrypt->setIv("abcdefg");
    $data = $encrypt->decrypt("2iTCeS4JzIEvUIsEfu2gFg==");
    $this->assertEquals("akimimi", $data);
  }

  public function testEncryptByte32(): void {
    $encrypt = new AesCbcEncrypt(32);
    $encrypt->setBytesEncoder(new Base64Encoder());
    $encrypt->setPassword("123456");
    $encrypt->setIv("abcdefg");
    $data = $encrypt->encrypt("akimimi");
    $this->assertEquals("gNijo3mI4xFvM/6Ig0GHjA==", $data);
  }

  public function testDecryptByte32(): void {
    $encrypt = new AesCbcEncrypt(32);
    $encrypt->setBytesEncoder(new Base64Encoder());
    $encrypt->setPassword("123456");
    $encrypt->setIv("abcdefg");
    $data = $encrypt->decrypt("gNijo3mI4xFvM/6Ig0GHjA==");
    $this->assertEquals("akimimi", $data);
  }

  public function testConstructWithError(): void {
    $this->expectError();
    new AesCbcEncrypt(18);
  }

  public function testEncryptException(): void {
    $this->expectException("\Akimimi\Encrypt\Exception\EncryptFailedException");
    $encrypt = new BasicEncrypt();
    $encrypt->setPassword("123456");
    $encrypt->setIv("abcdefg");
    $encrypt->encrypt("");
  }
}
