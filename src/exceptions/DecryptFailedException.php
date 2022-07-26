<?php
namespace Akimimi\Encrypt\Exception;

class DecryptFailedException extends EncryptException {

  public function __construct($message = "decrypt failed", $code = 50002, Throwable $previous = null) {
    parent::__construct($message, $code, $previous);
  }
}