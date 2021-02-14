<?php
/**
 * @author Raphaël BLEUZET <https://github.com/raph6>
 */
namespace raph6\Enkryptor;
/**
 * Encryption tool using openssl
 *
 * @version 1.0
 */
class Enkryptor
{
    /**
     * @param string $str
     * @param string $password
     * @param string $cipher
     * 
     * @return string encrypted result in base64
     */
    public static function encrypt ($str, $password, $cipher = 'aes-256-cbc')
    {
        if (!is_null($str) && !empty($str)
            && !is_null($password) && !empty($password)
            && in_array($cipher, self::cipherList()))
        {
            $key = pack('H*', hash('sha512', $password));

            $iv_size = openssl_cipher_iv_length($cipher);
            $iv = openssl_random_pseudo_bytes($iv_size);

            $ciphertext = openssl_encrypt($str, $cipher, $key, $options=0, $iv);

            $ciphertext = $iv . $ciphertext;
            $ciphertext_base64 = base64_encode($ciphertext);
            return $ciphertext_base64;
        }

        return false;
    }

    /**
     * @param string $encrypted_str
     * @param string $password
     * @param string $cipher
     * 
     * @return string decrypted string
     */
    public static function decrypt ($encrypted_str, $password, $cipher = 'aes-256-cbc')
    {
        if (!is_null($encrypted_str) && !empty($encrypted_str)
            && !is_null($password) && !empty($password)
            && in_array($cipher, self::cipherList()))
        {
            $key = pack('H*', hash('sha512', $password));
            
            $ciphertext_dec = base64_decode($encrypted_str);

            $iv_size = openssl_cipher_iv_length($cipher);
            $iv = substr($ciphertext_dec, 0, $iv_size);

            $ciphertext = substr($ciphertext_dec, $iv_size);

            return openssl_decrypt($ciphertext, $cipher, $key, $options=0, $iv);
        }

        return false;
    }

    /**
     * 
     * @return array cipher methods
     */
    public static function cipherList ()
    {
        return openssl_get_cipher_methods();
    }

}