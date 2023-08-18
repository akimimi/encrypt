<?php
namespace Akimimi\Encrypt;

interface Padder {

  function pad(string $data, int $blockSize) :string;

  function trim(string $data, int $blockSize) :string;

}
