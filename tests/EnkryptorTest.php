<?php

namespace raph6\Enkryptor;

use PHPUnit\Framework\TestCase;

class EnkryptorTest extends TestCase {

    public function testCanBeDecrypted()
    {
        $encrypted = 'KhB5bxPJ2sQ7kSlBMAV7w0dtUVkyUklLU1FHdXY5eTNiNnlicHc9PQ==';
        $password = 'test decrypt';
        $str = 'test';
        $this->assertEquals(
            $str,
            Enkryptor::decrypt($encrypted, $password)
        );
    }

    public function testEncryptDecrypt()
    {

        $str = 'test unitaire 2';
        $password = '77&$#@&';
        $encrypted = Enkryptor::encrypt($str, $password);
        $this->assertEquals(
            $str,
            Enkryptor::decrypt($encrypted, $password)
        );

        $cipher = 'des-ede3-cfb1';
        $encryptedcipher = Enkryptor::encrypt($str, $password, $cipher);
        $this->assertEquals(
            $str,
            Enkryptor::decrypt($encryptedcipher, $password, $cipher)
        );
    }

    public function testCannotBeDecrypted() {
        $encrypted = 'c2+foLFa9OGfOjjsJ/n8m0NmcjJ6MWYzVzgyeENBcDRZSFY0NGc9PQ==';
        $password = 'haha';
        $this->assertFalse(Enkryptor::decrypt(null, $password));
        $this->assertFalse(Enkryptor::decrypt('', $password));
        $this->assertFalse(Enkryptor::decrypt($encrypted, null));
        $this->assertFalse(Enkryptor::decrypt($encrypted, ''));
        $this->assertFalse(Enkryptor::decrypt($encrypted, $password, 'bad cipher'));
        $this->assertFalse(Enkryptor::decrypt($encrypted, 'fake password'));
    }

    public function testCannotBeEncrypted() {
        $str = 'hello world';
        $password = 'dlrow olleh';
        $this->assertFalse(Enkryptor::encrypt(null, $password));
        $this->assertFalse(Enkryptor::encrypt('', $password));
        $this->assertFalse(Enkryptor::encrypt($str, null));
        $this->assertFalse(Enkryptor::encrypt($str, ''));
        $this->assertFalse(Enkryptor::encrypt($str, $password, 'bad cipher'));
    }
}