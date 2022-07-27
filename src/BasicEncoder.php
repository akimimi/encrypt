<?php
namespace Akimimi\Encrypt;

class BasicEncoder {

  public $params = [];

  /**
   * Set parameter for encoder utility.
   * @param string $key
   * @param $value
   * @return void
   */
  public function setParams(string $key, $value) :void {
    $this->params[$key] = $value;
  }

}
