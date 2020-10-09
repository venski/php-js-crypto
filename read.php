<?php
function curl_file_get_contents($durl){
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL, $durl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ;
    curl_setopt($ch, CURLOPT_BINARYTRANSFER, true) ;
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}
//获取路径如https://localhost/[your dir]
$url='https://'.$_SERVER['HTTP_HOST'].$_SERVER["REQUEST_URI"]; 
$fullurl=dirname($url)."/".$_GET['f'];
//访问https://localost/my.php
$text = curl_file_get_contents($fullurl);
//与js端对应的密码16位字符
$key = "0000111122223333";
//高于php7.3+使用
function encodePageByOpenssl($key,$text)
{
    $isStrong=false;
    $ivLength = openssl_cipher_iv_length('aes-128-cbc');
    $iv = openssl_random_pseudo_bytes($ivLength, $isStrong);
    $ciphertext = openssl_encrypt($text, 'aes-128-cbc', $key, true, $iv);
    $msgBase64 = trim(base64_encode($ciphertext));
    return base64_encode($iv)."@".$msgBase64;
}
//低于php7.3使用
function encodePageByMcrypt($key,$text)
{
    $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC), MCRYPT_RAND);
    $ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $text, MCRYPT_MODE_CBC, $iv);
    $msgBase64 = trim(base64_encode($ciphertext));
    return base64_encode($iv)."@".$msgBase64;
}

echo encodePageByMcrypt($key,$text);
 ?>