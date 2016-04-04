<?php

class CryptoUrl
{

	public function __construct(){
		if(!extension_loaded('mcrypt')){
			throw New Exception('extension mcrypt not found. http://php.net/manual/es/mcrypt.installation.php');
		}
	}

	private function _getMcryptListModes(){
		return mcrypt_list_modes();//array
	}

	private function _getMcryptListAlgorithms(){
		return mcrypt_list_algorithms();//array
	}

	private function _checkDefaultsEncrypt( $vectorStr, $keyStr, $dataArr ){
		var_dump($vectorStr, $keyStr, $dataArr);
		if( !is_string($vectorStr) || !is_string($keyStr) || !is_array($dataArr) ){
			throw new Exception('please, set the $vector, $key and $dataArr values (strings)');
		}

	}


    public function encrypt( $vectorStr, $keyStr,  $dataArr)
	{
		$this->_checkDefaultsEncrypt($vectorStr, $keyStr, $dataArr);
        $obj = new stdClass();
        foreach ($dataArr as $key => $value) {
            $obj->$key = $value;
        }

        $objSerialized = serialize($obj);
        $encrypt = new Encrypt(
            array(
                'vector' => $vectorStr,
                'key' => $keyStr
            )
        );

        $objEncrypted = $encrypt->filter($objSerialized);
        $string = $this->_urlsafe_b64encode($objEncrypted);

        return $string;
    }


    public function decrypt($string)
    {
        $encrypt = new Decrypt(
            array(
                'vector' => $this->vector,
                'key' => $this->key
            )
        );
        $objEncrypted = $this->_urlsafe_b64decode($string);

        if (!empty($objEncrypted)) {
            $objSerialized = $encrypt->filter($objEncrypted);
            $obj = unserialize($objSerialized);
        }

        if(is_object($obj)){
           $arr = get_object_vars($obj); // object to array
        }

        return $arr;
    }



    private function _urlsafe_b64encode($string)
    {
        $data = base64_encode($string);
        $data = str_replace(array('+', '/', '='), array('-', '_', '.'), $data);
        return $data;
    }


    private function _urlsafe_b64decode($string)
    {
        $data = str_replace(array('-', '_', '.'), array('+', '/', '='), $string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }



}

