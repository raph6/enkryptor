# Enkryptor
composer package for encryption using openssl


### Installation
```shell
composer require raph6/enkryptor
```


### How to use
```php
use raph6\Enkryptor\Enkryptor;

# encryption
$encrypted = Enkryptor::encrypt('string to encrypt', 'password');
var_dump($encrypted);

# decryption
$decrypted = Enkryptor::decrypt($encrypted, 'password');
var_dump($decrypted);
```
