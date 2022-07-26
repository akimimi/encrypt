<?php
namespace Akimimi\Encrypt\Exception;

class EncryptException extends \RuntimeException {

  public function __construct($message = "unknown encrypt exception", $code = 50000, Throwable $previous = null)
  {
    parent::__construct($message, $code, $previous);
  }

  public function __toString() {
    return "[EncryptException]code: "
      . $this->getCode()." Message: ".$this->getMessage();
  }
}
