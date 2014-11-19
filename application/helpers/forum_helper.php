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
               'f','h','c','ch','sh','sht','y','y','yu','ya', '-',
               '0','1','2','3','4','5','6','7','8','9');
  $str =  strtolower(str_replace($bg, $en, $text));
  $str1 = '';
  for($a=0; $a < strlen($str); $a++){
    $c = ord(substr($str, $a, 1));
    if (($c >= 48) && ($c <= 57) or
       ($c >= 97) &&  ($c <= 122) or
       ($c == 95) or ($c == 45)){    
      $str1 .= substr($str, $a, 1);
    }
  }
  return substr($str1, 0, 90);
}

function render($text) {
    return render_new($text);
}

function render_old($text){
  $repl = array(
    '"\b(https://\S+)"' => '<a target="_blank" rel="nofollow" href="$1">$1</a>', //url
    '"\b(http://\S+)"' => '<a target="_blank" rel="nofollow" href="$1">$1</a>', //url
    '"i(http://\S+)"' => '<img onclick="tgl(this)" onload="rsz(this)" alt="img" src="$1" />', //img
    '/^&gt; (.+)/m' => '<blockquote>$1</blockquote>', //blockquote
  );
  $text = preg_replace(array_keys($repl), array_values($repl), $text);
  $o = '';
  $a = explode("\n", $text);
  foreach ($a as $row){
    $row = trim($row);
    if ($row){
      $pre = substr($row, 0, 2);
      if ($pre == '<b' || $pre == '<i'){
        $o .= $row."\n";
      } else {
        $o .= '<p>'.$row."</p>\n";
      }
    }
  }
  return $o;
}

function token() {
    return '$-$'.microtime().'$-$';
}

function isYouTube($url) {
    if (strpos($url, 'youtube.com/watch') !== FALSE) {
        parse_str( parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
        return $my_array_of_vars['v']; 
    }
    return FALSE;
}

function render_new($text) {
    $tokens = array();
    // LINKS
    $text = preg_replace_callback('"\b(http[s]*://\S+)"', function ($matches) use (&$tokens) {
        $url = $matches[1];
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return $url;
        }
        $label = $url;
        $len = strlen($url);
        if ( $len > 80) {
            $label = substr($url, 0, 79).'&hellip;'.substr($url, $len - 10);
        }
        $token = token();
        $youtube = isYouTube($url);
        if ($youtube) {
            $tokens[$token] = sprintf('<div data-video="%s" class="youtube"><img src="http://i.ytimg.com/vi/%s/hqdefault.jpg" class="thumb" alt="thumb" /></div><br/><a href="%s" rel="nofollow" target="_blank">%s</a>', $youtube, $youtube, $url, $label);
        } else {
            $tokens[$token] = sprintf('<a href="%s" rel="nofollow" target="_blank">%s</a>', $url, $label);
        }
        return $token;
    }, $text);
    // IMAGES
    $text = preg_replace_callback('"\bi(http[s]*://\S+)"', function ($matches) use (&$tokens) {
        $url = $matches[1];
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return $url;
        }
        $token = token();
        $tokens[$token] = sprintf('<img onclick="tgl(this)" onload="rsz(this)" alt="img" class="resize" src="%s" />', $url);
        return $token;
    }, $text);
    // BLOCKQUOTE
    $text = preg_replace_callback('/^> (.+)/m', function ($matches) use (&$tokens) {
        $text = $matches[1];
        $token = token();
        $tokens[$token] = sprintf('<blockquote>%s</blockquote>', q($text));
        return $token;
    }, $text);
    // PRE
    $text = preg_replace_callback('/`{3,}(.+)`{3,}/s', function ($matches) use (&$tokens) {
        $text = $matches[1];
        $token = token();
        $tokens[$token] = sprintf('<pre>%s</pre>', q($text));
        return $token;
    }, $text);
    $text = q($text);
    $texta = explode("\n", $text);
    array_walk($texta, function(&$line) {
        if (trim($line)) {
            $line = sprintf('<p>%s</p>', $line);
        }
    });
    $text = str_replace(array_keys($tokens), $tokens, implode("\n", $texta));    
    return $text;
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

function topicDate($date){
  if (!$date){
    return '<td></td>';
  }
  $date = mysql_to_unix($date);
  if (time() - $date < 86400){
    echo '<td class="ar b" title="'.lang('Updated in the last 24h').'">';
  } else {
    echo '<td class="ar">';
  }
  echo date('d.m.Y H:i', $date);
  echo '</td>';
}

?>
