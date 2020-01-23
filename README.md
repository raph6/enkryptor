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

### Changing cipher method
By default cipher is AES 256 CBC, you can change this by adding a 3rd parameters, for exemple :
```php
$encrypted = Enkryptor::encrypt('test', 'password', 'des-ede3-cfb1');
var_dump($encrypted);

$decrypted = Enkryptor::decrypt($encrypted, 'password', 'des-ede3-cfb1');
var_dump($decrypted);
```
You can get available cipher methods by using
```php
var_dump(openssl_get_cipher_methods());
```
