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

/**
 * Gets an environment variable from available sources, and provides emulation
 * for unsupported or inconsistent environment variables (i.e. DOCUMENT_ROOT on
 * IIS, or SCRIPT_NAME in CGI mode). Also exposes some additional custom
 * environment information.
 *
 * @param string $key Environment variable name.
 * @param string|null $default Specify a default value in case the environment variable is not defined.
 * @return string|null Environment variable setting.
 * @link http://book.cakephp.org/3.0/en/core-libraries/global-constants-and-functions.html#env
 */
function env($key, $default = null)
{
	if ($key === 'HTTPS') {
		if (isset($_SERVER['HTTPS'])) {
			return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
		}

		return (strpos(env('SCRIPT_URI'), 'https://') === 0);
	}

	if ($key === 'SCRIPT_NAME') {
		if (env('CGI_MODE') && isset($_ENV['SCRIPT_URL'])) {
			$key = 'SCRIPT_URL';
		}
	}

	$val = null;
	if (isset($_SERVER[$key])) {
		$val = $_SERVER[$key];
	} elseif (isset($_ENV[$key])) {
		$val = $_ENV[$key];
	} elseif (getenv($key) !== false) {
		$val = getenv($key);
	}

	if ($key === 'REMOTE_ADDR' && $val === env('SERVER_ADDR')) {
		$addr = env('HTTP_PC_REMOTE_ADDR');
		if ($addr !== null) {
			$val = $addr;
		}
	}

	if ($val !== null) {
		return $val;
	}

	switch ($key) {
		case 'DOCUMENT_ROOT':
			$name = env('SCRIPT_NAME');
			$filename = env('SCRIPT_FILENAME');
			$offset = 0;
			if (!strpos($name, '.php')) {
				$offset = 4;
			}

			return substr($filename, 0, -(strlen($name) + $offset));
		case 'PHP_SELF':
			return str_replace(env('DOCUMENT_ROOT'), '', env('SCRIPT_FILENAME'));
		case 'CGI_MODE':
			return (PHP_SAPI === 'cgi');
	}

	return $default;
}
