<?php
/**
 * 字符串加密
 * @author xinxin@jpush.cn
 *
 */
class SecretEncode
{
	/**
	 * MD5加密
	 * @param String $encodeStr
	 */
	public function getMD5Encode($encodeStr)
	{
		return md5($encodeStr);
	}
	
	/**
	 * Base64 加密
	 * @param unknown $encodeStr
	 */	
	public function getBase64Encode($encodeStr)
	{
		return rtrim(strtr(base64_encode($encodeStr), '+/', '-_'), '=');
	}
}