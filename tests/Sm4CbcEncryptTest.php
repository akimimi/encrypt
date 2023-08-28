<?php
use PHPUnit\Framework\TestCase;
use Akimimi\Encrypt\HexEncoder;
use Akimimi\Encrypt\Sm4CbcEncrypt;

class Sm4CbcEncryptTest extends TestCase {

  public function setUp(): void {
    parent::setUp();
  }

  public function testEncrypt(): void {
    $encrypt = new Sm4CbcEncrypt();
    $encrypt->setBytesEncoder(new HexEncoder());
    $encrypt->setPassword("akimimi890123456");
    $encrypt->setIv("abcdefghijklmnop");
    $data = $encrypt->encrypt("akimimi");
    $this->assertEquals("ffe940d29de9e97b04e3334f4dff88a8", $data); // akimimi
    $data = $encrypt->encrypt("akimimiisagreate");
    $this->assertEquals("9742e820e35eb0440d2f207ab71f32b83c232e19e90923abcd67fee52cb0e247", $data); // akimimi
  }

  public function testDecrypt(): void {
    $encrypt = new Sm4CbcEncrypt();
    $encrypt->setBytesEncoder(new HexEncoder());
    $encrypt->setPassword("akimimi890123456");
    $encrypt->setIv("abcdefghijklmnop");
    $data = $encrypt->decrypt("ffe940d29de9e97b04e3334f4dff88a8");
    $this->assertEquals("akimimi", $data);
    $data = $encrypt->decrypt("9742e820e35eb0440d2f207ab71f32b83c232e19e90923abcd67fee52cb0e247");
    $this->assertEquals("akimimiisagreate", $data); // akimimi
  }

  public function testEncryptLongText(): void {
    $encrypt = new Sm4CbcEncrypt();
    $encrypt->setBytesEncoder(new HexEncoder());
    $encrypt->setPassword("123456");
    $encrypt->setIv("abcdefg");
    $data = $encrypt->encrypt("akimimi is a bigdata leading company in auto aftermarket");
    $this->assertEquals("394e43ab4a07f7e05c3428c45784f1a331938a13f38bd2a322e4beab99e1aee011d9f4699b46a1402bf8e471c8d4f62c3569a3882353d871c33d7662c5f48cd4", $data);
  }

  public function testDecryptLongText(): void {
    $encrypt = new Sm4CbcEncrypt();
    $encrypt->setBytesEncoder(new HexEncoder());
    $encrypt->setPassword("123456");
    $encrypt->setIv("abcdefg");
    $data = $encrypt->decrypt("394e43ab4a07f7e05c3428c45784f1a331938a13f38bd2a322e4beab99e1aee011d9f4699b46a1402bf8e471c8d4f62c3569a3882353d871c33d7662c5f48cd4");
    $this->assertEquals("akimimi is a bigdata leading company in auto aftermarket", $data);
  }

  public function testEncryptGb2312(): void {
    $encrypt = new Sm4CbcEncrypt();
    $encrypt->setBytesEncoder(new HexEncoder());
    $encrypt->setPassword("akimimi");
    $encrypt->setIv("abcdefg");
    $data = mb_convert_encoding("修理厂店面名称", "gb2312", "utf-8");
    $data = $encrypt->encrypt($data);
    $this->assertEquals("f79e3919cf76c6a7c2f8bbf3cd1502bc", $data);
  }

  public function testDecryptGb2312(): void {
    $encrypt = new Sm4CbcEncrypt();
    $encrypt->setBytesEncoder(new HexEncoder());
    $encrypt->setPassword("akimimi");
    $encrypt->setIv("abcdefg");
    $data = $encrypt->decrypt("f79e3919cf76c6a7c2f8bbf3cd1502bc");
    $data = mb_convert_encoding($data, "utf-8", "gb2312");
    $this->assertEquals("修理厂店面名称", $data);
  }
}
