<?php
use PHPUnit\Framework\TestCase;
use Akimimi\Encrypt\Base64Encoder;

class Base64EncoderTest extends TestCase {

  public function setUp(): void {
    parent::setUp();
  }

  public function testEncode() {
    $encoder = new Base64Encoder();
    $str = "akimimi";
    $this->assertEquals("YWtpbWltaQ==", $encoder->encode($str));

    $str = "米米科技";
    $this->assertEquals("57Gz57Gz56eR5oqA", $encoder->encode($str));

    $str = mb_convert_encoding($str, "gb2312", "utf8");
    $this->assertEquals("w9fD17/GvLw=", $encoder->encode($str));
  }

  public function testDecode() {
    $encoder = new Base64Encoder();
    $str = "YWtpbWltaQ==";
    $this->assertEquals("akimimi", $encoder->decode($str));

    $str = "57Gz57Gz56eR5oqA";
    $this->assertEquals("米米科技", $encoder->decode($str));

    $str = "w9fD17/GvLw=";
    $decoded = $encoder->decode($str);
    $decoded = mb_convert_encoding($decoded, "utf8", "gb2312");
    $this->assertEquals("米米科技", $decoded);
  }

  public function testDecodeInStrictMode() {
    $encoder = new Base64Encoder();
    $encoder->setParams('strict', true);
    $str = "YWtpbWltaQ==";
    $this->assertEquals("akimimi", $encoder->decode($str));

    $str = "57Gz57Gz56eR5oqA";
    $this->assertEquals("米米科技", $encoder->decode($str));

    $str = "w9fD17/GvLw=";
    $decoded = $encoder->decode($str);
    $decoded = mb_convert_encoding($decoded, "utf8", "gb2312");
    $this->assertEquals("米米科技", $decoded);
  }
}

