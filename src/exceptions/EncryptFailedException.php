<?php
namespace Akimimi\Encrypt\Exception;

class EncryptFailedException extends EncryptException {

  public function __construct($message = "encrypt failed", $code = 50001, Throwable $previous = null) {
    parent::__construct($message, $code, $previous);
  }
}
