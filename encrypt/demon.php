<?php 

function md5(){
	$str = "hello,world";
	$raw = FALSE;
	/**
	raw 参数
	TRUE - 原始 16 字符二进制格式
	FALSE - 默认。32 字符十六进制数
	**/
	return md5($str,$raw);
}

function sha1(){
	$str = "hello,world";
	$raw = FALSE;
	/**
	raw 参数
	TRUE - 原始 20 字符二进制格式
	FALSE - 默认。40 字符十六进制数
	**/
	return sha1($str,$raw);
}

function sha256(){
	$content = "加密内容";
	$key = "6BB64B04849715D0AB2D57662AE1BC42";
	return hash_hmac("sha256",$content,$key);
}

function base64($encode=true){
	$str = "hello,world";
	if($encode){
		return base64_encode($str);
	}else{
		return base64_decode(base64_encode($str));
	}
}

function aes($encode=true){
	$key = "ajsjakoporqwncxncmxhjdhsfdfs";
	$key = substr(sha1($key, true), 0, 16);
	$iv = openssl_random_pseudo_bytes(16);
		
	if($encode){
		$plaintext = "hello,world";
		$ciphertext = openssl_encrypt($plaintext, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv);
		return $ciphertext;
	}else{
		$ciphertext = aes(true);
		$plaintext = openssl_decrypt($ciphertext, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv);
		return $plaintext;
	}
}

//$pwd密钥 $data需加密字符串
function rc4 ($pwd, $data)
{
    $key[] ="";
    $box[] ="";
    
    $pwd_length = strlen($pwd);
    $data_length = strlen($data);
    
    for ($i = 0; $i < 256; $i++)
    {
        $key[$i] = ord($pwd[$i % $pwd_length]);
        $box[$i] = $i;
    }
    
    for ($j = $i = 0; $i < 256; $i++)
    {
        $j = ($j + $box[$i] + $key[$i]) % 256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }
    
    for ($a = $j = $i = 0; $i < $data_length; $i++)
    {
        $a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;
    
        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
    
        $k = $box[(($box[$a] + $box[$j]) % 256)];
        $cipher .= chr(ord($data[$i]) ^ $k);
    }
     
    return $cipher;
}

function testRc4(){
	$key = '原始秘钥';
	$pwd = md5(md5($key).'我是常量'); 
	$data = '加密数据';            
	$cipher = rc4($pwd, $data);//AC4 加密算法
	$c = rc4($pwd, $cipher); //AC4 加密算法还原 (还原只需要重新加密一次)
}


function rsa(){
/**
	密钥采用openssl工具生成，命令：

1. 生成 rsa 私钥
openssl genrsa -out rsaprivatekey.pem 1024
2. 生成对应的公钥
openssl rsa -in rsaprivatekey.pem -pubout -out rsapublickey.pem
3. 将 RSA 私钥转换成 PKCS8 格式,
openssl pkcs8 -topk8 -inform PEM -in rsaprivatekey.pem -outform PEM -nocrypt -out
rsaprivatepkcs8.pem
*/

$private_key = '-----BEGIN RSA PRIVATE KEY-----
MIICXQIBAAKBgQDpoODVtnSztGyb//p+g/Ob36jb3jzWzS2qovOjpY/rrTjwlVcQ
pB2m1nZDQNpTFsG8ZBl7uPw3M81lr7NRRn6tY7Om8tbOOsRgY6u0xwbgdRStFFvw
PzZ1HehiQ6WB8za8cucCyvuqmBRp7HOjO4Aa9t0rIvZ/hoWMeSvjnAVbMwIDAQAB
AoGBAOEHsaiIDs6NKdP08r1rsXjhLI9i92zawnLKdCybKw4RknfBENSZj2oExnKv
A9vmXoNsU1NlcaJmRh/85ZaSdS4L+Zx8iz18uwXAjCPpfMd7nG4FD55713Lszhua
DQIxK06w2mI0ytwEf4cqQmct2/BWchBXZIlz9O0Q70CF2brpAkEA/3NtHrQNxbF0
KRvrrTw4c9Y76PyeESEmKuF8ZKQu6v1qSb/V3aZsiGPTH+vUf0oAmoJoGx1AtRuk
DAe9uQ5efQJBAOohcXTh7vgm5ujlyJEi85jGp2BnHxmNAHN6n1q44Hs1wbvICujH
SEaHhVt6hSf7/NXnGOtJXve0JIt5glvCX28CQCa1jASKDkg10r9j/ruak4diIGP2
29EGr+zxjFMH2iA71H5mdncHAA1O6zA8IVBEm4DOYA4zyZloHdzA04wWVFUCQQDY
9+cJVvq6smpYN+E3RrmRwb6IYuf6KKXbXi5gx2UYKQgA+e/KKis7WQlnbdIJ7MYw
f7mjCVpdmG4pZpA8cpM3AkAFRUXYKlxLusKBRDZSDCyCUzP/Y3ql/qWXOqcA5Brj
pj+cofEWd/jZqD3drFjDGvccFmTfEAVmXWxCnJAZU2cW
-----END RSA PRIVATE KEY-----';

$public_key = '-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDpoODVtnSztGyb//p+g/Ob36jb
3jzWzS2qovOjpY/rrTjwlVcQpB2m1nZDQNpTFsG8ZBl7uPw3M81lr7NRRn6tY7Om
8tbOOsRgY6u0xwbgdRStFFvwPzZ1HehiQ6WB8za8cucCyvuqmBRp7HOjO4Aa9t0r
IvZ/hoWMeSvjnAVbMwIDAQAB
-----END PUBLIC KEY-----';

//echo $private_key;
$pi_key =  openssl_pkey_get_private($private_key);//这个函数可用来判断私钥是否是可用的，可用返回资源id Resource id
$pu_key = openssl_pkey_get_public($public_key);//这个函数可用来判断公钥是否是可用的


$data = "原始数据";
$encrypted = "";
$decrypted = "";

openssl_private_encrypt($data,$encrypted,$pi_key);//私钥加密
$encrypted = base64_encode($encrypted);//加密后的内容通常含有特殊字符，需要编码转换下，在网络间通过url传输时要注意base64编码是否是url安全的

openssl_public_decrypt(base64_decode($encrypted),$decrypted,$pu_key);//私钥加密的内容通过公钥可以解密出来

openssl_public_encrypt($data,$encrypted,$pu_key);//公钥加密
$encrypted = base64_encode($encrypted);

openssl_private_decrypt(base64_decode($encrypted),$decrypted,$pi_key);//私钥解密
}