

function md5(){
  var Crypto = require('crypto');
  var Hash = Crypto.createHash('md5');

  // 可任意多次调用update():
  Hash.update('Hello, world!');
  Hash.update('Hello, nodejs!');
  // 编码
  // 如果不调用digest 默认返回Buffer,否则可使用参数例如: hex | latin1 | base64 分别返回 十六进制,latin1,base64 编码格式
  return Hash.digest('hex'));
}

function sha1(){
  var Crypto = require('crypto');
  var Hash = Crypto.createHash('sha1');

  // 可任意多次调用update():
  Hash.update('Hello, world!');
  Hash.update('Hello, nodejs!');
  // 编码
  // 如果不调用digest 默认返回Buffer,否则可使用参数例如: hex | latin1 | base64 分别返回 十六进制,latin1,base64 编码格式
  return Hash.digest('hex'));
}
var Crypto = require('crypto');
function sha256(){
  
  var Hash = Crypto.createHash('sha256');

  // 可任意多次调用update():
  Hash.update('Hello, world!');
  Hash.update('Hello, nodejs!');
  // 编码
  // 如果不调用digest 默认返回Buffer,否则可使用参数例如: hex | latin1 | base64 分别返回 十六进制,latin1,base64 编码格式
  return Hash.digest('hex'));
}

function sha512(){
  
  var Hash = Crypto.createHash('sha512');

  // 可任意多次调用update():
  Hash.update('Hello, world!');
  Hash.update('Hello, nodejs!');
  // 编码
  // 如果不调用digest 默认返回Buffer,否则可使用参数例如: hex | latin1 | base64 分别返回 十六进制,latin1,base64 编码格式
  return Hash.digest('hex'));
}

function base64(encode){
	var str = "hello,world";
	if(encode){
		var buf = new Buffer(str,"utf8").toString("base64");
		return buf;
	}else{
		return new Buffer(str, 'base64').toString('utf8');
	}
}

function aes(encode){
	var str = "hello,world";
	var keys = {
		crypt_key:"",
		iv:""
	};
	if(encode){
		var cipher = Crypto.createCipheriv('aes-128-cbc', key.crypt_key, key.iv);
		cipher.setAutoPadding(true);
		var bytes = [];
		bytes.push(cipher.update(str));
		bytes.push(cipher.final());
		return Buffer.concat(bytes);
	}else{
		var decipher = Crypto.createDecipheriv('aes-128-cbc', key.crypt_key, key.iv);
		decipher.setAutoPadding(true);
		var bytes = [];
		var error = null;
		try {
			bytes.push(decipher.update(str));
			bytes.push(decipher.final());
		} catch (e) {
			error = e.message;
		} finally{
			if(error){
				return null;
			}else{
				return Buffer.concat(bytes);
			}
		}
	}
}

// 用于RC4 
function Code(string, operation, key, expiry) {
    operation = operation || 'DECODE';
    key = key || 'TGEQ4ZCafbYjoipfwv';
    expiry = expiry || 30;

    // 采用 encodeURI 对字符编码
    string = encodeURI(string);

    // 时间取得
    var now = new Date().getTime() / 1000;
    // Unix 时间戳
    var timestamp = parseInt(now, 10);
    // 毫秒
    var seconds = (now - timestamp) + '';

    var fvzone_auth_key = '';
    var ckey_length = 4;
    key = MD5(key ? key : fvzone_auth_key);
    var keya = MD5(key.substr(0, 16));
    var keyb = MD5(key.substr(16, 16));
    var keyc = ckey_length ? (operation == 'DECODE' ? string.substr(0, ckey_length) : MD5(seconds).substr(-ckey_length)) : '';

    var cryptkey = keya + MD5(keya + keyc);

    if (operation == 'DECODE') {
        string = Base64Decode(string.substr(ckey_length));
    } else {
        string = (expiry ? timestamp + expiry : '0000000000') + MD5(string + keyb).substr(0, 16) + string;
    }

    // RC4 加密原始算法函数
    var result = RC4(cryptkey, string);

    if (operation == 'DECODE') {
        if ((result.substr(0, 10) == 0 || (result.substr(0, 10) - timestamp) > 0) && result.substr(10, 16) == MD5(result.substr(26) + keyb).substr(0, 16)) {
            // 对返回的结果使用 decodeURI 解码
            return decodeURI(result.substr(26));
        } else {
            return '';
        }
    } else {
        return (keyc + Base64Encode(result));
    }
}
function rc4(key,text){
	var s = [];
    for (var i = 0; i < 256; i++) {
        s[i] = i;
    }
    var j = 0, x;
    for (i = 0; i < 256; i++) {
        j = (j + s[i] + key.charCodeAt(i % key.length)) % 256;
        x = s[i];
        s[i] = s[j];
        s[j] = x;
    }
    i = j = 0;
    var ct = [];
    for (var y = 0; y < text.length; y++) {
        i = (i + 1) % 256;
        j = (j + s[i]) % 256;
        x = s[i];
        s[i] = s[j];
        s[j] = x;
        ct.push(String.fromCharCode(text.charCodeAt(y) ^ s[(s[i] + s[j]) % 256]));
    }
    return ct.join('');
}

function RC4(encode){
	var key = "秘钥";
	var buf = new Buffer("hello,world");
	var exp = 0;
	if(encode){
		return Code(buf, 'ENCODE', key, exp);
	}else{
		return Code(buf, 'DECODE', key);
	}
}


function rsaVerify(src_sign, signature, public_key) {
    // 构造PEM编码
    public_key = insert_str(public_key, '\n', 64);
    public_key = '-----BEGIN PUBLIC KEY-----\n' + public_key + '-----END PUBLIC KEY-----';

    var verifier = crypto.createVerify('RSA-SHA1');
    verifier.update(new Buffer(src_sign, 'utf-8'));
    return verifier.verify(public_key, signature, 'base64');
}
/**
 * 在指定位置插入字符串
 * @param str
 * @param insert_str
 * @param sn
 * @returns {string}
 */
function insert_str(str, insert_str, sn) {
    var newstr = "";
    for (var i = 0; i < str.length; i += sn) {
        var tmp = str.substring(i, i + sn);
        newstr += tmp + insert_str;
    }
    return newstr;
}