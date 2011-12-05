<?php
  $domain = str_replace('www.', '', $_SERVER['HTTP_HOST']);
  $file = $domain.'.ico';
  if (!file_exists($file)){
    $file = 'default.ico';
  }
  $file = file_get_contents($file);
  header('Content-type: 	image/x-icon');
  echo $file;
?>
