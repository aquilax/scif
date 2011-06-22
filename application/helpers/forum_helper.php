<?php

function q($string){
  return htmlspecialchars($string);}

function slug($text){
  $bg = array( 'А','Б','В','Г','Д','Е','Ж','З','И','Й',
               'К','Л','М','Н','О','П','Р','С','Т','У',
               'Ф','Х','Ц','Ч','Ш','Щ','Ъ','Ь','Ю','Я',
               'а','б','в','г','д','е','ж','з','и','й',
               'к','л','м','н','о','п','р','с','т','у',
               'ф','х','ц','ч','ш','щ','ъ','ь','ю','я', ' ',
               '0','1','2','3','4','5','6','7','8','9');
  $en = array( 'A','B','V','G','D','E','J','Z','I','Y',
               'K','L','M','N','O','P','R','S','T','U',
               'F','H','C','CH','SH','SHT','Y','Y','YU','YA',
               'a','b','v','g','d','e','j','z','i','y',
               'k','l','m','n','o','p','r','s','t','u',
               'f','h','c','ch','sh','sht','y','y','yu','ya', '_',
               '0','1','2','3','4','5','6','7','8','9');
  $str =  strtolower(str_replace($bg, $en, $text));
  $str1 = '';
  for($a=0; $a < strlen($str); $a++){
    $c = ord(substr($str,$a,1));
    if (($c >= 48) && ($c <= 57) or
       ($c >= 97) &&  ($c <= 122) or
       ($c == 95)){    
      $str1 .= substr($str,$a,1);
    }
  }
  return substr($str1, 0, 90);
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
