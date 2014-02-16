<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $title?></title> 
<meta name="description" content="<?php echo q($descr)?>" />
<link rel="stylesheet" type="text/css" media="screen" href="/css/sf4.css" />
<link rel="alternate" type="application/rss+xml" title="<?php echo lang('Latest posts')?>" href="<?php echo site_url('feed/rss')?>" /> 
<?php echo $header_text; ?>
</head>
<body itemscope="itemscope" itemtype="http://schema.org/WebPage">
<?php
  if ($analytics){
?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', '<?php echo $analytics; ?>', '<?php echo $_SERVER['SERVER_NAME']?>');
  ga('send', 'pageview');

</script>
<?php
  }
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
