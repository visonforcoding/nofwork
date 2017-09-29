<?php

namespace dmy\Utility;

class Hash
{

	
	/**
	 * 
	 * @param array $data
	 * @param type $var
	 * @return type
	 */
	public static function get($data, $var)
	{
		if (strpos($var, '.') === false) {
			if (!isset($data[$var])) {
				return null;
			}
			$value = $data[$var];
			unset($data[$var]);

			return $value;
		}
		$key_arr = explode('.', $var);
		foreach ($key_arr as $k) {
			if (!array_key_exists($k, $data)) {
				return null;
			}
			$data = $data[$k];
		}
		return $data;
	}

}
