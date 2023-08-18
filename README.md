Akimimi\Encrypt
================================================================

[![Build Status](https://app.travis-ci.com/akimimi/encrypt.svg?branch=main)](https://app.travis-ci.com/akimimi/encrypt)

## Description

This library provides encrypt and decrypt algorithm utilities.

`AesEcbEncrypt` class provides 128/192/256 bits AES ECB encrypt and decrypt algorithm, 
with zero padding by default.

`AesCbcEncrypt` class provides 128/192/256 bits AES CBC encrypt and decrypt algorithm,
with zero padding by default.

`Sm4CbcEncrypt` class provides 128 bits SM4 CBC encrypt and decrypt algorithm,
with PKCS5 padding for data by default, and zero padding for password.

## Installation

This library support Add require with composer CLI.
```bash
composer require akimimi/encrypt
```
Otherwise, add require to your `composer.json`.
```json
{
  "require": {
     "akimimi/encrypt": ">=1.0.0"
  }
}
```

Use Composer to install requires
```bash
composer install
```

## Usage

After installation by composer, you can declare use for class.
```php
<?php
use Akimimi\Encrypt\AesEcbEncrypt;

$password = "123456";
$data = "akimimi";

$encryptUtil = new AesEcbEncrypt(16); // 128 bit
$encryptUtil->setPassword($password);
$encryptedStr = $encryptUtil->encrypt($data); // 0x2582ec23698d74912c044ef3e29ac86b
```

Data can be encoded and decoded in encrypt stages with an encoder set up for encrypt utility.

```php
<?php
use Akimimi\Encrypt\AesEcbEncrypt;
use Akimimi\Encrypt\Base64Encoder;

$password = "123456";
$data = "akimimi";

$encryptUtil = new AesEcbEncrypt(16); // 128 bit
$encryptUtil->setBytesEncoder(new Base64Encoder());
$encryptUtil->setPassword($password);
$encryptedStr = $encryptUtil->encrypt($data); // JYLsI2mNdJEsBE7z4prIaw==
$decryptedStr = $encryptUtil->decrypt($encryptedStr); // akimimi
```

## Uninstall

With composer, we can remove library with composer CLI.
```bash
composer remove akimimi/encrypt
```
