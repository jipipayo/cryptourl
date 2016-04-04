<?php
require_once(__DIR__ . '/../lib/CryptoUrl.php');



class CryptoUrlTest extends PHPUnit_Framework_TestCase
{
    public function testFoo(){

        $cryptourl = New CryptoUrl();
        $dataArr = [];
        $encrypt = $cryptourl->encrypt( $vector = 'fadfwe25', $key= 'fae2320Vjg9j0fscno_fwgj09g3j02', $dataArr );
        var_dump($encrypt);

    }
}
