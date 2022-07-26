<?php
namespace Akimimi\Encrypt;

interface Encoder {

  function encode(string $data) :string;

  function decode(string $data) :string;

}
