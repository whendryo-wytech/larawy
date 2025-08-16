<?php

namespace App\Support\Crypt;

class Crypt
{

    private string $key;
    private string $iv;
    private mixed $method;

    public function __construct()
    {
        $this->prepare();
    }
    
    private function prepare(): void
    {
        $this->key = hash(env('CRYPT_HASH'), env('CRYPT_KEY'));
        $this->iv = substr(hash(env('CRYPT_HASH'), env('CRYPT_IV')), 0, 16);
        $this->method = env('CRYPT_METHOD');
    }

    public function crypt(string $value): string
    {
        return base64_encode(openssl_encrypt($value, $this->method, $this->key, 0, $this->iv));
    }

    public function decrypt(string $value): string
    {
        return openssl_decrypt(base64_decode($value), $this->method, $this->key, 0, $this->iv);
    }

    public function cryptToUUIDv4(string $value): string
    {
        $value = $this->crypt($value);
        $hex = bin2hex($value);

        return sprintf(
            '%08s-%04s-4%03s-%04x-%012s',
            substr($hex, 0, 8),
            substr($hex, 8, 4),
            substr($hex, 12, 3),
            (hexdec(substr($hex, 15, 4)) & 0x3fff) | 0x8000,
            substr($hex, 19, 12)
        );
    }

}
