<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $title?></title> 
<meta name="description" content="<?php echo q($descr)?>" />
<link rel="stylesheet" type="text/css" media="screen" href="/css/sf3.css" />
<link rel="alternate" type="application/rss+xml" title="<?php echo lang('Latest posts')?>" href="<?php echo site_url('feed/rss')?>" /> 
<?php
  if ($analytics){
?>
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', '<?php echo $analytics;?>']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script><?
  }
  echo $header_text;
?>
</head>
<body itemscope="itemscope" itemtype="http://schema.org/WebPage">
<?php
echo '<h1>'.anchor('/', $site_title).'</h1>';
echo '<div id="forum">';
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
echo $pre_posts;
echo $content;
echo $post_posts;
?>
<hr/>
<p class="ar">Powered by <a href="http://github.com/aquilax/scif">scif</a></p>
</div>
</body>
</html>
