<?php 

function md5(){
	$str = "hello,world";
	$raw = FALSE;
	/**
	raw ����
	TRUE - ԭʼ 16 �ַ������Ƹ�ʽ
	FALSE - Ĭ�ϡ�32 �ַ�ʮ��������
	**/
	return md5($str,$raw);
}

function sha1(){
	$str = "hello,world";
	$raw = FALSE;
	/**
	raw ����
	TRUE - ԭʼ 20 �ַ������Ƹ�ʽ
	FALSE - Ĭ�ϡ�40 �ַ�ʮ��������
	**/
	return sha1($str,$raw);
}

function sha256(){
	$content = "��������";
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

//$pwd��Կ $data������ַ���
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
	$key = 'ԭʼ��Կ';
	$pwd = md5(md5($key).'���ǳ���'); 
	$data = '��������';            
	$cipher = rc4($pwd, $data);//AC4 �����㷨
	$c = rc4($pwd, $cipher); //AC4 �����㷨��ԭ (��ԭֻ��Ҫ���¼���һ��)
}


function rsa(){
/**
	��Կ����openssl�������ɣ����

1. ���� rsa ˽Կ
openssl genrsa -out rsaprivatekey.pem 1024
2. ���ɶ�Ӧ�Ĺ�Կ
openssl rsa -in rsaprivatekey.pem -pubout -out rsapublickey.pem
3. �� RSA ˽Կת���� PKCS8 ��ʽ,
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
$pi_key =  openssl_pkey_get_private($private_key);//��������������ж�˽Կ�Ƿ��ǿ��õģ����÷�����Դid Resource id
$pu_key = openssl_pkey_get_public($public_key);//��������������жϹ�Կ�Ƿ��ǿ��õ�


$data = "ԭʼ����";
$encrypted = "";
$decrypted = "";

openssl_private_encrypt($data,$encrypted,$pi_key);//˽Կ����
$encrypted = base64_encode($encrypted);//���ܺ������ͨ�����������ַ�����Ҫ����ת���£��������ͨ��url����ʱҪע��base64�����Ƿ���url��ȫ��

openssl_public_decrypt(base64_decode($encrypted),$decrypted,$pu_key);//˽Կ���ܵ�����ͨ����Կ���Խ��ܳ���

openssl_public_encrypt($data,$encrypted,$pu_key);//��Կ����
$encrypted = base64_encode($encrypted);

openssl_private_decrypt(base64_decode($encrypted),$decrypted,$pi_key);//˽Կ����
}