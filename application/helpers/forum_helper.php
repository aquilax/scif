<?php

function q($string){
  return htmlspecialchars($string);}

function slug($text){
  return url_title($text);
}

function render($text){
  return $text;
}

?>
