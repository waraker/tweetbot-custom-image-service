<?php

class pseudo_crypt{

	private static $prime = 8531381;
	private static $chars = array(48,49,50,51,52,53,54,55,56,57,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,97,98,99,100,101,102,103,104,105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122);

	private static function base($int){
		$key = "";
		while(bccomp($int, 0) > 0){
			$mod = bcmod($int, 62);
			$key .= chr(self::$chars[$mod]);
			$int = bcdiv($int, 62);
		}
		return strrev($key);
	}
	public static function hash($num){
		$ceil = bcpow(62, 4);
		$dec = bcmod(bcmul($num, self::$prime), $ceil);
		$hash = self::base($dec);
		return str_pad($hash, 4, "0", STR_PAD_LEFT);
	}
}

?>