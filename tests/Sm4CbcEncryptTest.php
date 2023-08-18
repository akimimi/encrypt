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
    $encrypt->setPassword("akimimi");
    $encrypt->setIv("abcdefg");
    $data = $encrypt->encrypt("akimimi");
    $this->assertEquals("b760d26fea4fe7d601aa2b1093a2e6e0", $data); // akimimi
  }

  public function testDecrypt(): void {
    $encrypt = new Sm4CbcEncrypt();
    $encrypt->setBytesEncoder(new HexEncoder());
    $encrypt->setPassword("akimimi");
    $encrypt->setIv("abcdefg");
    $data = $encrypt->decrypt("b760d26fea4fe7d601aa2b1093a2e6e0");
    $this->assertEquals("akimimi", $data);
  }

  public function testEncryptLongText(): void {
    $encrypt = new Sm4CbcEncrypt();
    $encrypt->setBytesEncoder(new HexEncoder());
    $encrypt->setPassword("123456");
    $encrypt->setIv("abcdefg");
    $data = $encrypt->encrypt("akimimi is a bigdata leading company in auto aftermarket");
    $this->assertEquals("607434a1ed7ce89d3fbb9a03954dfa06479501c3192f24c16861f4c71c85ff766b2e334dce63373f2614c30c2c57f4c65a514a89f2564b80489611c575b489b7", $data);
  }

  public function testDecryptLongText(): void {
    $encrypt = new Sm4CbcEncrypt();
    $encrypt->setBytesEncoder(new HexEncoder());
    $encrypt->setPassword("123456");
    $encrypt->setIv("abcdefg");
    $data = $encrypt->decrypt("607434a1ed7ce89d3fbb9a03954dfa06479501c3192f24c16861f4c71c85ff766b2e334dce63373f2614c30c2c57f4c65a514a89f2564b80489611c575b489b7");
    $this->assertEquals("akimimi is a bigdata leading company in auto aftermarket", $data);
  }

  public function testEncryptGb2312(): void {
    $encrypt = new Sm4CbcEncrypt();
    $encrypt->setBytesEncoder(new HexEncoder());
    $encrypt->setPassword("akimimi");
    $encrypt->setIv("abcdefg");
    $data = mb_convert_encoding("修理厂店面名称", "gb2312", "utf-8");
    $data = $encrypt->encrypt($data);
    $this->assertEquals("58c39b7cfee653fa6d2ec5dfa436548e", $data);
  }

  public function testDecryptGb2312(): void {
    $encrypt = new Sm4CbcEncrypt();
    $encrypt->setBytesEncoder(new HexEncoder());
    $encrypt->setPassword("akimimi");
    $encrypt->setIv("abcdefg");
    $data = $encrypt->decrypt("58c39b7cfee653fa6d2ec5dfa436548e");
    $data = mb_convert_encoding($data, "utf-8", "gb2312");
    $this->assertEquals("修理厂店面名称", $data);
  }
}
