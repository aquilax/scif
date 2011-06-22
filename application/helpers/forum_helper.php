<?php

function q($string){
  return htmlspecialchars($string);}

function slug($text){
  return url_title($text);
}

function render($text){
  //links
  $text =  preg_replace('"\b(https://\S+)"', '<a target="_blank" rel="nofollow" href="$1">$1</a>', $text);
  $text =  preg_replace('"\b(http://\S+)"', '<a target="_blank" rel="nofollow" href="$1">$1</a>', $text);
  //images
  $text =  preg_replace('"i(http://\S+)"', '<img onclick="tgl(this)" onload="rsz(this)" alt="img" src="$1" />', $text);
  return str_replace("\n", '<br />', $text);
}

/**
 * Function from: http://avimedia.livejournal.com/1583.html
 */

function mktripcode($pw){
  $pw=mb_convert_encoding($pw,'SJIS','UTF-8');
  $pw=str_replace('&','&amp;',$pw);
  $pw=str_replace('"','&quot;',$pw);
  $pw=str_replace("'",'&#39;',$pw);
  $pw=str_replace('<','&lt;',$pw);
  $pw=str_replace('>','&gt;',$pw);
    
  $salt=substr($pw.'H.',1,2);
  $salt=preg_replace('/[^.\/0-9:;<=>?@A-Z\[\\\]\^_`a-z]/','.',$salt);
  $salt=strtr($salt,':;<=>?@[\]^_`','ABCDEFGabcdef');
    
  $trip=substr(crypt($pw,$salt),-10);
  return $trip;
}
?>
