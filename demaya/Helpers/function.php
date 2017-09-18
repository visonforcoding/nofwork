<?php


/**
 * 字符串变成大驼峰
 * @param string $str	待处理字符串
 * @return string 结果字符串
 */
function toBigHump($str)
{
	$str = strtolower($str);
	$arr = preg_split('/_|-/', $str);
	foreach ($arr as &$value) {
		$value = ucfirst($value);
	}
	return implode('', $arr);
}

/**
 * 字符串变成小驼峰
 * @param string $str	待处理字符串
 * @return string		结果字符串
 */
function toLittleHump($str)
{
	$str = strtolower($str);
	$arr = preg_split('/_|-/', $str);
	$isFirst = true;
	foreach ($arr as &$value) {
		if ($isFirst) {
			$isFirst = false;
			$value = lcfirst($value);
		} else {
			$value = ucfirst($value);
		}
	}
	return implode('', $arr);
}
