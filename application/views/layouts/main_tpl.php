<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<title><?php echo $title?></title> 
<meta name="description" content="<?php echo q($descr)?>" />
<link rel="stylesheet" type="text/css" media="screen" href="/css/sf.css" />
</head>
<body itemscope="itemscope" itemtype="http://schema.org/WebPage">
<?php 
echo '<h1>'.anchor('/', $site_title).'</h1>';
echo '<hr />';
if (isset($path) && count($path) > 1){
  echo '<div id="path" itemprop="breadcrumb">';
  $cnt = count($path);
  foreach($path as $url => $name){
    if ($cnt == 1){
      echo $name;
    } else {
      echo anchor($url, $name)." &raquo; ";
    }
    $cnt--;
  }
  echo '</div>';
  echo '<hr />';
}
echo $content;
?>
<hr/>
<p class="ar">Powered by <a href="http://github.com/aquilax/scif">scif</a></p>
</body>
</html>
