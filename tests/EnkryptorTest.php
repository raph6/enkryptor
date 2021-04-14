<?php

namespace raph6\Enkryptor;

use PHPUnit\Framework\TestCase;

class EnkryptorTest extends TestCase {

    private $_str = 'foo';
    private $_password = 'bar';
    private $_defaultEncrypted = 'oYhrZJRMLU1s28EQvChbAlFaeGNhd1VjSHVkcGF0ZERTQ201TXc9PQ==';
    private $_ciphersAndEncrypted = [
        'chacha20-poly1305' => 'xMGUVId4M0M3kHaIQXNxNg==',
        'bf-cbc' => '5h1Rm8w+5vQ1NStiRi9HUzgrYz0=',
        'seed-cbc' => 'BfBRX49ZH9asPxDsxLqRXFdIM1ViSS9sa2IrR0RtN2hObmJRWkE9PQ==',
        'des-ede3-cfb1' => 'DF+HcRPTHn9XYUc3'
    ];

    public function testCanBeDecrypted()
    {
        $this->assertEquals(
            $this->_str,
            Enkryptor::decrypt($this->_defaultEncrypted, $this->_password)
        );

        foreach ($this->_ciphersAndEncrypted as $cipher => $encryptedString) {
            $this->assertEquals(
                $this->_str,
                Enkryptor::decrypt($encryptedString, $this->_password, $cipher)
            );
        }
    }

    public function testCanBeEncrypted()
    {
        $this->assertIsString(Enkryptor::encrypt($this->_str, $this->_password));

        foreach ($this->_ciphersAndEncrypted as $cipher => $encryptedString) {
            $this->assertIsString(Enkryptor::encrypt($this->_str, $this->_password, $cipher));
        }
    }

    public function testEncryptDecrypt()
    {
        $encrypted = Enkryptor::encrypt($this->_str, $this->_password);
        $this->assertEquals(
            $this->_str,
            Enkryptor::decrypt($encrypted, $this->_password)
        );

        foreach ($this->_ciphersAndEncrypted as $cipher => $encryptedString) {
            $encryptedWithCipher = Enkryptor::encrypt($this->_str, $this->_password, $cipher);
            $this->assertEquals(
                $this->_str,
                Enkryptor::decrypt($encryptedWithCipher, $this->_password, $cipher)
            );
        }
    }

    public function testCannotBeDecrypted() {
        $encrypted = 'RIbkxq90BhULlZavRmVa73lSWC9SNVpHN0d6R1Z5cFAvWm9IVFJraEpKQmhMTnRkSFZRU0JXOG9EQ2c9';
        $password = 'haha';
        $this->assertFalse(Enkryptor::decrypt(null, $password));
        $this->assertFalse(Enkryptor::decrypt($encrypted, null));
        $this->assertFalse(Enkryptor::decrypt($encrypted, $password, 'bad cipher'));
        $this->assertFalse(Enkryptor::decrypt($encrypted, 'fake password'));
    }

    public function testCannotBeEncrypted() {
        $str = 'hello world';
        $password = 'dlrow olleh';
        $this->assertFalse(Enkryptor::encrypt(null, $password));
        $this->assertFalse(Enkryptor::encrypt($str, null));
        $this->assertFalse(Enkryptor::encrypt($str, $password, 'bad cipher'));
    }
}